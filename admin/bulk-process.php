<?php
/**
 * =====================================================
 * BULK AD PROCESSOR
 * =====================================================
 * Handles bulk ad generation requests
 * Processes form data and inserts ads into database
 */

session_start();
include '../includes/config.php';

// Check if admin is logged in
if(!isset($_SESSION['user_id'])){
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Load ContentGenerator
require_once '../includes/ContentGenerator.php';
$generator = new ContentGenerator($conn);

// Get action
$action = $_POST['action'] ?? '';

if($action === 'preview') {
    handlePreview();
} elseif($action === 'generate') {
    handleGenerate();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

/**
 * Handle Preview Request
 */
function handlePreview() {
    global $generator, $conn;
    
    try {
        // Get form data
        $params = getFormParams();
        
        // Generate 3 sample ads
        $ads = $generator->generateBulkAds(3, $params);
        
        echo json_encode([
            'success' => true,
            'ads' => $ads
        ]);
        
    } catch(Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

/**
 * Handle Generate Request
 */
function handleGenerate() {
    global $generator, $conn, $_SESSION;
    
    try {
        // Start transaction
        $conn->begin_transaction();
        
        // Get form data
        $params = getFormParams();
        $count = intval($_POST['count'] ?? 10);
        
        // Validate count
        if($count < 1 || $count > 1000) {
            throw new Exception('Invalid count. Must be between 1 and 1000');
        }
        
        // Create batch record
        $batchId = createBatch($count, $params);
        
        // Generate ads
        $ads = $generator->generateBulkAds($count, $params);
        
        // Process phone numbers
        $ads = processPhoneNumbers($ads, $_POST);
        
        // Insert ads into database
        $insertedCount = insertAds($ads, $_POST);
        
        // Update batch status
        updateBatch($batchId, $insertedCount);
        
        // Commit transaction
        $conn->commit();
        
        echo json_encode([
            'success' => true,
            'count' => $insertedCount,
            'batch_id' => $batchId,
            'message' => "Successfully generated {$insertedCount} ads"
        ]);
        
    } catch(Exception $e) {
        // Rollback on error
        $conn->rollback();
        
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

/**
 * Get form parameters
 */
function getFormParams() {
    global $conn;
    
    $category = trim($_POST['category'] ?? '');
    $stateId = intval($_POST['state'] ?? 0);
    $city = trim($_POST['city'] ?? '');
    $ageMin = intval($_POST['age_min'] ?? 21);
    $ageMax = intval($_POST['age_max'] ?? 32);
    
    // Debug: Log received values (remove in production)
    // error_log("category=$category, state=$stateId, city=$city");
    
    // Validate category and state
    if(empty($category) || !$stateId) {
        throw new Exception('Missing required fields: category or state empty');
    }
    
    // Validate city - can be ID or name
    if(empty($city)) {
        throw new Exception('Missing required fields: city not selected');
    }
    
    // Check if city is numeric (ID) or string (name)
    $cityId = 0;
    $cityName = '';
    
    if(is_numeric($city)) {
        // City sent as ID
        $cityId = intval($city);
        $cityQuery = $conn->query("SELECT name FROM cities WHERE id=$cityId");
        if($cityQuery && $cityQuery->num_rows > 0) {
            $cityName = $cityQuery->fetch_assoc()['name'];
        } else {
            // ID not found, use as name
            $cityName = $city;
            $cityId = $stateId; // fallback
        }
    } else {
        // City sent as name/slug
        $cityName = $city;
        $escapedCity = $conn->real_escape_string($city);
        $cityQuery = $conn->query("SELECT id, name FROM cities WHERE name='$escapedCity' OR slug='$escapedCity' LIMIT 1");
        if($cityQuery && $cityQuery->num_rows > 0) {
            $row = $cityQuery->fetch_assoc();
            $cityId = $row['id'];
            $cityName = $row['name'];
        } else {
            // City name not in DB, use it directly
            $cityId = 0;
            $cityName = ucfirst($city);
        }
    }
    
    // Fallback city name
    if(empty($cityName)) {
        $cityName = 'Unknown City';
    }
    
    if($ageMin < 18 || $ageMax < 18 || $ageMin > $ageMax) {
        throw new Exception('Invalid age range. Min must be 18+');
    }
    
    // Random age in range
    $age = rand($ageMin, $ageMax);
    
    return [
        'category' => $category,
        'state_id' => $stateId,
        'city_id' => $cityId,
        'city_name' => $cityName,
        'city_slug' => strtolower(str_replace(' ', '-', $cityName)),
        'age' => $age,
        'age_min' => $ageMin,
        'age_max' => $ageMax,
        'user_id' => $_SESSION['user_id']
    ];
}

/**
 * Create batch record
 */
function createBatch($count, $params) {
    global $conn, $_SESSION;
    
    $userId = $_SESSION['user_id'];
    $category = $params['category'];
    
    $query = "INSERT INTO bulk_batches (user_id, category_slug, total_ads, status) 
              VALUES ($userId, '$category', $count, 'processing')";
    
    $conn->query($query);
    
    return $conn->insert_id;
}

/**
 * Update batch status
 */
function updateBatch($batchId, $count) {
    global $conn;
    
    $now = date('Y-m-d H:i:s');
    
    $query = "UPDATE bulk_batches 
              SET generated_ads=$count, status='completed', completed_at='$now' 
              WHERE id=$batchId";
    
    $conn->query($query);
}

/**
 * Process phone numbers based on mode
 */
function processPhoneNumbers($ads, $postData) {
    
    $phoneMode = $postData['phone_mode'] ?? 'single';
    
    if($phoneMode === 'single') {
        // Single phone for all ads
        $phone = $postData['phone_single'] ?? '';
        
        if(!empty($phone) && preg_match('/^[0-9]{10}$/', $phone)) {
            foreach($ads as &$ad) {
                $ad['phone'] = $phone;
            }
        }
        
    } elseif($phoneMode === 'list') {
        // Rotate through list
        $phoneList = $postData['phone_list'] ?? '';
        $phones = array_filter(array_map('trim', explode("\n", $phoneList)));
        
        if(!empty($phones)) {
            $phoneCount = count($phones);
            foreach($ads as $index => &$ad) {
                $ad['phone'] = $phones[$index % $phoneCount];
            }
        }
        
    } elseif($phoneMode === 'random') {
        // Random phones already generated by ContentGenerator
        // No action needed
    }
    
    return $ads;
}

/**
 * Insert ads into database
 */
function insertAds($ads, $postData) {
    global $conn;
    
    $autoPublish = isset($postData['auto_publish']);
    $addDelay = isset($postData['add_delay']);
    
    $insertedCount = 0;
    
    foreach($ads as $ad) {
        
        // Set status
        $status = $autoPublish ? 'active' : 'pending';
        
        // Escape values
        $userId = intval($ad['user_id']);
        $category = $conn->real_escape_string($ad['category_slug']);
        $stateId = intval($ad['state_id']);
        $cityId = intval($ad['city_id'] ?? 0);
        $citySlug = $conn->real_escape_string($ad['city_slug'] ?? $ad['city_name'] ?? '');
        $title = $conn->real_escape_string($ad['title']);
        $slug = $conn->real_escape_string($ad['slug']);
        $description = $conn->real_escape_string($ad['description']);
        $age = intval($ad['age']);
        $phone = $conn->real_escape_string($ad['phone']);
        $profileImage = $ad['profile_image'] ?? '';
        
        // Build query
        $query = "INSERT INTO escorts 
                  (user_id, category_slug, state_id, city_slug, title, slug, description, 
                   age, phone, telegram, whatsapp, status, profile_image, created_at) 
                  VALUES 
                  ($userId, '$category', $stateId, '$citySlug', '$title', '$slug', '$description', 
                   $age, '$phone', '', '', '$status', '$profileImage', NOW())";
        
        if($conn->query($query)) {
            $insertedCount++;
            
            // Add random delay if enabled (0.1 to 0.5 seconds)
            if($addDelay) {
                usleep(rand(100000, 500000));
            }
        }
    }
    
    return $insertedCount;
}
