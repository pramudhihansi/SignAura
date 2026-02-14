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
    
    // Get translation history for this user
    $sql = "SELECT id, predicted_sign_en, predicted_sign_si, predicted_sign_ta, 
                   confidence, created_at 
            FROM history 
            WHERE user_id = ? 
            ORDER BY created_at DESC 
            LIMIT 100";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $history = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $history[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'history' => $history,
        'count' => count($history)
    ]);
    
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
