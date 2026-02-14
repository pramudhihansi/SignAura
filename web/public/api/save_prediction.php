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
    
    // Extract prediction data
    $predicted_en = $input['predictions']['english'] ?? '';
    $predicted_si = $input['predictions']['sinhala'] ?? '';
    $predicted_ta = $input['predictions']['tamil'] ?? '';
    $confidence = $input['confidence'] ?? 0.0;
    
    // Validate
    if (empty($predicted_en)) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing prediction data']);
        exit();
    }
    
    // Insert into history table
    $sql = "INSERT INTO history (user_id, predicted_sign_en, predicted_sign_si, predicted_sign_ta, confidence, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssd", $user_id, $predicted_en, $predicted_si, $predicted_ta, $confidence);
    
    if (mysqli_stmt_execute($stmt)) {
        $prediction_id = mysqli_insert_id($conn);
        
        echo json_encode([
            'success' => true,
            'message' => 'Prediction saved successfully',
            'prediction_id' => $prediction_id
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save prediction']);
    }
    
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
