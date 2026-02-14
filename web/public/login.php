<?php
session_start();
require_once "../db.php";

$message = "";

if (isset($_POST['login'])) {

    $username = escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $message = "⚠️ Please fill in all fields";
    } else {

        $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {

            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {

                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'];

if ($user['role'] === 'admin') {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: user/dashboard.php");
                }
                exit();

            } else {
                $message = "❌ Invalid password";
            }

        } else {
            $message = "❌ Username not found";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SignAura | Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }
        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #8B5CF6, #EC4899, #F97316);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            background: white;
            padding: 40px;
            width: 360px;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #6366f1;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #4f46e5;
        }
        .message {
            text-align: center;
            margin-bottom: 15px;
            color: red;
            font-size: 14px;
        }
        .signup {
            text-align: center;
            margin-top: 15px;
        }
        .signup a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
        }

        /* Show/hide password */
        .position-relative {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            user-select: none;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h2>SignAura Login</h2>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>

        <div class="position-relative">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
        </div>

        <button type="submit" name="login">Login</button>
    </form>

    <div class="signup">
        Don't have an account? <a href="signup.php">Sign up</a>
    </div>
</div>

<script>
    function togglePassword(fieldId, icon) {
        const input = document.getElementById(fieldId);
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "🙈";
        } else {
            input.type = "password";
            icon.textContent = "👁️";
        }
    }
</script>

</body>
</html>
