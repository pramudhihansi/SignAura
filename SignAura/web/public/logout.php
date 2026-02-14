<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignAura | Logging Out</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🤟</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 50%, #F97316 100%);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .logout-container {
            text-align: center;
            animation: fadeInScale 0.6s ease-out;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .logo {
            width: 277px;
            height: 213px;
            border-radius: 20px;
            margin: 0 auto 30px;
            display: block;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            border: 4px solid rgba(255, 255, 255, 0.5);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .logout-card {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.25), rgba(251, 146, 120, 0.25));
            backdrop-filter: blur(15px);
            padding: 60px 50px;
            border-radius: 30px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.3);
            max-width: 500px;
        }

        h1 {
            font-size: 36px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 15px;
            animation: slideDown 0.8s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message {
            font-size: 16px;
            color: #2d2d2d;
            margin-bottom: 35px;
            animation: slideDown 0.8s ease-out 0.2s backwards;
        }

        .spinner-container {
            margin: 30px 0;
            animation: slideDown 0.8s ease-out 0.4s backwards;
        }

        .spinner {
            width: 60px;
            height: 60px;
            margin: 0 auto;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-top: 5px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .dots {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-top: 20px;
            letter-spacing: 2px;
        }

        .dot {
            animation: blink 1.4s infinite;
        }

        .dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes blink {
            0%, 20%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }

        .farewell {
            font-size: 14px;
            color: #2d2d2d;
            margin-top: 25px;
            opacity: 0.8;
            animation: slideDown 0.8s ease-out 0.6s backwards;
        }

        @media (max-width: 576px) {
            .logout-card {
                padding: 40px 30px;
            }

            h1 {
                font-size: 28px;
            }

            .logo {
                width: 90px;
                height: 90px;
            }
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <div class="logout-card">
            <img src="assets/images/logo.jpg" alt="SignAura Logo" class="logo mb-4 text-center" style="width: 200px;">
            
            <h1>Logging Out</h1>
            <p class="message">Thank you for using SignAura!</p>
            
            <div class="spinner-container">
                <div class="spinner"></div>
                <div class="dots">
                    <span class="dot">.</span><span class="dot">.</span><span class="dot">.</span>
                </div>
            </div>
            
            <p class="farewell">See you soon! 👋</p>
        </div>
    </div>

    <script>
        // Redirect after 2 seconds
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 2000);
    </script>
</body>
</html>