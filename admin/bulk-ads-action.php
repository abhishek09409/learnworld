<?php
/**
 * =====================================================
 * BULK ADS ACTION HANDLER
 * =====================================================
 * Handles bulk operations on generated ads
 */

session_start();
include '../includes/config.php';

// Check if admin is logged in
if(!isset($_SESSION['user_id'])){
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

$action = $input['action'] ?? '';
$ids = $input['ids'] ?? [];

// Validate
if(empty($action) || empty($ids) || !is_array($ids)) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// Sanitize IDs
$ids = array_map('intval', $ids);
$idsStr = implode(',', $ids);

// User ID check
$userId = $_SESSION['user_id'];

switch($action) {
    case 'activate':
        handleActivate($idsStr, $userId);
        break;
    case 'deactivate':
        handleDeactivate($idsStr, $userId);
        break;
    case 'delete':
        handleDelete($idsStr, $userId);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

/**
 * Activate ads
 */
function handleActivate($idsStr, $userId) {
    global $conn;
    
    $query = "UPDATE escorts SET status='active' WHERE id IN ($idsStr) AND user_id=$userId";
    
    if($conn->query($query)) {
        $affected = $conn->affected_rows;
        echo json_encode([
            'success' => true,
            'message' => "Activated $affected ads"
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to activate ads'
        ]);
    }
}

/**
 * Deactivate ads
 */
function handleDeactivate($idsStr, $userId) {
    global $conn;
    
    $query = "UPDATE escorts SET status='pending' WHERE id IN ($idsStr) AND user_id=$userId";
    
    if($conn->query($query)) {
        $affected = $conn->affected_rows;
        echo json_encode([
            'success' => true,
            'message' => "Deactivated $affected ads"
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to deactivate ads'
        ]);
    }
}

/**
 * Delete ads
 */
function handleDelete($idsStr, $userId) {
    global $conn;
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Get images first
        $getImagesQuery = "SELECT profile_image FROM escorts WHERE id IN ($idsStr) AND user_id=$userId";
        $result = $conn->query($getImagesQuery);
        
        $imagesToDelete = [];
        while($row = $result->fetch_assoc()) {
            if(!empty($row['profile_image'])) {
                $imagesToDelete[] = $row['profile_image'];
            }
        }
        
        // Delete ads
        $query = "DELETE FROM escorts WHERE id IN ($idsStr) AND user_id=$userId";
        $conn->query($query);
        
        $affected = $conn->affected_rows;
        
        // Delete associated images from filesystem
        foreach($imagesToDelete as $imagePath) {
            $fullPath = '../' . ltrim($imagePath, '/');
            if(file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }
        
        $conn->commit();
        
        echo json_encode([
            'success' => true,
            'message' => "Deleted $affected ads"
        ]);
        
    } catch(Exception $e) {
        $conn->rollback();
        echo json_encode([
            'success' => false,
            'message' => 'Failed to delete ads: ' . $e->getMessage()
        ]);
    }
}
