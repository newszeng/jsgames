<?php
// 这个文件被 website_pages.php 包含，$domain 变量已经可用

$backlinks_file = "../backlinks/{$domain}/backlinks.json";
$global_backlinks_file = "data/backlinks.json";
$success = '';
$error = '';
$edit_mode = false;
$edit_data = [];

// 确保目录存在
@mkdir(dirname($backlinks_file), 0777, true);

// 读取站点外链
$site_backlinks = [];
if (file_exists($backlinks_file)) {
    $site_backlinks = json_decode(file_get_contents($backlinks_file), true) ?: [];
}

// 读取全局外链库
$global_backlinks = [];
if (file_exists($global_backlinks_file)) {
    $global_backlinks = json_decode(file_get_contents($global_backlinks_file), true) ?: [];
}

// 检查URL参数中的成功消息
if (isset($_GET['deleted']) && $_GET['deleted'] == '1') {
    $success = '反向链接删除成功';
} elseif (isset($_GET['added']) && $_GET['added'] == '1') {
    $success = '从全局库添加反向链接成功';
}

// 处理从全局库添加
if (isset($_POST['add_from_global'])) {
    $global_ids = $_POST['global_links'] ?? [];
    foreach ($global_ids as $global_id) {
        foreach ($global_backlinks as $global_link) {
            if ($global_link['id'] == $global_id) {
                // 检查是否已存在
                $exists = false;
                foreach ($site_backlinks as $site_link) {
                    if ($site_link['url'] == $global_link['url']) {
                        $exists = true;
                        break;
                    }
                }
                
                if (!$exists) {
                    $new_link = $global_link;
                    $new_link['id'] = uniqid();
                    $new_link['active'] = true;
                    // 确保有必要的字段
                    $new_link['position'] = $new_link['position'] ?? 'footer';
                    $new_link['target'] = $new_link['target'] ?? '_blank';
                    $new_link['rel'] = $new_link['rel'] ?? 'nofollow';
                    $site_backlinks[] = $new_link;
                }
            }
        }
    }
    
    file_put_contents($backlinks_file, json_encode($site_backlinks, JSON_PRETTY_PRINT));
    $success = '从全局库添加反向链接成功';
}

// 处理删除
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $site_backlinks = array_filter($site_backlinks, function($link) use ($delete_id) {
        return $link['id'] != $delete_id;
    });
    
    file_put_contents($backlinks_file, json_encode(array_values($site_backlinks), JSON_PRETTY_PRINT));
    $success = '反向链接删除成功';
}

// 处理状态切换
if (isset($_GET['toggle'])) {
    $toggle_id = $_GET['toggle'];
    foreach ($site_backlinks as &$link) {
        if ($link['id'] == $toggle_id) {
            $link['active'] = !$link['active'];
            break;
        }
    }
    
    file_put_contents($backlinks_file, json_encode($site_backlinks, JSON_PRETTY_PRINT));
    $success = '反向链接状态切换成功';
}

// 处理编辑
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = $_GET['edit'];
    foreach ($site_backlinks as $link) {
        if ($link['id'] == $edit_id) {
            $edit_data = $link;
            break;
        }
    }
}

// 处理编辑表单提交
if (isset($_POST['update_link'])) {
    $update_id = $_POST['update_id'];
    foreach ($site_backlinks as &$link) {
        if ($link['id'] == $update_id) {
            $link['position'] = $_POST['position'] ?? 'footer';
            $link['target'] = $_POST['target'] ?? '_blank';
            $link['rel'] = $_POST['rel'] ?? 'nofollow';
            $link['active'] = isset($_POST['active']);
            break;
        }
    }
    
    file_put_contents($backlinks_file, json_encode($site_backlinks, JSON_PRETTY_PRINT));
    $success = '反向链接更新成功';
    $edit_mode = false;
    $edit_data = [];
}
?>

