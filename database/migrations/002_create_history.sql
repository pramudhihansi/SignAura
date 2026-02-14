-- Migration: Create history table
-- Date: 2026-01-17
-- Description: Store translation/prediction history

CREATE TABLE IF NOT EXISTS history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    predicted_sign_en VARCHAR(255) NOT NULL,
    predicted_sign_si VARCHAR(255) NOT NULL,
    predicted_sign_ta VARCHAR(255) NOT NULL,
    confidence FLOAT NOT NULL DEFAULT 0.0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
