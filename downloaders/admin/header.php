<?php
session_start();

// 检查是否已登录
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>下载站批量管理系统</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .navbar {
            background-color: #2c3e50 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }
        .navbar-nav .nav-link {
            color: #ecf0f1 !important;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border-radius: 4px;
            transition: all 0.3s;
        }
        .navbar-nav .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
        }
        .navbar-nav .nav-link.active {
            background-color: #34495e;
        }
        .main-content {
            padding: 2rem 0;
            min-height: calc(100vh - 56px);
        }
        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .card-header {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            border: none;
        }
        .table {
            margin-bottom: 0;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .status-active {
            background-color: #27ae60;
            color: white;
        }
        .status-maintenance {
            background-color: #f39c12;
            color: white;
        }
        .status-inactive {
            background-color: #e74c3c;
            color: white;
        }
        .breadcrumb {
            background-color: white;
            padding: 1rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .action-buttons {
            white-space: nowrap;
        }
        .form-section {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .form-section h4 {
            color: #2c3e50;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #3498db;
        }
        .alert {
            border-radius: 8px;
        }
        .user-info {
            color: #ecf0f1 !important;
            margin-left: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .user-info i {
            margin-right: 0.5rem;
        }
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        .pagination {
            margin-top: 1rem;
            justify-content: center;
        }
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #7f8c8d;
        }
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #bdc3c7;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-download"></i> 下载站管理系统
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'domain_list.php' ? 'active' : ''; ?>" href="domain_list.php">
                            <i class="fas fa-server"></i> 域名管理
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>" href="index.php">
                            <i class="fas fa-globe"></i> 网站管理
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'website.php' ? 'active' : ''; ?>" href="website.php">
                            <i class="fas fa-plus-circle"></i> 添加网站
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'backlink.php' ? 'active' : ''; ?>" href="backlink.php">
                            <i class="fas fa-link"></i> 反向链接
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'prompt.php' ? 'active' : ''; ?>" href="prompt.php">
                            <i class="fas fa-robot"></i> 提示词管理
                        </a>
                    </li>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'users.php' ? 'active' : ''; ?>" href="users.php">
                            <i class="fas fa-users"></i> 用户管理
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
                <div class="user-info">
                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="logout.php" class="btn btn-sm btn-outline-light">
                        <i class="fas fa-sign-out-alt"></i> 退出登录
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="main-content">
        <div class="container-fluid">