<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit();
}

require_once __DIR__ . '/../../db.php';

try {
    $user_id = $_SESSION['user_id'];
    
    $sql = "SELECT id, predicted_text, rating, category, message, created_at 
            FROM user_feedback 
            WHERE user_id = ? 
            ORDER BY created_at DESC 
            LIMIT 50";
            
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $feedback = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['date_formatted'] = date('M j, Y', strtotime($row['created_at']));
        $feedback[] = $row;
    }
    
    echo json_encode(['success' => true, 'feedback' => $feedback]);
    mysqli_stmt_close($stmt);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
?>
