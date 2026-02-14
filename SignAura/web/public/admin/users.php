<?php
require_once __DIR__ . "/../../db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | SignAura</title>
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

        .users-card {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.25), rgba(251, 146, 120, 0.25));
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.3);
            animation: slideUp 0.6s ease-out 0.1s backwards;
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

        .role-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-badge.admin {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: #1a1a1a;
        }

        .role-badge.user {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            border: none;
            color: white;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            white-space: nowrap;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            color: white;
        }

        .btn-make-admin {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .btn-make-user {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .user-id {
            font-weight: 600;
            color: #667eea;
        }

        .user-email {
            color: #666;
            font-size: 13px;
        }

        .stats-bar {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.8);
            padding: 15px 25px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .stat-item .icon {
            font-size: 30px;
        }

        .stat-item .details {
            display: flex;
            flex-direction: column;
        }

        .stat-item .value {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .stat-item .label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @media (max-width: 768px) {
            .users-card {
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
            <div class="ms-auto">
                <a href="dashboard.php" class="btn-back">← Dashboard</a>
                <a href="../logout.php" class="btn btn-logout">🚪 Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Success/Error Messages -->
        <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); endif; ?>
        
        <!-- Page Header -->
        <div class="page-header">
            <h2>👥 User Management</h2>
            <p>Manage user accounts, roles, and permissions</p>
        </div>

        <!-- Users Card -->
        <div class="users-card">
            <!-- Stats Bar -->
            <div class="stats-bar">
                <div class="stat-item">
                    <div class="icon">👥</div>
                    <div class="details">
                        <div class="value">
                            <?php
                            $count = mysqli_query($conn,"SELECT COUNT(*) AS total FROM users");
                            $row = mysqli_fetch_assoc($count);
                            echo $row['total'];
                            ?>
                        </div>
                        <div class="label">Total Users</div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="icon">👑</div>
                    <div class="details">
                        <div class="value">
                            <?php
                            $count = mysqli_query($conn,"SELECT COUNT(*) AS total FROM users WHERE role='admin'");
                            $row = mysqli_fetch_assoc($count);
                            echo $row['total'];
                            ?>
                        </div>
                        <div class="label">Admins</div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="icon">👤</div>
                    <div class="details">
                        <div class="value">
                            <?php
                            $count = mysqli_query($conn,"SELECT COUNT(*) AS total FROM users WHERE role='user'");
                            $row = mysqli_fetch_assoc($count);
                            echo $row['total'];
                            ?>
                        </div>
                        <div class="label">Regular Users</div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="table-container">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = mysqli_query($conn,"SELECT * FROM users ORDER BY id DESC");
                        while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><span class="user-id">#<?= $row['id'] ?></span></td>
                            <td><strong><?= htmlspecialchars($row['username']) ?></strong></td>
                            <td><span class="user-email"><?= htmlspecialchars($row['email']) ?></span></td>
                            <td>
                                <span class="role-badge <?= $row['role'] ?>">
                                    <?= $row['role'] == 'admin' ? '👑 Admin' : '👤 User' ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <?php if($row['role'] != 'admin') { ?>
                                        <a href="users.php?make_admin=<?= $row['id'] ?>" 
                                           class="btn-action btn-make-admin"
                                           title="Promote to Admin">
                                            ⬆️ Make Admin
                                        </a>
                                    <?php } ?>
                                    
                                    <?php if($row['role'] != 'user') { ?>
                                        <a href="users.php?make_user=<?= $row['id'] ?>" 
                                           class="btn-action btn-make-user"
                                           title="Demote to User">
                                            ⬇️ Make User
                                        </a>
                                    <?php } ?>
                                    
                                    <a href="delete_user.php?id=<?= $row['id'] ?>" 
                                       class="btn-action btn-delete"
                                       onclick="return confirm('⚠️ Are you sure you want to delete <?= htmlspecialchars($row['username']) ?>? This action cannot be undone!')"
                                       title="Delete User">
                                        🗑️ Delete
                                    </a>
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
<?php
if(isset($_GET['make_admin'])){
    $id = mysqli_real_escape_string($conn, $_GET['make_admin']);
    mysqli_query($conn,"UPDATE users SET role='admin' WHERE id='$id'");
    header("Location: users.php");
    exit();
}
if(isset($_GET['make_user'])){
    $id = mysqli_real_escape_string($conn, $_GET['make_user']);
    mysqli_query($conn,"UPDATE users SET role='user' WHERE id='$id'");
    header("Location: users.php");
    exit();
}
?>