<?php
// 导航管理页面
$domain = $_GET['domain'] ?? '';
if (!$domain) {
    die('Domain parameter is required');
}

// 导航配置文件路径
$navbar_dir = "../navbars/{$domain}";
$navbar_file = "{$navbar_dir}/navbar.json";

// 确保目录存在
if (!file_exists($navbar_dir)) {
    mkdir($navbar_dir, 0777, true);
}

// 初始化导航数据
$navbar_items = [];
if (file_exists($navbar_file)) {
    $navbar_items = json_decode(file_get_contents($navbar_file), true) ?: [];
}

// 处理表单提交
$message = '';
$error = '';

// 添加导航项
if (isset($_POST['add_item'])) {
    $slug = trim($_POST['slug'] ?? '');
    $order = intval($_POST['order'] ?? 0);
    $active = isset($_POST['active']) ? true : false;
    
    if ($slug) {
        // 检查标签页面是否存在
        $tag_page_dir = "../pages/{$domain}/{$slug}";
        if (file_exists($tag_page_dir) && is_dir($tag_page_dir)) {
            // 检查是否已存在
            $exists = false;
            foreach ($navbar_items as $item) {
                if ($item['slug'] == $slug) {
                    $exists = true;
                    break;
                }
            }
            
            if (!$exists) {
                $navbar_items[] = [
                    'slug' => $slug,
                    'order' => $order,
                    'active' => $active
                ];
                
                // 按order排序
                usort($navbar_items, function($a, $b) {
                    return $a['order'] - $b['order'];
                });
                
                file_put_contents($navbar_file, json_encode($navbar_items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $message = '导航项添加成功';
            } else {
                $error = '该导航项已存在';
            }
        } else {
            $error = '标签页面不存在：' . $slug;
        }
    } else {
        $error = '请选择标签页面';
    }
}

// 删除导航项
if (isset($_GET['delete'])) {
    $delete_slug = $_GET['delete'];
    $navbar_items = array_filter($navbar_items, function($item) use ($delete_slug) {
        return $item['slug'] != $delete_slug;
    });
    $navbar_items = array_values($navbar_items); // 重新索引
    file_put_contents($navbar_file, json_encode($navbar_items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $message = '导航项已删除';
}

// 更新导航项
if (isset($_POST['update_items'])) {
    $updated_items = [];
    if (isset($_POST['items']) && is_array($_POST['items'])) {
        foreach ($_POST['items'] as $slug => $data) {
            $updated_items[] = [
                'slug' => $slug,
                'order' => intval($data['order'] ?? 0),
                'active' => isset($data['active']) ? true : false
            ];
        }
        
        // 按order排序
        usort($updated_items, function($a, $b) {
            return $a['order'] - $b['order'];
        });
        
        $navbar_items = $updated_items;
        file_put_contents($navbar_file, json_encode($navbar_items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $message = '导航项更新成功';
    }
}

// 获取所有标签页面
$pages_dir = "../pages/{$domain}";
$available_pages = [];
if (file_exists($pages_dir) && is_dir($pages_dir)) {
    $dirs = scandir($pages_dir);
    foreach ($dirs as $dir) {
        if ($dir != '.' && $dir != '..' && is_dir("{$pages_dir}/{$dir}")) {
            // 检查是否已在导航中
            $in_navbar = false;
            foreach ($navbar_items as $item) {
                if ($item['slug'] == $dir) {
                    $in_navbar = true;
                    break;
                }
            }
            if (!$in_navbar) {
                $available_pages[] = $dir;
            }
        }
    }
}

// 获取标签页面的标题
function getPageTitle($domain, $slug, $lang = 'en') {
    $page_file = "../pages/{$domain}/{$slug}/{$lang}.json";
    if (file_exists($page_file)) {
        $data = json_decode(file_get_contents($page_file), true);
        return $data['page']['h1'] ?? $data['page']['title'] ?? $slug;
    }
    
    // 如果当前语言不存在，尝试英文
    if ($lang != 'en') {
        return getPageTitle($domain, $slug, 'en');
    }
    
    return $slug;
}
?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bars"></i> 导航项管理
            </div>
            <div class="card-body">
                <?php if ($message): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <?php if (empty($navbar_items)): ?>
                <p class="text-muted">还没有添加导航项</p>
                <?php else: ?>
                <form method="post">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>排序</th>
                                <th>标签页面</th>
                                <th>显示文字</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($navbar_items as $item): ?>
                            <tr>
                                <td>
                                    <input type="number" name="items[<?php echo $item['slug']; ?>][order]" 
                                           value="<?php echo $item['order']; ?>" 
                                           class="form-control form-control-sm" style="width: 80px;">
                                </td>
                                <td>
                                    <code><?php echo htmlspecialchars($item['slug']); ?></code>
                                </td>
                                <td>
                                    <?php 
                                    $title = getPageTitle($domain, $item['slug']);
                                    echo htmlspecialchars($title);
                                    ?>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" 
                                               name="items[<?php echo $item['slug']; ?>][active]"
                                               <?php echo $item['active'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label">
                                            启用
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a href="?domain=<?php echo $domain; ?>&act=navbar&delete=<?php echo $item['slug']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('确定要删除这个导航项吗？');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" name="update_items" class="btn btn-primary">
                        <i class="fas fa-save"></i> 保存更改
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus"></i> 添加导航项
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="slug" class="form-label">选择标签页面</label>
                        <select name="slug" id="slug" class="form-select" required>
                            <option value="">-- 请选择 --</option>
                            <?php foreach ($available_pages as $page): ?>
                            <option value="<?php echo htmlspecialchars($page); ?>">
                                <?php 
                                $title = getPageTitle($domain, $page);
                                echo htmlspecialchars($page) . ' - ' . htmlspecialchars($title);
                                ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">只能选择已创建的标签页面</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="order" class="form-label">排序</label>
                        <input type="number" name="order" id="order" class="form-control" value="0">
                        <div class="form-text">数字越小越靠前</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="active" id="active" checked>
                            <label class="form-check-label" for="active">
                                启用此导航项
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" name="add_item" class="btn btn-success">
                        <i class="fas fa-plus"></i> 添加导航项
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> 使用说明
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li>导航项必须是已创建的标签页面</li>
                    <li>显示文字自动从页面的 h1 获取</li>
                    <li>如果当前语言没有，会使用英文版本</li>
                    <li>排序数字越小显示越靠前</li>
                    <li>取消勾选"启用"可临时隐藏导航项</li>
                </ul>
            </div>
        </div>
    </div>
</div>