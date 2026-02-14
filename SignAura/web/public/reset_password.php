<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignAura | Reset Password</title>
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

        .reset-card {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.25), rgba(251, 146, 120, 0.25));
            backdrop-filter: blur(15px);
            padding: 50px 40px;
            border-radius: 25px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 450px;
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
            font-size: 14px;
            line-height: 1.6;
        }

        .form-control {
            padding: 14px 18px;
            border-radius: 12px;
            border: 2px solid #e0e0e0;
            font-size: 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #8B5CF6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
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
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.4);
        }

        .success {
            background: #efe;
            color: #2a7d2e;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 20px;
            border-left: 4px solid #2a7d2e;
            font-size: 15px;
            line-height: 1.8;
        }

        .success a {
            color: #2a7d2e;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            padding: 10px 25px;
            background: white;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .success a:hover {
            background: #2a7d2e;
            color: white;
            transform: translateY(-2px);
        }

        .success-icon {
            font-size: 50px;
            margin-bottom: 10px;
        }

        .icon {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .password-hint {
            font-size: 12px;
            color: #555;
            margin-top: 8px;
            padding-left: 5px;
        }

        @media (max-width: 576px) {
            .reset-card {
                padding: 35px 25px;
            }

            h2 {
                font-size: 26px;
            }

            .logo {
                width: 70px;
                height: 70px;
            }
        }
    </style>
</head>
<body>
    <div class="reset-card">
        <img src="assets/images/logo.jpg" alt="SignAura Logo" class="logo mb-4 text-center" style="width: 200px;">
        
        <!-- Success State -->
        <?php if(isset($success)) { ?>
            <div class="success-icon">✅</div>
            <h2>Success!</h2>
            <div class="success">
                Password updated successfully!<br>
                <a href="login.php">🚀 Go to Login</a>
            </div>
        <?php } else { ?>
            <!-- Reset Form -->
            <div class="icon">🔑</div>
            <h2>Reset Password</h2>
            <p class="subtitle">Enter your new password below. Make sure it's strong and secure!</p>
            
            <form method="POST">
                <div class="mb-4">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your new password" required minlength="6">
                    <div class="password-hint">
                        💡 Use at least 6 characters with letters and numbers
                    </div>
                </div>
                
                <button name="reset" class="btn btn-primary btn-custom w-100">
                    🔐 Reset Password
                </button>
            </form>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>