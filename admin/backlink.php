<?php
require_once 'header.php';

$backlinks_file = 'data/backlinks.json';
$backlinks = [];

// 读取外链库
if (file_exists($backlinks_file)) {
    $backlinks = json_decode(file_get_contents($backlinks_file), true) ?: [];
}

// 处理添加外链
if (isset($_POST['add_backlink'])) {
    $new_backlink = [
        'id' => uniqid(),
        'title' => $_POST['title'] ?? '',
        'url' => $_POST['url'] ?? '',
        'category' => $_POST['category'] ?? 'general',
        'description' => $_POST['description'] ?? '',
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $backlinks[] = $new_backlink;
    file_put_contents($backlinks_file, json_encode($backlinks, JSON_PRETTY_PRINT));
    $success = '反向链接已添加到全局库';
}

// 处理编辑
if (isset($_POST['edit_backlink'])) {
    $edit_id = $_POST['edit_id'] ?? '';
    foreach ($backlinks as &$backlink) {
        if ($backlink['id'] == $edit_id) {
            $backlink['title'] = $_POST['title'] ?? '';
            $backlink['url'] = $_POST['url'] ?? '';
            $backlink['category'] = $_POST['category'] ?? 'general';
            $backlink['description'] = $_POST['description'] ?? '';
            $backlink['updated_at'] = date('Y-m-d H:i:s');
            break;
        }
    }
    
    file_put_contents($backlinks_file, json_encode($backlinks, JSON_PRETTY_PRINT));
    $success = '反向链接更新成功';
}

// 处理删除
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $backlinks = array_filter($backlinks, function($link) use ($delete_id) {
        return $link['id'] != $delete_id;
    });
    
    file_put_contents($backlinks_file, json_encode(array_values($backlinks), JSON_PRETTY_PRINT));
    header('Location: backlink.php?deleted=1');
    exit();
}

// 获取编辑数据
$edit_data = [];
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    foreach ($backlinks as $backlink) {
        if ($backlink['id'] == $edit_id) {
            $edit_data = $backlink;
            break;
        }
    }
}

// 分类统计
$categories = [];
foreach ($backlinks as $link) {
    $cat = $link['category'] ?? 'general';
    if (!isset($categories[$cat])) {
        $categories[$cat] = 0;
    }
    $categories[$cat]++;
}
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">管理首页</a></li>
        <li class="breadcrumb-item active">全局反向链接库</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-link"></i> 全局反向链接库</span>
                <span class="badge bg-primary">共 <?php echo count($backlinks); ?> 个链接</span>
            </div>
            <div class="card-body">
                <?php if (isset($_GET['deleted'])): ?>
                <div class="alert alert-success">反向链接删除成功</div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <?php if (empty($backlinks)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-link fa-3x text-muted mb-3"></i>
                    <p class="text-muted">库中还没有反向链接。请使用表单添加第一个反向链接。</p>
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>标题</th>
                                <th>URL</th>
                                <th>分类</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($backlinks as $link): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($link['title']); ?></strong>
                                    <?php if (!empty($link['description'])): ?>
                                    <br><small class="text-muted"><?php echo htmlspecialchars($link['description']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank" class="text-decoration-none">
                                        <?php echo htmlspecialchars(substr($link['url'], 0, 40)); ?>...
                                        <i class="fas fa-external-link-alt small"></i>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?php echo ucfirst($link['category'] ?? 'general'); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="backlink.php?edit=<?php echo $link['id']; ?>" 
                                           class="btn btn-outline-primary" title="编辑">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete('删除该反向链接？', function() { 
                                            window.location.href = 'backlink.php?delete=<?php echo $link['id']; ?>'; 
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
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-section">
            <h4><?php echo !empty($edit_data) ? '编辑' : '添加新'; ?>反向链接</h4>
            
            <form method="post">
                <?php if (!empty($edit_data)): ?>
                <input type="hidden" name="edit_backlink" value="1">
                <input type="hidden" name="edit_id" value="<?php echo $edit_data['id']; ?>">
                <?php else: ?>
                <input type="hidden" name="add_backlink" value="1">
                <?php endif; ?>
                
                <div class="mb-3">
                    <label for="title" class="form-label">标题</label>
                    <input type="text" class="form-control" id="title" name="title" 
                           value="<?php echo htmlspecialchars($edit_data['title'] ?? ''); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="url" class="form-label">URL</label>
                    <input type="url" class="form-control" id="url" name="url" 
                           value="<?php echo htmlspecialchars($edit_data['url'] ?? ''); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="category" class="form-label">分类</label>
                    <select class="form-select" id="category" name="category">
                        <option value="general" <?php echo (($edit_data['category'] ?? '') == 'general') ? 'selected' : ''; ?>>一般</option>
                        <option value="tools" <?php echo (($edit_data['category'] ?? '') == 'tools') ? 'selected' : ''; ?>>工具</option>
                        <option value="resources" <?php echo (($edit_data['category'] ?? '') == 'resources') ? 'selected' : ''; ?>>资源</option>
                        <option value="partners" <?php echo (($edit_data['category'] ?? '') == 'partners') ? 'selected' : ''; ?>>合作伙伴</option>
                        <option value="social" <?php echo (($edit_data['category'] ?? '') == 'social') ? 'selected' : ''; ?>>社交媒体</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">描述 (可选)</label>
                    <input type="text" class="form-control" id="description" name="description" 
                           value="<?php echo htmlspecialchars($edit_data['description'] ?? ''); ?>"
                           placeholder="链接的简要描述">
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?php echo !empty($edit_data) ? '更新' : '添加'; ?> 反向链接
                    </button>
                    <?php if (!empty($edit_data)): ?>
                    <a href="backlink.php" class="btn btn-secondary">取消</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <?php if (!empty($categories)): ?>
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-chart-pie"></i> 分类
            </div>
            <div class="card-body">
                <?php foreach ($categories as $cat => $count): ?>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span><?php echo ucfirst($cat); ?></span>
                    <span class="badge bg-primary"><?php echo $count; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> 关于全局库
            </div>
            <div class="card-body">
                <p class="small mb-2">全局反向链接库允许您维护一个集中的优质反向链接集合。</p>
                <p class="small mb-0">您可以从网站的反向链接管理页面轻松地将这些链接添加到任何网站。</p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>