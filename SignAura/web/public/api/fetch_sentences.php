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
    
    // Get sentence history for this user
    $sql = "SELECT id, sentence_en, sentence_si, sentence_ta, 
                   sign_count, avg_confidence, created_at 
            FROM sentences 
            WHERE user_id = ? 
            ORDER BY created_at DESC 
            LIMIT 50";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $sentences = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Format date nicely
        $row['date_formatted'] = date('M j, Y, g:i a', strtotime($row['created_at']));
        // Format confidence
        $row['accuracy'] = round($row['avg_confidence'] * 100, 1);
        $sentences[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'sentences' => $sentences,
        'count' => count($sentences)
    ]);
    
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
