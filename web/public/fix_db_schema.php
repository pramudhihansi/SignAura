<?php
require_once __DIR__ . '/../db.php';

echo "<h2>Fixing Database Schema...</h2><pre>";

// 1. Create 'sentences' table
$sql_create_sentences = "CREATE TABLE IF NOT EXISTS sentences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    sentence_en TEXT NOT NULL,
    sentence_si TEXT NOT NULL,
    sentence_ta TEXT NOT NULL,
    sign_count INT NOT NULL DEFAULT 0,
    avg_confidence FLOAT NOT NULL DEFAULT 0.0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if (mysqli_query($conn, $sql_create_sentences)) {
    echo "✅ Table 'sentences' checked/created successfully.\n";
} else {
    echo "❌ Error creating 'sentences' table: " . mysqli_error($conn) . "\n";
}

// 2. Add 'sentence_id' to 'history' table if missing
$result = mysqli_query($conn, "SHOW COLUMNS FROM history LIKE 'sentence_id'");
if (mysqli_num_rows($result) == 0) {
    echo "Column 'sentence_id' missing in 'history'. Adding it...\n";
    $sql_alter_history = "ALTER TABLE history ADD COLUMN sentence_id INT DEFAULT NULL, ADD FOREIGN KEY (sentence_id) REFERENCES sentences(id) ON DELETE SET NULL;";
    
    if (mysqli_query($conn, $sql_alter_history)) {
        echo "✅ Column 'sentence_id' added to 'history' successfully.\n";
    } else {
        echo "❌ Error adding 'sentence_id' to 'history': " . mysqli_error($conn) . "\n";
    }
} else {
    echo "✅ Column 'sentence_id' already exists in 'history'.\n";
}

mysqli_close($conn);
echo "\nDatabase schema update complete.</pre>";
?>
