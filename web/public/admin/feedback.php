<?php
session_start();
require_once __DIR__ . "/../../db.php";
require_once __DIR__ . "/auth.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback | SignAura</title>
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
            background: rgba(26, 26, 26, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            padding: 20px 0;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            color: white;
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

        .btn-back {
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid #667eea;
            color: #667eea;
            transition: all 0.3s;
            text-decoration: none;
            margin-right: 10px;
        }

        .btn-back:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
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
            padding: 30px 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 30px;
            animation: slideUp 0.6s ease-out;
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

        .page-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .page-header p {
            color: #2d2d2d;
            margin: 0;
            font-size: 15px;
        }

        .feedback-card {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.25), rgba(251, 146, 120, 0.25));
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.3);
            animation: slideUp 0.6s ease-out 0.1s backwards;
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .stat-item .icon {
            font-size: 35px;
            margin-bottom: 10px;
        }

        .stat-item .value {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .stat-item .label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 5px;
        }

        .feedback-list {
            display: grid;
            gap: 20px;
        }

        .feedback-item {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            border-left: 5px solid #667eea;
        }

        .feedback-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .feedback-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
        }

        .user-details h4 {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0;
        }

        .user-details .date {
            font-size: 12px;
            color: #888;
        }

        .rating-stars {
            display: flex;
            gap: 3px;
            font-size: 20px;
        }

        .star-filled {
            color: #fbbf24;
        }

        .star-empty {
            color: #ddd;
        }

        .category-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .category-accuracy {
            background: #dbeafe;
            color: #1e40af;
        }

        .category-performance {
            background: #dcfce7;
            color: #166534;
        }

        .category-interface {
            background: #fef3c7;
            color: #92400e;
        }

        .category-feature {
            background: #e9d5ff;
            color: #6b21a8;
        }

        .category-bug {
            background: #fee2e2;
            color: #991b1b;
        }

        .category-other {
            background: #f3f4f6;
            color: #374151;
        }

        .feedback-message {
            color: #333;
            line-height: 1.6;
            font-size: 14px;
            margin-top: 15px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-state-icon {
            font-size: 80px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h4 {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #666;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .feedback-card {
                padding: 25px;
            }

            .page-header {
                padding: 20px 25px;
            }

            .page-header h2 {
                font-size: 24px;
            }

            .feedback-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-bar {
                grid-template-columns: 1fr;
            }
        }
    </style>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark">
    <div class="container-fluid">
        <span class="navbar-brand">
            ✨ SignAura <span class="admin-badge">⚡ ADMIN</span>
        </span>
        <div class="ms-auto">
            <a href="dashboard.php" class="btn-back">← Dashboard</a>
            <a href="../logout.php" class="btn btn-logout">🚪 Logout</a>
        </div>
    </div>
</nav>

<div class="container">

    <!-- Page Header -->
    <div class="page-header">
        <h2>💬 User Feedback</h2>
        <p>View and analyze user feedback and suggestions</p>
    </div>

    <!-- Feedback Card -->
    <div class="feedback-card">

        <!-- Statistics -->
        <div class="stats-bar">

            <!-- Total Feedback -->
            <div class="stat-item">
                <div class="icon">📝</div>
                <div class="value">
                    <?php
                    $total = mysqli_query($conn, "SELECT COUNT(*) AS count FROM user_feedback");
                    $row = mysqli_fetch_assoc($total);
                    echo $row['count'];
                    ?>
                </div>
                <div class="label">Total Feedback</div>
            </div>

            <!-- Average Rating -->
            <div class="stat-item">
                <div class="icon">⭐</div>
                <div class="value">
                    <?php
                    $avg = mysqli_query($conn, "SELECT AVG(rating) AS avg FROM user_feedback");
                    $row = mysqli_fetch_assoc($avg);
                    echo number_format($row['avg'] ?? 0, 1);
                    ?>
                </div>
                <div class="label">Avg Rating</div>
            </div>

            <!-- Positive Reviews -->
            <div class="stat-item">
                <div class="icon">🎯</div>
                <div class="value">
                    <?php
                    $positive = mysqli_query(
                        $conn,
                        "SELECT COUNT(*) AS count FROM user_feedback WHERE rating >= 4"
                    );
                    $row = mysqli_fetch_assoc($positive);
                    echo $row['count'];
                    ?>
                </div>
                <div class="label">Positive Reviews</div>
            </div>

            <!-- Today -->
            <div class="stat-item">
                <div class="icon">📅</div>
                <div class="value">
                    <?php
                    $today = mysqli_query(
                        $conn,
                        "SELECT COUNT(*) AS count 
                         FROM user_feedback 
                         WHERE DATE(created_at) = CURDATE()"
                    );
                    $row = mysqli_fetch_assoc($today);
                    echo $row['count'];
                    ?>
                </div>
                <div class="label">Today</div>
            </div>

        </div>

        <!-- Feedback List -->
        <div class="feedback-list">
            <?php
            $sql = "SELECT f.rating, f.category, f.message, f.created_at, u.username
                    FROM user_feedback f
                    INNER JOIN users u ON f.user_id = u.id
                    ORDER BY f.created_at DESC";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

                    $initial  = strtoupper(substr($row['username'], 0, 1));
                    $rating   = (int)$row['rating'];
                    $category = $row['category'] ?? 'other';
            ?>
            <div class="feedback-item">
                <div class="feedback-header">
                    <div class="user-info">
                        <div class="user-avatar"><?= $initial ?></div>
                        <div class="user-details">
                            <h4><?= htmlspecialchars($row['username']) ?></h4>
                            <div class="date">
                                📅 <?= date('M d, Y • h:i A', strtotime($row['created_at'])) ?>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="rating-stars">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo ($i <= $rating)
                                    ? '<span class="star-filled">★</span>'
                                    : '<span class="star-empty">★</span>';
                            }
                            ?>
                        </div>

                        <div class="mt-2">
                            <span class="category-badge category-<?= htmlspecialchars($category) ?>">
                                <?= ucfirst(htmlspecialchars($category)) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="feedback-message">
                    <?= nl2br(htmlspecialchars($row['message'])) ?>
                </div>
            </div>

            <?php
                }
            } else {
            ?>
            <div class="empty-state">
                <div class="empty-state-icon">💬</div>
                <h4>No Feedback Yet</h4>
                <p>User feedback will appear here once submitted.</p>
            </div>
            <?php } ?>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>