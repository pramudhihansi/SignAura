<?php
require_once "../db.php";

$message = "";
$debug_info = "";

if(isset($_POST['signup'])) {
    $username = escape_string($conn, $_POST['username']);
    $email = escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $role = isset($_POST['role']) ? $_POST['role'] : 'user';
    
    $debug_info = "<div style='background:#f0f0f0;padding:15px;margin:15px 0;border-radius:8px;'>";
    $debug_info .= "<h4>🔍 Debug Info:</h4>";
    $debug_info .= "<strong>POST data:</strong><br>";
    $debug_info .= "- username: $username<br>";
    $debug_info .= "- email: $email<br>";
    $debug_info .= "- password: [hidden]<br>";
    $debug_info .= "- confirm: [hidden]<br>";
    $debug_info .= "- role: <span style='color:red;font-weight:bold'>$role</span><br>";
    $debug_info .= "- role posted: " . (isset($_POST['role']) ? 'YES' : 'NO') . "<br>";
    $debug_info .= "</div>";
    
    if($password !== $confirm) {
        $message = "❌ Passwords do not match";
    } else {
        $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username' OR email='$email'");
        if(mysqli_num_rows($check) > 0) {
            $message = "❌ Username or Email already exists";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, email, password, role)
                    VALUES ('$username', '$email', '$hashedPassword', '$role')";
            
            if(mysqli_query($conn, $sql)) {
                $message = "✅ Account created successfully with role: <strong>$role</strong>";
            } else {
                $message = "❌ Registration failed: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Debug Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #8B5CF6, #EC4899, #F97316);
            min-height: 100vh;
            padding: 50px;
        }
        .debug-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="debug-card">
        <h2>🔧 Debug Signup Form</h2>
        <p>Use this to test if role selection works</p>
        
        <?php if($message): ?>
            <div class="alert alert-info"><?= $message ?></div>
        <?php endif; ?>
        
        <?= $debug_info ?>
        
        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            
            <div class="mb-4">
                <label>Select Role</label><br>
                <label>
                    <input type="radio" name="role" value="user" checked> User
                </label><br>
                <label>
                    <input type="radio" name="role" value="admin"> Admin
                </label>
            </div>
            
            <button type="submit" name="signup" class="btn btn-primary w-100">
                Test Signup
            </button>
        </form>
        
        <hr>
        <a href="signup.php">Back to normal signup</a> | 
        <a href="index.php">Home</a>
    </div>
</body>
</html>
