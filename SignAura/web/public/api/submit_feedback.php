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
    
    if (!$input) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON data']);
        exit();
    }
    
    // Extract feedback data
    $sentence_id = $input['sentence_id'] ?? null;
    $is_correct = $input['is_correct'] ?? null;
    $correct_text = $input['correct_text'] ?? '';
    $rating = $input['rating'] ?? 0;
    $message = $input['message'] ?? '';
    
    // Validate
    if (!$sentence_id || $rating < 1 || $rating > 5 || $is_correct === null) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid feedback data']);
        exit();
    }
    
    // Insert feedback
    $sql = "INSERT INTO user_feedback (user_id, predicted_text, rating, category, message, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    
    // For now, use sentence_id as predicted_text or something, but since table doesn't have new columns, temporarily use message for correct_text
    $predicted_text = "Sentence ID: $sentence_id";
    $category = $is_correct ? 'correct' : 'incorrect';
    $full_message = $message;
    if (!$is_correct && !empty($correct_text)) {
        $full_message .= " | Correct: $correct_text";
    }
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isiss", $user_id, $predicted_text, $rating, $category, $full_message);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            'success' => true,
            'message' => 'Feedback submitted successfully'
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save feedback']);
    }
    
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
