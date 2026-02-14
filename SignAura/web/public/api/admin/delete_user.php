<?php
session_start();
header('Content-Type: application/json');

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden - Admin access required']);
    exit();
}

require_once __DIR__ . '/../../db.php';

try {
    // Get POST data
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['user_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing user_id']);
        exit();
    }
    
    $user_id = (int)$input['user_id'];
    
    // Prevent admin from deleting themselves
    if ($user_id === $_SESSION['user_id']) {
        http_response_code(400);
        echo json_encode(['error' => 'Cannot delete your own account']);
        exit();
    }
    
    // Delete user (CASCADE will delete related history and feedback)
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to delete user']);
    }
    
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
