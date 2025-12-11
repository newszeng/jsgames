<?php
session_start();

// 检查是否已登录
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// 读取网站列表
$websites = json_decode(file_get_contents('data/websites.json'), true) ?: [];

// 获取今天的独立访客数
function getTodayUniqueVisitors($domain) {
    $today = date('Y-m-d');
    $year_month = date('Ym');
    $day_file = date('Ymd');
    
    $analytics_dir = __DIR__ . "/../analytics/{$domain}";
    $log_file = $analytics_dir . '/' . $year_month . '/' . $day_file . '.log';
    
    if (!file_exists($log_file)) {
        return 0;
    }
    
    $unique_visitors = [];
    $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        $data = explode('|', $line);
        if (count($data) >= 2) {
            $visitor_id = $data[1];
            $unique_visitors[$visitor_id] = true;
        }
    }
    
    return count($unique_visitors);
}

// 删除网站 - 必须在任何输出之前处理
if (isset($_GET['delete']) && $_SESSION['role'] == 'admin') {
    $domain = $_GET['delete'];
    $websites = array_filter($websites, function($site) use ($domain) {
        return $site['domain'] != $domain;
    });
    
    // 删除相关目录和文件
    $dirs_to_delete = [
        "../vhosts/{$domain}.conf",
        "../i18n/{$domain}",
        "../router/{$domain}",
        "../pages/{$domain}",
        "../backlinks/{$domain}",
        "../navbars/{$domain}",
        "../analytics/{$domain}",
        "../static/{$domain}",
        "../tpl/{$domain}",
        "../data/{$domain}",
        "../apache/sites-available/{$domain}.conf",
    ];
    
    foreach ($dirs_to_delete as $dir) {
        if (is_dir($dir)) {
            deleteDirectory($dir);
        } elseif (is_file($dir)) {
            unlink($dir);
        }
    }
    
    file_put_contents('data/websites.json', json_encode(array_values($websites), JSON_PRETTY_PRINT));
    header('Location: index.php?deleted=1');
    exit();
}

// 递归删除目录
function deleteDirectory($dir) {
    if (!is_dir($dir)) return;
    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        is_dir($path) ? deleteDirectory($path) : unlink($path);
    }
    rmdir($dir);
}

// 在所有重定向操作完成后才包含 header.php
require_once 'header.php';
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><i class="fas fa-home"></i> 管理首页</li>
    </ol>
</nav>

<?php if (isset($_GET['deleted'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> 网站删除成功！
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (isset($_GET['added'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> 网站添加成功！
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (isset($_GET['updated'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> 网站更新成功！
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-globe"></i> 网站管理</span>
        <a href="website.php" class="btn btn-sm btn-light">
            <i class="fas fa-plus"></i> 添加新网站
        </a>
    </div>
    <div class="card-body">
        <?php if (empty($websites)): ?>
        <div class="empty-state">
            <i class="fas fa-globe"></i>
            <h4>暂无网站</h4>
            <p>点击"添加新网站"来创建您的第一个下载站。</p>
            <a href="website.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> 添加第一个网站
            </a>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>域名</th>
                        <th>类型</th>
                        <th>主题</th>
                        <th>状态</th>
                        <th>今日访客</th>
                        <th>创建者</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($websites as $website): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($website['domain']); ?></strong>
                            <br>
                            <small class="text-muted">
                                <?php
                                // 检查网站状态决定访问链接
                                if (isset($website['status'])) {
                                    $current_status = $website['status'];
                                } else {
                                    $current_status = isset($website['active']) && $website['active'] ? 'active' : 'inactive';
                                }
                                
                                // 调试模式：使用 index.php?domain=xxx&lang=xxx 格式
                                $visit_url = '/index.php?domain=' . urlencode($website['domain']) . '&lang=en';
                                if ($current_status === 'maintenance') {
                                    $visit_url .= '&debug=1';
                                }
                                ?>
                                <a href="<?php echo $visit_url; ?>" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> 访问
                                    <?php if ($current_status === 'maintenance'): ?>
                                    <small class="text-warning">(调试模式)</small>
                                    <?php endif; ?>
                                </a>
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                <?php echo ucfirst($website['type']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($website['theme']); ?></td>
                        <td>
                            <?php 
                            // 兼容旧版本的 active 字段
                            if (isset($website['status'])) {
                                $status = $website['status'];
                            } else {
                                $status = isset($website['active']) && $website['active'] ? 'active' : 'inactive';
                            }
                            
                            $status_text = [
                                'active' => '启用',
                                'maintenance' => '维护中',
                                'inactive' => '停用'
                            ];
                            ?>
                            <span class="status-badge status-<?php echo $status; ?>">
                                <?php echo $status_text[$status] ?? '未知'; ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php 
                            $today_visitors = getTodayUniqueVisitors($website['domain']);
                            if ($today_visitors > 0): 
                            ?>
                                <span class="badge bg-success" title="今日独立访客">
                                    <i class="fas fa-users"></i> <?php echo number_format($today_visitors); ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-info">
                                <?php echo htmlspecialchars($website['created_by'] ?? '未知'); ?>
                            </span>
                        </td>
                        <td><?php echo date('Y-m-d', strtotime($website['created_at'])); ?></td>
                        <td class="action-buttons">
                            <div class="btn-group btn-group-sm">
                                <a href="website.php?edit=<?php echo $website['domain']; ?>" 
                                   class="btn btn-outline-primary" title="编辑">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="website_pages.php?domain=<?php echo $website['domain']; ?>&act=homepage" 
                                   class="btn btn-outline-info" title="管理内容">
                                    <i class="fas fa-file-alt"></i>
                                </a>
                                <a href="traffic.php?domain=<?php echo urlencode($website['domain']); ?>" 
                                   class="btn btn-outline-success" title="流量统计">
                                    <i class="fas fa-chart-line"></i>
                                </a>
                                <?php if ($_SESSION['role'] == 'admin'): ?>
                                <button onclick="confirmDelete('确定删除网站 <?php echo $website['domain']; ?>？', function() { 
                                    window.location.href = 'index.php?delete=<?php echo $website['domain']; ?>'; 
                                })" class="btn btn-outline-danger" title="删除">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary"><?php echo count($websites); ?></h3>
                <p class="text-muted mb-0">网站总数</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success"><?php 
                echo count(array_filter($websites, function($w) { 
                    if (isset($w['status'])) {
                        return $w['status'] === 'active';
                    } else {
                        return isset($w['active']) && $w['active'];
                    }
                })); 
                ?></h3>
                <p class="text-muted mb-0">启用站点</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <?php 
                // 计算今日所有网站的访客总和
                $total_today_visitors = 0;
                foreach ($websites as $website) {
                    $total_today_visitors += getTodayUniqueVisitors($website['domain']);
                }
                ?>
                <h3 class="text-info"><i class="fas fa-users"></i> <?php echo number_format($total_today_visitors); ?></h3>
                <p class="text-muted mb-0">今日访客汇总</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning"><?php echo count(array_unique(array_map(function($w) { return $w['type'].'_'.$w['theme']; }, $websites))); ?></h3>
                <p class="text-muted mb-0">独特主题</p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>