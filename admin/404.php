<?php
session_start();

// 设置404状态码
http_response_code(404);

// 检查是否登录
$isLoggedIn = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        
        .error-page {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .error-icon {
            font-size: 100px;
            color: #dc3545;
            margin-bottom: 20px;
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        .error-code {
            font-size: 100px;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 10px;
            line-height: 1;
            background: linear-gradient(45deg, #dc3545, #fd7e14);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .error-title {
            font-size: 28px;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 15px;
        }
        
        .error-message {
            font-size: 16px;
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .btn-group-404 {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 25px;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn i {
            font-size: 18px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-outline-secondary {
            border: 2px solid #e9ecef;
            color: #495057;
        }
        
        .btn-outline-secondary:hover {
            background: #e9ecef;
            border-color: #dee2e6;
            color: #495057;
            transform: translateY(-2px);
        }
        
        .decoration {
            position: fixed;
            opacity: 0.05;
            font-size: 300px;
            color: #dee2e6;
            z-index: -1;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
        
        .decoration-1 {
            top: -100px;
            left: -100px;
        }
        
        .decoration-2 {
            bottom: -100px;
            right: -100px;
            animation-delay: 3s;
        }
        
        .tips {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #ffc107;
        }
        
        .tips h6 {
            color: #856404;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .tips ul {
            margin: 0;
            padding-left: 25px;
            color: #6c757d;
        }
        
        .tips ul li {
            margin-bottom: 5px;
        }
        
        @media (max-width: 576px) {
            .error-page {
                padding: 30px 20px;
            }
            
            .error-icon {
                font-size: 80px;
            }
            
            .error-code {
                font-size: 70px;
            }
            
            .error-title {
                font-size: 22px;
            }
            
            .btn-group-404 {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <i class="fas fa-cog decoration decoration-1"></i>
    <i class="fas fa-cog decoration decoration-2"></i>
    
    <div class="error-page">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        
        <h1 class="error-code">404</h1>
        
        <h2 class="error-title">Page Not Found</h2>
        
        <p class="error-message">
            The admin page you're looking for doesn't exist or has been moved. 
            This might happen if you typed the wrong URL or followed an outdated link.
        </p>
        
        <div class="btn-group-404">
            <?php if ($isLoggedIn): ?>
                <a href="/admin/dashboard.php" class="btn btn-primary">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
                <a href="/admin/websites.php" class="btn btn-outline-secondary">
                    <i class="fas fa-globe"></i>
                    Websites
                </a>
            <?php else: ?>
                <a href="/admin/index.php" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i>
                    Login Page
                </a>
            <?php endif; ?>
            <a href="javascript:history.back()" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>
                Go Back
            </a>
        </div>
        
        <div class="tips">
            <h6>
                <i class="fas fa-lightbulb"></i>
                Helpful Tips:
            </h6>
            <ul>
                <li>Check if you typed the URL correctly</li>
                <li>The page might have been moved or deleted</li>
                <li>Make sure you have the right permissions</li>
                <?php if (!$isLoggedIn): ?>
                <li>You might need to <a href="/admin/index.php">login</a> first</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>