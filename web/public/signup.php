<?php
require_once "../db.php";
$message = "";

if (isset($_POST['signup'])) {

    $username = escape_string($conn, $_POST['username']);
    $email    = escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];
    $role     = ($_POST['role'] === 'admin') ? 'admin' : 'user';

    if ($password !== $confirm) {
        $message = "❌ Passwords do not match";
    } else {

        $check = mysqli_query(
            $conn,
            "SELECT id FROM users WHERE username='$username' OR email='$email'"
        );

        if (mysqli_num_rows($check) > 0) {
            $message = "❌ Username or Email already exists";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, email, password, role)
                    VALUES ('$username', '$email', '$hashedPassword', '$role')";

            if (mysqli_query($conn, $sql)) {
                header("Location: login.php?success=1");
                exit();
            } else {
                $message = "❌ Registration failed";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignAura | Sign Up</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🤟</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 50%, #F97316 100%);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .signup-card {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.25), rgba(251, 146, 120, 0.25));
            backdrop-filter: blur(15px);
            padding: 50px 40px;
            border-radius: 25px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 480px;
            animation: slideUp 0.6s ease-out;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            width: 277px;
            height: 213px;
            border-radius: 20px;
            margin: 0 auto 25px;
            display: block;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: 3px solid rgba(139, 92, 246, 0.3);
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            font-weight: 700;
            font-size: 32px;
            color: #1a1a1a;
        }

        .subtitle {
            text-align: center;
            color: #2d2d2d;
            margin-bottom: 30px;
            font-size: 15px;
        }

        .alert {
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            font-weight: 500;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #16a34a;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .form-control, .form-select {
            padding: 14px 18px;
            border-radius: 12px;
            border: 2px solid #e0e0e0;
            font-size: 15px;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus, .form-select:focus {
            border-color: #8B5CF6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
            background: white;
        }

        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .password-strength {
            height: 5px;
            border-radius: 3px;
            margin-top: 8px;
            background: #e0e0e0;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s;
            border-radius: 3px;
        }

        .strength-weak { 
            background: #ef4444; 
            width: 33%; 
        }

        .strength-medium { 
            background: #f59e0b; 
            width: 66%; 
        }

        .strength-strong { 
            background: #10b981; 
            width: 100%; 
        }

        .password-hint {
            font-size: 12px;
            color: #666;
            margin-top: 8px;
        }

        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .role-option {
            padding: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.8);
        }

        .role-option:hover {
            border-color: #8B5CF6;
            transform: translateY(-2px);
        }

        .role-option.selected {
            border-color: #8B5CF6;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(168, 85, 247, 0.1));
        }

        .role-option input[type="radio"] {
            display: none;
        }

        .role-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .role-title {
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 5px;
        }

        .role-desc {
            font-size: 12px;
            color: #666;
        }

        .btn-custom {
            padding: 14px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #2d2d2d;
            font-size: 14px;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .login-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Show/hide password */
        .position-relative {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            user-select: none;
        }

        @media (max-width: 576px) {
            .signup-card {
                padding: 35px 25px;
            }

            h2 {
                font-size: 26px;
            }

            .logo {
                width: 70px;
                height: 70px;
            }

            .role-selector {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="signup-card">
        <img src="assets/images/logo.jpg" alt="SignAura Logo" class="logo mb-4 text-center" style="width: 200px;">
        
        <h2>Create Account</h2>
        <p class="subtitle">Join SignAura today</p>

        <!-- Messages -->
        <?php if(isset($message) && strpos($message, '✅') !== false): ?>
        <div class="alert alert-success">
            <?= $message ?>
        </div>
        <?php elseif(isset($message) && !empty($message)): ?>
        <div class="alert alert-danger">
            <?= $message ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" id="signup-form">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" 
                       placeholder="Choose a username" required 
                       value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" 
                       placeholder="your.email@example.com" required
                       value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            </div>
            
            <div class="mb-3 position-relative">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" 
                       placeholder="Create a strong password" required minlength="6">
                <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
                <div class="password-strength">
                    <div class="password-strength-bar" id="strength-bar"></div>
                </div>
                <div class="password-hint" id="strength-text">
                    💡 Use at least 6 characters with letters and numbers
                </div>
            </div>
            
            <div class="mb-4 position-relative">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm-password" 
                       class="form-control" placeholder="Re-enter your password" required>
                <span class="toggle-password" onclick="togglePassword('confirm-password', this)">👁️</span>
            </div>

            <div class="mb-4">
                <label class="form-label">Select Role</label>
                <div class="role-selector">
                    <label class="role-option selected">
                        <input type="radio" name="role" value="user" checked>
                        <div class="role-icon">👤</div>
                        <div class="role-title">User</div>
                        <div class="role-desc">Standard account</div>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="role" value="admin">
                        <div class="role-icon">👑</div>
                        <div class="role-title">Admin</div>
                        <div class="role-desc">Full access</div>
                    </label>
                </div>
            </div>
            
            <button type="submit" name="signup" class="btn btn-custom w-100">
                ✨ Create Account
            </button>
        </form>
        
        <p class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password strength checker
        const password = document.getElementById('password');
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');

        password.addEventListener('input', function() {
            const value = this.value;
            let strength = 0;
            
            if (value.length >= 6) strength++;
            if (value.length >= 10) strength++;
            if (/[a-z]/.test(value) && /[A-Z]/.test(value)) strength++;
            if (/[0-9]/.test(value)) strength++;
            if (/[^a-zA-Z0-9]/.test(value)) strength++;

            strengthBar.className = 'password-strength-bar';
            
            if (strength <= 2) {
                strengthBar.classList.add('strength-weak');
                strengthText.textContent = '⚠️ Weak password';
                strengthText.style.color = '#ef4444';
            } else if (strength <= 3) {
                strengthBar.classList.add('strength-medium');
                strengthText.textContent = '⚡ Medium strength';
                strengthText.style.color = '#f59e0b';
            } else {
                strengthBar.classList.add('strength-strong');
                strengthText.textContent = '✅ Strong password';
                strengthText.style.color = '#10b981';
            }
        });

        // Password match validation
        const confirmPassword = document.getElementById('confirm-password');
        confirmPassword.addEventListener('input', function() {
            if (this.value !== password.value) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '#10b981';
            }
        });

// Role selector - more robust version
        document.querySelectorAll('.role-option').forEach(option => {
            option.addEventListener('click', function(e) {
                // Prevent default to avoid any conflicts
                e.preventDefault();
                
                // Remove selected from all
                document.querySelectorAll('.role-option').forEach(opt => {
                    opt.classList.remove('selected');
                    opt.querySelector('input[type="radio"]').checked = false;
                });
                
                // Add selected to clicked option
                this.classList.add('selected');
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                radio.setAttribute('checked', 'checked');
                
                // Debug - remove in production
                console.log('Selected role:', radio.value);
            });
        });

        // Toggle password visibility
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
