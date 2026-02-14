-- ========================================
-- SignAura Database Schema
-- Database: signaura_db
-- ========================================

-- Create database (run this in MySQL)
-- CREATE DATABASE IF NOT EXISTS signaura_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE signaura_db;

-- ========================================
-- Table: users
-- Stores user authentication and profile data
-- ========================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user' NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Table: history
-- Stores translation/prediction history
-- ========================================
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

-- ========================================
-- Table: user_feedback
-- Stores user feedback and ratings
-- ========================================
CREATE TABLE IF NOT EXISTS user_feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    predicted_text VARCHAR(255) NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    category VARCHAR(50),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_rating (rating),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Insert Default Admin User
-- Username: admin
-- Password: admin123 (CHANGE THIS!)
-- ========================================
INSERT INTO users (username, email, password, role)
VALUES (
    'admin',
    'admin@signaura.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: admin123
    'admin'
) ON DUPLICATE KEY UPDATE username=username;

-- ========================================
-- Sample Test User (Optional)
-- Username: testuser
-- Password: test123
-- ========================================
INSERT INTO users (username, email, password, role)
VALUES (
    'testuser',
    'test@signaura.com',
    '$2y$10$K7p/D9OZn5fGQE5WqZ4Lxu7L8x9vB.wMqN5oRqTdYcJ3xG8hQ7mYq', -- password: test123
    'user'
) ON DUPLICATE KEY UPDATE username=username;

-- ========================================
-- Show Tables (Verification)
-- ========================================
-- SHOW TABLES;
-- DESCRIBE users;
-- DESCRIBE history;
-- DESCRIBE user_feedback;
