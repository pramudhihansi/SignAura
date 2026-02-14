# SignAura Database Documentation

## Overview

The SignAura database (`signaura_db`) uses MySQL 8.x with UTF-8 encoding to support multilingual content (English, Sinhala, Tamil).

## Quick Setup

### Option 1: Using phpMyAdmin (XAMPP)

1. Open http://localhost/phpmyadmin
2. Click "New" to create database
3. Database name: `signaura_db`
4. Collation: `utf8mb4_unicode_ci`
5. Click "Import" tab
6. Choose file: `schema.sql`
7. Click "Go"

### Option 2: MySQL Command Line

```cmd
cd database
mysql -u root -p
```

```sql
CREATE DATABASE signaura_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE signaura_db;
source schema.sql;
exit;
```

### Option 3: Windows PowerShell

```powershell
Get-Content schema.sql | mysql -u root -p signaura_db
```

## Database Schema

### Tables

#### 1. `users`
Stores user authentication and profile data.

| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK, AUTO_INCREMENT) | User ID |
| username | VARCHAR(50) UNIQUE | Username for login |
| email | VARCHAR(100) UNIQUE | Email address |
| password | VARCHAR(255) | Hashed password (bcrypt) |
| role | ENUM('user', 'admin') | User role |
| created_at | TIMESTAMP | Account creation time |
| updated_at | TIMESTAMP | Last update time |

**Indexes:** username, email, role

#### 2. `history`
Stores translation/prediction history.

| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK, AUTO_INCREMENT) | History ID |
| user_id | INT (FK → users.id) | User who made prediction |
| predicted_sign_en | VARCHAR(255) | English translation |
| predicted_sign_si | VARCHAR(255) | Sinhala translation |
| predicted_sign_ta | VARCHAR(255) | Tamil translation |
| confidence | FLOAT | ML model confidence (0-1) |
| created_at | TIMESTAMP | Prediction timestamp |

**Indexes:** user_id, created_at  
**Foreign Key:** CASCADE delete when user deleted

#### 3. `user_feedback`
Stores user feedback and ratings.

| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK, AUTO_INCREMENT) | Feedback ID |
| user_id | INT (FK → users.id) | User who gave feedback |
| predicted_text | VARCHAR(255) | Text that was predicted |
| rating | INT (1-5) | Star rating |
| category | VARCHAR(50) | Feedback category |
| message | TEXT | Feedback message |
| created_at | TIMESTAMP | Feedback timestamp |

**Indexes:** user_id, rating, created_at  
**Foreign Key:** CASCADE delete when user deleted

## Default Users

After running `schema.sql`, these users are created:

| Username | Password | Role | Email |
|----------|----------|------|-------|
| admin | admin123 | admin | admin@signaura.com |
| testuser | test123 | user | test@signaura.com |

⚠️ **SECURITY:** Change the admin password immediately!

## Changing Admin Password

```sql
USE signaura_db;
UPDATE users 
SET password = '$2y$10$NEW_HASH_HERE' 
WHERE username = 'admin';
```

Or create a new password in PHP:
```php
<?php
echo password_hash('your_new_password', PASSWORD_DEFAULT);
?>
```

## Useful Queries

### View all users
```sql
SELECT id, username, email, role, created_at FROM users;
```

### View recent predictions
```sql
SELECT h.*, u.username 
FROM history h 
JOIN users u ON h.user_id = u.id 
ORDER BY h.created_at DESC 
LIMIT 20;
```

### View feedback with ratings
```sql
SELECT f.*, u.username 
FROM user_feedback f 
JOIN users u ON f.user_id = u.id 
WHERE f.rating >= 4 
ORDER BY f.created_at DESC;
```

### User statistics
```sql
SELECT 
    u.username,
    COUNT(DISTINCT h.id) as total_predictions,
    AVG(h.confidence) as avg_confidence,
    COUNT(DISTINCT f.id) as feedback_count
FROM users u
LEFT JOIN history h ON u.id = h.user_id
LEFT JOIN user_feedback f ON u.id = f.user_id
GROUP BY u.id, u.username;
```

## Maintenance

### Backup Database
```cmd
mysqldump -u root -p signaura_db > backup_YYYYMMDD.sql
```

### Restore Database
```cmd
mysql -u root -p signaura_db < backup_YYYYMMDD.sql
```

### Clear History (Keep Users)
```sql
TRUNCATE TABLE history;
TRUNCATE TABLE user_feedback;
```

## Troubleshooting

### Connection Failed
- Ensure MySQL is running in XAMPP Control Panel
- Check credentials in `web/.env`
- Default: localhost, root, no password

### Tables Don't Exist
- Run `schema.sql` again
- Check MySQL error log in `C:\xampp\mysql\data\`

### UTF-8 Encoding Issues
- Ensure database collation: `utf8mb4_unicode_ci`
- Check PHP file encoding: UTF-8 (no BOM)
- Verify MySQL connection charset: `utf8mb4`
