<?php
$domain = $_GET['domain'] ?? '';
$act = $_GET['act'] ?? 'homepage';

// 处理AJAX请求（在输出任何HTML之前）
if (isset($_GET['update_router']) || isset($_GET['ajax_translate']) || isset($_GET['translate_all']) || isset($_GET['translate_remaining'])) {
    // 包含对应的子页面来处理AJAX请求
    $sub_page = $act . '.php';
    if (file_exists($sub_page)) {
        require_once $sub_page;
    }
    exit(); // 确保不继续执行后面的代码
}

require_once 'header.php';

if (!$domain) {
    header('Location: index.php');
    exit();
}

// 验证域名是否存在
$websites = json_decode(file_get_contents('data/websites.json'), true) ?: [];
$website_exists = false;
foreach ($websites as $site) {
    if ($site['domain'] == $domain) {
        $website_exists = true;
        break;
    }
}

if (!$website_exists) {
    header('Location: index.php');
    exit();
}

// 根据不同的操作包含对应的子页面
$valid_acts = ['homepage', 'staticpage', 'tagpage', 'navbar', 'sitelinks', 'router', 'template'];
if (!in_array($act, $valid_acts)) {
    $act = 'homepage';
}
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">管理首页</a></li>
        <li class="breadcrumb-item"><a href="index.php"><?php echo htmlspecialchars($domain); ?></a></li>
        <li class="breadcrumb-item active">内容管理</li>
    </ol>
</nav>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="fas fa-globe"></i> 正在管理: <strong><?php echo htmlspecialchars($domain); ?></strong>
                </h5>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $act == 'homepage' ? 'active' : ''; ?>" 
                           href="website_pages.php?domain=<?php echo $domain; ?>&act=homepage">
                            <i class="fas fa-home"></i> 首页内容
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $act == 'staticpage' ? 'active' : ''; ?>" 
                           href="website_pages.php?domain=<?php echo $domain; ?>&act=staticpage">
                            <i class="fas fa-file"></i> 静态页面
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $act == 'tagpage' ? 'active' : ''; ?>" 
                           href="website_pages.php?domain=<?php echo $domain; ?>&act=tagpage">
                            <i class="fas fa-tags"></i> 标签页面
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $act == 'navbar' ? 'active' : ''; ?>" 
                           href="website_pages.php?domain=<?php echo $domain; ?>&act=navbar">
                            <i class="fas fa-bars"></i> 导航管理
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $act == 'sitelinks' ? 'active' : ''; ?>" 
                           href="website_pages.php?domain=<?php echo $domain; ?>&act=sitelinks">
                            <i class="fas fa-link"></i> 站点外链
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $act == 'router' ? 'active' : ''; ?>" 
                           href="website_pages.php?domain=<?php echo $domain; ?>&act=router">
                            <i class="fas fa-route"></i> 路由配置
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $act == 'template' ? 'active' : ''; ?>" 
                           href="website_pages.php?domain=<?php echo $domain; ?>&act=template">
                            <i class="fas fa-code"></i> 模板管理
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="content-area">
    <?php
    // 包含对应的子页面
    $sub_page = $act . '.php';
    if (file_exists($sub_page)) {
        require_once $sub_page;
    } else {
        echo '<div class="alert alert-danger">页面未找到: ' . htmlspecialchars($sub_page) . '</div>';
    }
    ?>
</div>

<?php require_once 'footer.php'; ?>