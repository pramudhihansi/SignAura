<?php
// Load environment variables from .env file
$env_file = __DIR__ . '/.env';
if (file_exists($env_file)) {
    $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && $line[0] !== '#') {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Debug: Check if .env loaded (remove this later)
// file_put_contents('debug.log', "DB_HOST: " . ($_ENV['DB_HOST'] ?? 'NOT SET') . "\n", FILE_APPEND);
// file_put_contents('debug.log', "DB_USER: " . ($_ENV['DB_USER'] ?? 'NOT SET') . "\n", FILE_APPEND);
// file_put_contents('debug.log', "DB_PASSWORD: " . (isset($_ENV['DB_PASSWORD']) ? 'SET' : 'NOT SET') . "\n", FILE_APPEND);

// Database connection with environment variables
$db_host = $_ENV['DB_HOST'] ?? 'localhost';
$db_user = $_ENV['DB_USER'] ?? 'root';
$db_pass = $_ENV['DB_PASSWORD'] ?? '';
$db_name = $_ENV['DB_NAME'] ?? 'signaura_db';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

function escape_string($conn, $value) {
    return mysqli_real_escape_string($conn, trim($value));
}
?>
