<?php
session_start();
require_once __DIR__ . "/../../db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | SignAura</title>
    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpg">
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
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .navbar {
            background: rgba(26, 26, 26, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            padding: 20px 0;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-badge {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .btn-logout {
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 600;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;
            color: white;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(239, 68, 68, 0.4);
            color: white;
        }

        .container {
            margin-top: 40px;
            padding-bottom: 50px;
        }

        .page-header {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.25), rgba(251, 146, 120, 0.25));
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 40px;
            animation: slideUp 0.6s ease-out;
            text-align: center;
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

        .page-header h1 {
            font-size: 36px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .page-header p {
            color: #2d2d2d;
            margin: 0;
            font-size: 16px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.85));
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .stat-card.users::before {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
        }

        .stat-card.admins::before {
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }

        .stat-card.normal-users::before {
            background: linear-gradient(90deg, #10b981, #059669);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .stat-icon {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .stat-card h5 {
            font-size: 16px;
            font-weight: 600;
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card h2 {
            font-size: 48px;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
        }

        .stat-label {
            font-size: 14px;
            color: #888;
            margin-top: 5px;
        }

        .action-section {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.25), rgba(251, 146, 120, 0.25));
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            animation: slideUp 0.6s ease-out 0.3s backwards;
        }

        .action-section h3 {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 20px;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 15px 35px;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            color: white;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            color: white;
        }

        .btn-manage-users {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-view-feedback {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .btn-settings {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }

        .quick-stat-item {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .quick-stat-item .icon {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .quick-stat-item .value {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .quick-stat-item .label {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 25px;
            }

            .page-header h1 {
                font-size: 28px;
            }

            .stat-card {
                padding: 25px;
            }

            .stat-card h2 {
                font-size: 36px;
            }

            .action-section {
                padding: 25px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <span class="navbar-brand">
                ✨ SignAura
                <span class="admin-badge">⚡ ADMIN</span>
            </span>
            <a href="../logout.php" class="btn btn-logout">🚪 Logout</a>
        </div>
    </nav>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>👨‍💼 Admin Dashboard</h1>
            <p>Manage users, view statistics, and monitor system performance</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-row">
            <div class="stat-card users">
                <div class="stat-icon">👥</div>
<h5>Total Users</h5>
                <h2 id="total-users">
                    <?php
                    $count = mysqli_query($conn,"SELECT COUNT(*) AS total FROM users");
                    $row = mysqli_fetch_assoc($count);
                    echo $row['total'];
                    ?>
                </h2>
                <div class="stat-label">Registered accounts</div>
            </div>

            <div class="stat-card admins">
                <div class="stat-icon">👑</div>
                <h5>Admins</h5>
                <h2 id="admin-count">
                    <?php
                    $count = mysqli_query($conn,"SELECT COUNT(*) AS total FROM users WHERE role='admin'");
                    $row = mysqli_fetch_assoc($count);
                    echo $row['total'];
                    ?>
                </h2>
                <div class="stat-label">Administrative users</div>
            </div>

            <div class="stat-card normal-users">
                <div class="stat-icon">👤</div>
                <h5>Regular Users</h5>
                <h2 id="normal-users">
                    <?php
                    $count = mysqli_query($conn,"SELECT COUNT(*) AS total FROM users WHERE role='user'");
                    $row = mysqli_fetch_assoc($count);
                    echo $row['total'];
                    ?>
                </h2>
                <div class="stat-label">Standard accounts</div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="quick-stats">
            <div class="quick-stat-item">
                <div class="icon">📊</div>
                <div class="value">
                    <?php
                    // Total translations (example - adjust based on your table)
                    // $trans = mysqli_query($conn,"SELECT COUNT(*) AS total FROM translations");
                    // $trans_row = mysqli_fetch_assoc($trans);
                    // echo $trans_row['total'];
                    echo "1,234"; // Placeholder
                    ?>
                </div>
                <div class="label">Total Translations</div>
            </div>

            <div class="quick-stat-item">
                <div class="icon">💬</div>
                <div class="value">
                    <?php
                    // Total feedback 
                    // $feedback = mysqli_query($conn,"SELECT COUNT(*) AS total FROM feedback");
                    // $feedback_row = mysqli_fetch_assoc($feedback);
                    // echo $feedback_row['total'];
                    echo "87"; // Placeholder
                    ?>
                </div>
                <div class="label">Feedback Received</div>
            </div>

            <div class="quick-stat-item">
                <div class="icon">🎯</div>
                <div class="value">94%</div>
                <div class="label">Avg. Accuracy</div>
            </div>

            <div class="quick-stat-item">
                <div class="icon">⚡</div>
                <div class="value">
                    <?php
                    // Active sessions today
                    echo "42"; // Placeholder
                    ?>
                </div>
                <div class="label">Active Today</div>
            </div>
        </div>

        <!-- Action Section -->
        <div class="action-section">
            <h3>🎛️ Quick Actions</h3>
            <div class="action-buttons">
                <a href="users.php" class="btn-action btn-manage-users">
                    👥 Manage Users
                </a>
                <a href="feedback.php" class="btn-action btn-view-feedback">
                    💬 View Feedback
                </a>
                <a href="settings.html" class="btn-action btn-settings">
                    ⚙️ System Settings
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>