-- Migration: Create sentences table and update history
-- Date: 2026-01-22
-- Description: Store completed sentences and link history items

CREATE TABLE IF NOT EXISTS sentences (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add sentence_id to history table if it doesn't exist
SET @dbname = DATABASE();
SET @tablename = "history";
SET @columnname = "sentence_id";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  "ALTER TABLE history ADD COLUMN sentence_id INT DEFAULT NULL, ADD FOREIGN KEY (sentence_id) REFERENCES sentences(id) ON DELETE SET NULL;"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;
