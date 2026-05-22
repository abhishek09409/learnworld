<?php
/**
 * =====================================================
 * BULK IMAGE HANDLER
 * =====================================================
 * Handles image upload, deletion, and assignment to ads
 */

session_start();
include '../includes/config.php';

// Check if admin is logged in
if(!isset($_SESSION['user_id'])){
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? '';

switch($action) {
    case 'upload':
        handleUpload();
        break;
    case 'list':
        handleList();
        break;
    case 'delete':
        handleDelete();
        break;
    case 'assign':
        handleAssign();
        break;
    case 'stats':
        handleStats();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

/**
 * Handle image upload
 */
function handleUpload() {
    
    if(!isset($_FILES['images'])) {
        echo json_encode(['success' => false, 'message' => 'No images uploaded']);
        return;
    }
    
    $files = $_FILES['images'];
    $uploadDir = '../uploads/bulk-images/';
    
    // Create directory if not exists
    if(!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $uploadedCount = 0;
    $errors = [];
    
    // Process each file
    for($i = 0; $i < count($files['name']); $i++) {
        
        $filename = $files['name'][$i];
        $tmpName = $files['tmp_name'][$i];
        $fileSize = $files['size'][$i];
        $fileError = $files['error'][$i];
        
        // Skip if error
        if($fileError !== UPLOAD_ERR_OK) {
            $errors[] = "Failed to upload $filename";
            continue;
        }
        
        // Validate file type
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $tmpName);
        finfo_close($finfo);
        
        if(!in_array($mimeType, $allowed)) {
            $errors[] = "$filename is not a valid image";
            continue;
        }
        
        // Validate file size (max 5MB)
        if($fileSize > 5 * 1024 * 1024) {
            $errors[] = "$filename exceeds 5MB limit";
            continue;
        }
        
        // Generate unique filename
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $newFilename = uniqid() . '_' . time() . '.' . $ext;
        $destination = $uploadDir . $newFilename;
        
        // Move file
        if(move_uploaded_file($tmpName, $destination)) {
            
            // Resize image if needed
            resizeImage($destination, 800, 800);
            
            $uploadedCount++;
        } else {
            $errors[] = "Failed to save $filename";
        }
    }
    
    echo json_encode([
        'success' => true,
        'count' => $uploadedCount,
        'errors' => $errors
    ]);
}

/**
 * Resize image to max dimensions
 */
function resizeImage($file, $maxWidth, $maxHeight) {
    
    list($width, $height, $type) = getimagesize($file);
    
    // Skip if already smaller
    if($width <= $maxWidth && $height <= $maxHeight) {
        return;
    }
    
    // Calculate new dimensions
    $ratio = min($maxWidth / $width, $maxHeight / $height);
    $newWidth = intval($width * $ratio);
    $newHeight = intval($height * $ratio);
    
    // Create source image
    switch($type) {
        case IMAGETYPE_JPEG:
            $source = imagecreatefromjpeg($file);
            break;
        case IMAGETYPE_PNG:
            $source = imagecreatefrompng($file);
            break;
        case IMAGETYPE_WEBP:
            $source = imagecreatefromwebp($file);
            break;
        default:
            return;
    }
    
    // Create resized image
    $resized = imagecreatetruecolor($newWidth, $newHeight);
    
    // Preserve transparency for PNG
    if($type === IMAGETYPE_PNG) {
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
    }
    
    // Resize
    imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
    // Save
    switch($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($resized, $file, 85);
            break;
        case IMAGETYPE_PNG:
            imagepng($resized, $file, 8);
            break;
        case IMAGETYPE_WEBP:
            imagewebp($resized, $file, 85);
            break;
    }
    
    // Free memory
    imagedestroy($source);
    imagedestroy($resized);
}

/**
 * List all images
 */
function handleList() {
    
    $uploadDir = '../uploads/bulk-images/';
    
    if(!file_exists($uploadDir)) {
        echo json_encode(['success' => true, 'images' => []]);
        return;
    }
    
    $images = [];
    $files = scandir($uploadDir);
    
    foreach($files as $file) {
        if($file === '.' || $file === '..') continue;
        
        $path = $uploadDir . $file;
        
        if(is_file($path)) {
            $images[] = [
                'filename' => $file,
                'path' => '/uploads/bulk-images/' . $file,
                'size' => filesize($path),
                'uploaded' => date('Y-m-d H:i:s', filemtime($path))
            ];
        }
    }
    
    // Sort by newest first
    usort($images, function($a, $b) {
        return strtotime($b['uploaded']) - strtotime($a['uploaded']);
    });
    
    echo json_encode([
        'success' => true,
        'images' => $images
    ]);
}

/**
 * Delete image
 */
function handleDelete() {
    
    $filename = $_GET['filename'] ?? '';
    
    if(empty($filename)) {
        echo json_encode(['success' => false, 'message' => 'No filename provided']);
        return;
    }
    
    // Sanitize filename
    $filename = basename($filename);
    $filePath = '../uploads/bulk-images/' . $filename;
    
    if(!file_exists($filePath)) {
        echo json_encode(['success' => false, 'message' => 'File not found']);
        return;
    }
    
    if(unlink($filePath)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete']);
    }
}

/**
 * Assign images to ads without images
 */
function handleAssign() {
    global $conn;
    
    $uploadDir = '../uploads/bulk-images/';
    
    if(!file_exists($uploadDir)) {
        echo json_encode(['success' => false, 'message' => 'No images in pool']);
        return;
    }
    
    // Get all images
    $images = [];
    $files = scandir($uploadDir);
    
    foreach($files as $file) {
        if($file === '.' || $file === '..') continue;
        
        $path = $uploadDir . $file;
        if(is_file($path)) {
            $images[] = $file;
        }
    }
    
    if(empty($images)) {
        echo json_encode(['success' => false, 'message' => 'No images in pool']);
        return;
    }
    
    // Get ads without images
    $query = "SELECT id FROM escorts WHERE (profile_image IS NULL OR profile_image = '') AND status='active' LIMIT 1000";
    $result = $conn->query($query);
    
    if($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'No ads found without images']);
        return;
    }
    
    $assignedCount = 0;
    $imageCount = count($images);
    $imageIndex = 0;
    
    // Assign images randomly
    while($row = $result->fetch_assoc()) {
        
        $adId = $row['id'];
        
        // Pick random image (or sequential)
        $imagePath = '/uploads/bulk-images/' . $images[$imageIndex % $imageCount];
        $imageIndex++;
        
        // Update ad
        $escapedPath = $conn->real_escape_string($imagePath);
        $updateQuery = "UPDATE escorts SET profile_image='$escapedPath' WHERE id=$adId";
        
        if($conn->query($updateQuery)) {
            $assignedCount++;
        }
    }
    
    echo json_encode([
        'success' => true,
        'assigned_count' => $assignedCount,
        'message' => "Assigned images to $assignedCount ads"
    ]);
}

/**
 * Get statistics
 */
function handleStats() {
    global $conn;
    
    $uploadDir = '../uploads/bulk-images/';
    
    // Count images
    $imageCount = 0;
    if(file_exists($uploadDir)) {
        $files = scandir($uploadDir);
        foreach($files as $file) {
            if($file !== '.' && $file !== '..' && is_file($uploadDir . $file)) {
                $imageCount++;
            }
        }
    }
    
    // Count ads without images
    $query = "SELECT COUNT(*) as count FROM escorts WHERE (profile_image IS NULL OR profile_image = '') AND status='active'";
    $result = $conn->query($query);
    $adsWithoutImages = $result->fetch_assoc()['count'];
    
    echo json_encode([
        'success' => true,
        'total_images' => $imageCount,
        'ads_without_images' => $adsWithoutImages
    ]);
}
