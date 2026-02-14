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
    
    $sentence_en = $input['sentence_en'] ?? '';
    $sentence_si = $input['sentence_si'] ?? '';
    $sentence_ta = $input['sentence_ta'] ?? '';
    $sign_count = $input['sign_count'] ?? 0;
    $avg_confidence = $input['avg_confidence'] ?? 0.0;
    $prediction_ids = $input['prediction_ids'] ?? []; // Array of history IDs belonging to this sentence

    if (empty($sentence_en) && empty($sign_count)) {
         http_response_code(400);
         echo json_encode(['error' => 'Empty sentence']);
         exit();
    }

    // Start transaction
    mysqli_begin_transaction($conn);

    // 1. Insert into sentences table
    $sql = "INSERT INTO sentences (user_id, sentence_en, sentence_si, sentence_ta, sign_count, avg_confidence, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssid", $user_id, $sentence_en, $sentence_si, $sentence_ta, $sign_count, $avg_confidence);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Failed to save sentence");
    }
    
    $sentence_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    // 2. Update history table with sentence_id
    if (!empty($prediction_ids)) {
        // Safe implementation using prepared statement not easily possible with IN (?) for array
        // But since IDs are integers, we can sanitize them manually.
        $ids_str = implode(',', array_map('intval', $prediction_ids));
        
        if (!empty($ids_str)) {
             $update_sql = "UPDATE history SET sentence_id = $sentence_id WHERE id IN ($ids_str) AND user_id = $user_id";
             if (!mysqli_query($conn, $update_sql)) {
                 throw new Exception("Failed to link history records");
             }
        }
    }

    mysqli_commit($conn);

    echo json_encode([
        'success' => true,
        'message' => 'Sentence saved successfully',
        'sentence_id' => $sentence_id
    ]);

} catch (Exception $e) {
    mysqli_rollback($conn);
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