<div class="row">
    <div class="col-md-8">
        <div class="form-section">
            <h4>网站反向链接管理</h4>
            
            <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <h5 class="mb-3">当前反向链接</h5>
            
            <?php if (empty($site_backlinks)): ?>
            <div class="alert alert-info">还没有添加反向链接。请从右侧的全局库中选择添加链接。</div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>标题</th>
                            <th>URL</th>
                            <th>位置</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($site_backlinks as $link): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($link['title']); ?></td>
                            <td>
                                <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank" class="text-decoration-none">
                                    <?php echo htmlspecialchars($link['url']); ?>
                                    <i class="fas fa-external-link-alt small"></i>
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    <?php echo ucfirst($link['position'] ?? 'footer'); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo $link['active'] ? 'success' : 'danger'; ?>">
                                    <?php echo $link['active'] ? '启用' : '禁用'; ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="website_pages.php?domain=<?php echo $domain; ?>&act=sitelinks&edit=<?php echo $link['id']; ?>" 
                                       class="btn btn-outline-primary" title="编辑">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="website_pages.php?domain=<?php echo $domain; ?>&act=sitelinks&toggle=<?php echo $link['id']; ?>" 
                                       class="btn btn-outline-secondary" title="切换状态">
                                        <i class="fas fa-toggle-<?php echo $link['active'] ? 'on' : 'off'; ?>"></i>
                                    </a>
                                    <button onclick="confirmDelete('删除该反向链接？', function() { 
                                        window.location.href = 'website_pages.php?domain=<?php echo $domain; ?>&act=sitelinks&delete=<?php echo $link['id']; ?>'; 
                                    })" class="btn btn-outline-danger" title="删除">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
            
            <?php if ($edit_mode && $edit_data): ?>
            <hr class="my-4">
            <h5 class="mb-3">编辑反向链接设置</h5>
            <form method="post">
                <input type="hidden" name="update_link" value="1">
                <input type="hidden" name="update_id" value="<?php echo $edit_data['id']; ?>">
                
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>标题：</strong> <?php echo htmlspecialchars($edit_data['title']); ?>
                        </div>
                        <div class="mb-3">
                            <strong>URL：</strong> 
                            <a href="<?php echo htmlspecialchars($edit_data['url']); ?>" target="_blank">
                                <?php echo htmlspecialchars($edit_data['url']); ?>
                                <i class="fas fa-external-link-alt small"></i>
                            </a>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="position" class="form-label">位置</label>
                                    <select class="form-select" id="position" name="position">
                                        <option value="footer" <?php echo ($edit_data['position'] ?? 'footer') == 'footer' ? 'selected' : ''; ?>>页脚</option>
                                        <option value="header" <?php echo ($edit_data['position'] ?? '') == 'header' ? 'selected' : ''; ?>>头部导航</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="target" class="form-label">打开方式</label>
                                    <select class="form-select" id="target" name="target">
                                        <option value="_blank" <?php echo ($edit_data['target'] ?? '_blank') == '_blank' ? 'selected' : ''; ?>>新窗口</option>
                                        <option value="_self" <?php echo ($edit_data['target'] ?? '') == '_self' ? 'selected' : ''; ?>>当前窗口</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="rel" class="form-label">Rel属性</label>
                                    <select class="form-select" id="rel" name="rel">
                                        <option value="nofollow" <?php echo ($edit_data['rel'] ?? 'nofollow') == 'nofollow' ? 'selected' : ''; ?>>nofollow</option>
                                        <option value="dofollow" <?php echo ($edit_data['rel'] ?? '') == 'dofollow' ? 'selected' : ''; ?>>dofollow</option>
                                        <option value="sponsored" <?php echo ($edit_data['rel'] ?? '') == 'sponsored' ? 'selected' : ''; ?>>sponsored</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="active" name="active" 
                                       <?php echo ($edit_data['active'] ?? true) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="active">
                                    启用 (在网站上显示)
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 保存更改
                            </button>
                            <a href="website_pages.php?domain=<?php echo $domain; ?>&act=sitelinks" class="btn btn-secondary">
                                取消
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            <?php endif; ?>
            
            <div class="alert alert-info mt-4">
                <i class="fas fa-info-circle"></i> 
                <strong>提示：</strong>反向链接只能从全局库中添加。请从右侧选择需要的链接，或者先到 
                <a href="backlink.php" class="alert-link">全局反向链接库</a> 中添加新链接。
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-database"></i> 全局反向链接库
            </div>
            <div class="card-body">
                <?php if (empty($global_backlinks)): ?>
                <p class="text-muted">全局库中还没有反向链接。</p>
                <a href="backlink.php" class="btn btn-sm btn-primary">管理全局库</a>
                <?php else: ?>
                <form method="post">
                    <input type="hidden" name="add_from_global" value="1">
                    <div class="mb-3" style="max-height: 300px; overflow-y: auto;">
                        <?php foreach ($global_backlinks as $global_link): ?>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" 
                                   name="global_links[]" 
                                   value="<?php echo $global_link['id']; ?>" 
                                   id="global_<?php echo $global_link['id']; ?>">
                            <label class="form-check-label small" for="global_<?php echo $global_link['id']; ?>">
                                <strong><?php echo htmlspecialchars($global_link['title']); ?></strong><br>
                                <span class="text-muted"><?php echo htmlspecialchars($global_link['url']); ?></span>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success w-100">
                        <i class="fas fa-plus"></i> 将选中的添加到网站
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> 反向链接位置
            </div>
            <div class="card-body">
                <p class="small mb-2"><strong>头部导航:</strong> 链接显示在顶部导航菜单中</p>
                <p class="small mb-0"><strong>页脚:</strong> 链接显示在页脚区域</p>
            </div>
        </div>
    </div>
</div>