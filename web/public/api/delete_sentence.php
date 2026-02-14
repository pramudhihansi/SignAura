<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit();
}

require_once __DIR__ . '/../../db.php';

try {
    $user_id = $_SESSION['user_id'];
    
    // Get POST data
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['sentence_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid data']);
        exit();
    }
    
    $sentence_id = intval($input['sentence_id']);
    
    // Delete only if belongs to user
    $sql = "DELETE FROM history WHERE id = ? AND user_id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $sentence_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo json_encode(['success' => true, 'message' => 'Sentence deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Sentence not found or not owned by user']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to delete']);
    }
    
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?></content>
<parameter name="filePath">D:\projects\SignAura\web\public\api\delete_sentence.php