<?php
require_once __DIR__ . "/auth.php";
require_once __DIR__ . "/../../db.php";

// Check if ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "❌ User ID is required";
    header("Location: users.php");
    exit();
}

$user_id = mysqli_real_escape_string($conn, $_GET['id']);

// Get current admin info
$current_user_id = $_SESSION['user_id'];

// Prevent deleting yourself
if($user_id == $current_user_id) {
    $_SESSION['error'] = "❌ You cannot delete your own account!";
    header("Location: users.php");
    exit();
}

// Check if user exists and get their info
$check = mysqli_query($conn, "SELECT id, username, role FROM users WHERE id='$user_id'");
if(mysqli_num_rows($check) == 0) {
    $_SESSION['error'] = "❌ User not found";
    header("Location: users.php");
    exit();
}

$user_to_delete = mysqli_fetch_assoc($check);

// Delete the user (history and feedback will be deleted automatically due to ON DELETE CASCADE)
$delete = mysqli_query($conn, "DELETE FROM users WHERE id='$user_id'");

if($delete) {
    $role_badge = $user_to_delete['role'] === 'admin' ? '👑 Admin' : '👤 User';
    $_SESSION['success'] = "✅ User '{$user_to_delete['username']}' ($role_badge) has been deleted successfully!";
} else {
    $_SESSION['error'] = "❌ Failed to delete user: " . mysqli_error($conn);
}

header("Location: users.php");
exit();
?>
