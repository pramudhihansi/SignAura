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
    <title>Translation History | SignAura</title>
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

        .history-card {
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
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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

        .table-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .table {
            margin: 0;
        }

        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .table thead th {
            border: none;
            padding: 18px 15px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            border-color: #e0e0e0;
            font-size: 14px;
        }

        .table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .user-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 8px;
            background: #f3f4f6;
            font-weight: 600;
            font-size: 13px;
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 12px;
        }

        .language-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
        }

        .lang-english {
            background: #dbeafe;
            color: #1e40af;
        }

        .lang-sinhala {
            background: #dcfce7;
            color: #166534;
        }

        .lang-tamil {
            background: #fef3c7;
            color: #92400e;
        }

        .accuracy-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
        }

        .accuracy-high {
            background: #dcfce7;
            color: #166534;
        }

        .accuracy-medium {
            background: #fef3c7;
            color: #92400e;
        }

        .accuracy-low {
            background: #fee2e2;
            color: #991b1b;
        }

        .text-preview {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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
            .history-card {
                padding: 25px;
            }

            .page-header {
                padding: 20px 25px;
            }

            .page-header h2 {
                font-size: 24px;
            }

            .table-container {
                overflow-x: auto;
            }

            .table {
                font-size: 12px;
            }

            .table thead th,
            .table tbody td {
                padding: 12px 8px;
            }

            .text-preview {
                max-width: 150px;
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
            <div class="ms-auto">
                <a href="dashboard.php" class="btn-back">← Dashboard</a>
                <a href="../logout.php" class="btn btn-logout">🚪 Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h2>📜 Translation History</h2>
            <p>View all user translation records and analytics</p>
        </div>

        <!-- History Card -->
        <div class="history-card">
            <!-- Statistics -->
            <div class="stats-bar">
                <div class="stat-item">
                    <div class="icon">📊</div>
                    <div class="value">
                        <?php
                        $total = mysqli_query($conn,"SELECT COUNT(*) AS count FROM history");
                        $total_row = mysqli_fetch_assoc($total);
                        echo number_format($total_row['count']);
                        ?>
                    </div>
                    <div class="label">Total Translations</div>
                </div>

                <div class="stat-item">
                    <div class="icon">🎯</div>
                    <div class="value">
                        <?php
                        $avg = mysqli_query($conn,"SELECT AVG(accuracy) AS avg FROM history");
                        $avg_row = mysqli_fetch_assoc($avg);
                        echo number_format($avg_row['avg'], 1);
                        ?>%
                    </div>
                    <div class="label">Avg Accuracy</div>
                </div>

                <div class="stat-item">
                    <div class="icon">👥</div>
                    <div class="value">
                        <?php
                        $users = mysqli_query($conn,"SELECT COUNT(DISTINCT user_id) AS count FROM history");
                        $users_row = mysqli_fetch_assoc($users);
                        echo $users_row['count'];
                        ?>
                    </div>
                    <div class="label">Active Users</div>
                </div>

                <div class="stat-item">
                    <div class="icon">📅</div>
                    <div class="value">
                        <?php
                        $today = mysqli_query($conn,"SELECT COUNT(*) AS count FROM history WHERE DATE(created_at) = CURDATE()");
                        $today_row = mysqli_fetch_assoc($today);
                        echo $today_row['count'];
                        ?>
                    </div>
                    <div class="label">Today</div>
                </div>
            </div>

            <!-- History Table -->
            <div class="table-container">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Translated Text</th>
                            <th>Language</th>
                            <th>Accuracy</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT h.*, u.username 
                                FROM history h 
                                JOIN users u ON h.user_id = u.id 
                                ORDER BY h.created_at DESC
                                LIMIT 100";
                        $result = mysqli_query($conn,$sql);
                        
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)){
                                $initial = strtoupper(substr($row['username'], 0, 1));
                                $accuracy = floatval($row['accuracy']);
                                $accuracy_class = $accuracy >= 80 ? 'accuracy-high' : 
                                                ($accuracy >= 50 ? 'accuracy-medium' : 'accuracy-low');
                                
                                $language = strtolower($row['language']);
                                $lang_class = $language == 'english' ? 'lang-english' : 
                                            ($language == 'sinhala' ? 'lang-sinhala' : 'lang-tamil');
                                $lang_flag = $language == 'english' ? '🇬🇧' : 
                                           ($language == 'sinhala' ? '🇱🇰' : '🇮🇳');
                        ?>
                        <tr>
                            <td>
                                <div class="user-badge">
                                    <div class="user-avatar"><?= $initial ?></div>
                                    <?= htmlspecialchars($row['username']) ?>
                                </div>
                            </td>
                            <td>
                                <div class="text-preview" title="<?= htmlspecialchars($row['sign_text']) ?>">
                                    <?= htmlspecialchars($row['sign_text']) ?>
                                </div>
                            </td>
                            <td>
                                <span class="language-badge <?= $lang_class ?>">
                                    <?= $lang_flag ?> <?= ucfirst($row['language']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="accuracy-badge <?= $accuracy_class ?>">
                                    <?= number_format($accuracy, 1) ?>%
                                </span>
                            </td>
                            <td>
                                <div style="font-size: 13px;">
                                    <?= date('M d, Y', strtotime($row['created_at'])) ?><br>
                                    <span style="color: #888; font-size: 12px;">
                                        <?= date('h:i A', strtotime($row['created_at'])) ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📭</div>
                                    <h4>No Translation History</h4>
                                    <p>Translation records will appear here once users start using the system.</p>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>