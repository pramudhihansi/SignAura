<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignAura | Welcome</title>
    <link rel="icon" type="image/jpeg" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🤟</text></svg>">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 50%, #F97316 100%);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .welcome-card {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.25), rgba(251, 146, 120, 0.25));
            backdrop-filter: blur(15px);
            border-radius: 35px;
            padding: 70px 60px;
            max-width: 750px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
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
            margin: 0 auto 30px;
            animation: float 3s ease-in-out infinite;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            border: 4px solid rgba(255, 255, 255, 0.5);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        h1 {
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 15px;
            font-size: 42px;
        }

        .highlight {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .explanation {
            color: #2d2d2d;
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.7;
        }

        .btn-custom {
            padding: 14px;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary.btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-primary.btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        .btn-outline-primary.btn-custom {
            color: #667eea;
            border: 2px solid #667eea;
            background: white;
        }

        .btn-outline-primary.btn-custom:hover {
            background: #667eea;
            border-color: #667eea;
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.3);
        }

        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #888;
        }

        @media (max-width: 576px) {
            .welcome-card {
                padding: 40px 30px;
            }

            h1 {
                font-size: 30px;
            }

            .logo {
                width: 100px;
                height: 100px;
            }
            
            .explanation {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-card">
        <!-- LOGO -->
        <img src="assets/images/logo.jpg" alt="SignAura Logo" class="logo">
        
        <h1>Welcome to <span class="highlight">SignAura</span></h1>
        
        <!-- Explanation -->
        <p class="explanation">
            SignAura is an AI-powered Sign Language Translation System designed to convert real-time gestures 
            and signs into readable text. It supports English and Sinhala sign language, making communication 
            seamless for both hearing and non-hearing users.
        </p>
        
        <!-- Buttons -->
        <div class="d-grid gap-3 mt-4">
            <a href="login.php" class="btn btn-primary btn-custom">🚀 Login</a>
            <a href="signup.php" class="btn btn-outline-primary btn-custom">✨ Sign Up</a>
        </div>
        
        <div class="footer">
            © 2025 • SignAura • All Rights Reserved
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>