<?php
// 设置404状态码
http_response_code(404);

// 获取当前域名信息
$site_domain = $_SERVER['HTTP_HOST'];
$site_config = "vhosts/{$site_domain}/config.json";
$site_name = 'Video Downloader';
$primary_color = '#e74c3c';

if (file_exists($site_config)) {
    $config = json_decode(file_get_contents($site_config), true);
    $site_name = $config['site_name'] ?? 'Video Downloader';
    // 根据平台类型设置主题色
    switch($config['type'] ?? '') {
        case 'youtube':
            $primary_color = '#ff0000';
            break;
        case 'tiktok':
            $primary_color = '#000000';
            break;
        case 'instagram':
            $primary_color = '#833ab4';
            break;
        case 'facebook':
            $primary_color = '#1877f2';
            break;
        case 'twitter':
            $primary_color = '#1da1f2';
            break;
        default:
            $primary_color = '#e74c3c';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | <?php echo htmlspecialchars($site_name); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .error-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            padding: 60px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .error-code {
            font-size: 120px;
            font-weight: 700;
            color: <?php echo $primary_color; ?>;
            line-height: 1;
            margin-bottom: 10px;
            animation: glitch 2s ease-in-out infinite;
        }
        
        @keyframes glitch {
            0%, 100% { text-shadow: 0 0 0 <?php echo $primary_color; ?>; }
            25% { text-shadow: -2px 0 0 #ff0000, 2px 0 0 #00ff00; }
            50% { text-shadow: 2px 0 0 #ff0000, -2px 0 0 #00ff00; }
            75% { text-shadow: 0 0 0 <?php echo $primary_color; ?>; }
        }
        
        .error-title {
            font-size: 32px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .error-message {
            font-size: 18px;
            color: #7f8c8d;
            line-height: 1.6;
            margin-bottom: 40px;
        }
        
        .error-icon {
            font-size: 80px;
            color: #e0e0e0;
            margin-bottom: 30px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background: <?php echo $primary_color; ?>;
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            background: <?php echo $primary_color; ?>dd;
        }
        
        .btn-secondary {
            background: white;
            color: #2c3e50;
            border: 2px solid #ecf0f1;
        }
        
        .btn-secondary:hover {
            background: #ecf0f1;
            transform: translateY(-2px);
        }
        
        .search-box {
            margin-bottom: 30px;
            position: relative;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .search-input {
            width: 100%;
            padding: 15px 50px 15px 20px;
            border: 2px solid #ecf0f1;
            border-radius: 50px;
            font-size: 16px;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .search-input:focus {
            border-color: <?php echo $primary_color; ?>;
            box-shadow: 0 0 0 3px <?php echo $primary_color; ?>20;
        }
        
        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: <?php echo $primary_color; ?>;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .search-btn:hover {
            background: <?php echo $primary_color; ?>dd;
            transform: translateY(-50%) scale(1.1);
        }
        
        @media (max-width: 600px) {
            .error-container {
                padding: 40px 30px;
            }
            
            .error-code {
                font-size: 80px;
            }
            
            .error-title {
                font-size: 24px;
            }
            
            .error-message {
                font-size: 16px;
            }
            
            .action-buttons {
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
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-ghost"></i>
        </div>
        
        <div class="error-code">404</div>
        
        <h1 class="error-title">Oops! Page Not Found</h1>
        
        <p class="error-message">
            The page you're looking for seems to have vanished into the digital void. 
            It might have been moved, deleted, or perhaps it never existed.
        </p>
        
        <div class="search-box">
            <form action="/" method="get" onsubmit="return handleSearch(event)">
                <input type="text" class="search-input" placeholder="Search for videos..." id="searchQuery">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        
        <div class="action-buttons">
            <a href="/" class="btn btn-primary">
                <i class="fas fa-home"></i>
                Go Home
            </a>
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Go Back
            </a>
        </div>
    </div>
    
    <script>
        function handleSearch(e) {
            e.preventDefault();
            const query = document.getElementById('searchQuery').value.trim();
            if (query) {
                window.location.href = '/?q=' + encodeURIComponent(query);
            }
            return false;
        }
        
        // Add some random floating elements for visual interest
        if (window.innerWidth > 768) {
            const colors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#feca57'];
            for (let i = 0; i < 5; i++) {
                const bubble = document.createElement('div');
                bubble.style.cssText = `
                    position: fixed;
                    width: ${20 + Math.random() * 40}px;
                    height: ${20 + Math.random() * 40}px;
                    background: ${colors[i]};
                    border-radius: 50%;
                    opacity: 0.1;
                    left: ${Math.random() * 100}%;
                    top: ${Math.random() * 100}%;
                    animation: float ${3 + Math.random() * 4}s ease-in-out infinite;
                    animation-delay: ${Math.random() * 2}s;
                    pointer-events: none;
                    z-index: -1;
                `;
                document.body.appendChild(bubble);
            }
        }
    </script>
</body>
</html>