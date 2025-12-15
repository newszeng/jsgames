<?php
require_once 'header.php';

// 域名列表文件
$domains_file = 'data/domain_list.json';
$domains = [];

// 确保数据目录存在
@mkdir('data', 0777, true);

// 加载现有域名列表
if (file_exists($domains_file)) {
    $domains = json_decode(file_get_contents($domains_file), true) ?: [];
}

// 加载已建站的域名列表
$websites_file = 'data/websites.json';
$used_domains = [];
if (file_exists($websites_file)) {
    $websites = json_decode(file_get_contents($websites_file), true) ?: [];
    foreach ($websites as $site) {
        $used_domains[] = $site['domain'];
    }
}

$message = '';
$error = '';

// 检查是否从网站管理页面跳转过来
if (isset($_GET['need_domain'])) {
    $error = '请先添加域名，然后才能创建网站';
}

// 处理添加域名
if (isset($_POST['add_domain'])) {
    $domain = trim($_POST['domain'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
    
    if ($domain) {
        // 验证域名格式
        if (!preg_match('/^([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/', $domain)) {
            $error = '域名格式不正确';
        } else {
            // 检查是否已存在
            $exists = false;
            foreach ($domains as $d) {
                if ($d['domain'] == $domain) {
                    $exists = true;
                    break;
                }
            }
            
            if ($exists) {
                $error = '域名已存在';
            } else {
                $domains[] = [
                    'domain' => $domain,
                    'notes' => $notes,
                    'created_at' => date('Y-m-d H:i:s'),
                    'is_used' => in_array($domain, $used_domains)
                ];
                
                file_put_contents($domains_file, json_encode($domains, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $message = '域名添加成功';
            }
        }
    } else {
        $error = '请输入域名';
    }
}

// 处理修改域名
if (isset($_POST['edit_domain'])) {
    $old_domain = $_POST['old_domain'] ?? '';
    $domain = trim($_POST['domain'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
    
    if ($domain && $old_domain) {
        // 验证域名格式
        if (!preg_match('/^([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/', $domain)) {
            $error = '域名格式不正确';
        } else {
            // 如果域名改变了，检查新域名是否已存在
            if ($domain != $old_domain) {
                $exists = false;
                foreach ($domains as $d) {
                    if ($d['domain'] == $domain) {
                        $exists = true;
                        break;
                    }
                }
                
                if ($exists) {
                    $error = '新域名已存在';
                }
            }
            
            if (!isset($error) || empty($error)) {
                // 更新域名信息
                foreach ($domains as $key => $d) {
                    if ($d['domain'] == $old_domain) {
                        $domains[$key]['domain'] = $domain;
                        $domains[$key]['notes'] = $notes;
                        $domains[$key]['updated_at'] = date('Y-m-d H:i:s');
                        break;
                    }
                }
                
                file_put_contents($domains_file, json_encode($domains, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $message = '域名修改成功';
            }
        }
    } else {
        $error = '请输入域名';
    }
}

// 处理批量添加域名
if (isset($_POST['batch_add_domains'])) {
    $batch_domains = trim($_POST['batch_domains'] ?? '');
    $notes = trim($_POST['batch_notes'] ?? '');
    
    if ($batch_domains) {
        $lines = explode("\n", $batch_domains);
        $added = 0;
        $skipped = 0;
        
        foreach ($lines as $line) {
            $domain = trim($line);
            if (empty($domain)) continue;
            
            // 验证域名格式
            if (!preg_match('/^([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/', $domain)) {
                $skipped++;
                continue;
            }
            
            // 检查是否已存在
            $exists = false;
            foreach ($domains as $d) {
                if ($d['domain'] == $domain) {
                    $exists = true;
                    break;
                }
            }
            
            if (!$exists) {
                $domains[] = [
                    'domain' => $domain,
                    'notes' => $notes,
                    'created_at' => date('Y-m-d H:i:s'),
                    'is_used' => in_array($domain, $used_domains)
                ];
                $added++;
            } else {
                $skipped++;
            }
        }
        
        if ($added > 0) {
            file_put_contents($domains_file, json_encode($domains, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $message = "成功添加 {$added} 个域名";
            if ($skipped > 0) {
                $message .= "，跳过 {$skipped} 个（已存在或格式错误）";
            }
        } else {
            $error = '没有添加任何域名（所有域名已存在或格式错误）';
        }
    } else {
        $error = '请输入域名列表';
    }
}

// 处理删除域名
if (isset($_GET['delete'])) {
    $delete_domain = $_GET['delete'];
    
    // 检查域名是否已被使用
    if (in_array($delete_domain, $used_domains)) {
        $error = '该域名已建站，无法删除';
    } else {
        $domains = array_filter($domains, function($d) use ($delete_domain) {
            return $d['domain'] != $delete_domain;
        });
        $domains = array_values($domains); // 重新索引
        
        file_put_contents($domains_file, json_encode($domains, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $message = '域名删除成功';
    }
}

// 更新域名的使用状态
foreach ($domains as &$domain) {
    $domain['is_used'] = in_array($domain['domain'], $used_domains);
}
unset($domain);

// 获取编辑域名信息
$edit_domain = null;
if (isset($_GET['edit'])) {
    $edit_domain_name = $_GET['edit'];
    foreach ($domains as $d) {
        if ($d['domain'] == $edit_domain_name) {
            $edit_domain = $d;
            break;
        }
    }
}

// 统计信息
$total_domains = count($domains);
$used_count = count(array_filter($domains, function($d) { return $d['is_used']; }));
$available_count = $total_domains - $used_count;
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">管理首页</a></li>
        <li class="breadcrumb-item active">域名管理</li>
    </ol>
</nav>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-globe"></i> 已绑定域名管理
                </h5>
                <p class="text-muted mb-0">
                    管理所有已绑定的域名，只有在这里添加的域名才能创建网站
                </p>
                <div class="mt-3">
                    <span class="badge bg-primary">总计：<?php echo $total_domains; ?> 个</span>
                    <span class="badge bg-success">已使用：<?php echo $used_count; ?> 个</span>
                    <span class="badge bg-secondary">未使用：<?php echo $available_count; ?> 个</span>
                </div>
            </div>
        </div>
    </div>
</div>

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

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list"></i> 域名列表
            </div>
            <div class="card-body">
                <?php if (empty($domains)): ?>
                <p class="text-muted text-center py-5">
                    还没有添加任何域名，请先添加域名
                </p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>域名</th>
                                <th>状态</th>
                                <th>备注</th>
                                <th>添加时间</th>
                                <th width="120">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($domains as $domain): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($domain['domain']); ?></strong>
                                </td>
                                <td>
                                    <?php if ($domain['is_used']): ?>
                                    <span class="badge bg-success">已建站</span>
                                    <?php else: ?>
                                    <span class="badge bg-secondary">未使用</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($domain['notes'] ?? ''); ?>
                                </td>
                                <td>
                                    <small><?php echo $domain['created_at']; ?></small>
                                </td>
                                <td>
                                    <a href="domain_list.php?edit=<?php echo urlencode($domain['domain']); ?>" 
                                       class="btn btn-sm btn-outline-primary" title="编辑">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <?php if ($domain['is_used']): ?>
                                    <a href="index.php" class="btn btn-sm btn-outline-info" title="管理网站">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <?php else: ?>
                                    <a href="website.php?domain=<?php echo urlencode($domain['domain']); ?>" 
                                       class="btn btn-sm btn-outline-success" title="创建网站">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <button onclick="confirmDelete('确定要删除域名 <?php echo htmlspecialchars($domain['domain']); ?>？', function() { 
                                        window.location.href = 'domain_list.php?delete=<?php echo urlencode($domain['domain']); ?>'; 
                                    })" class="btn btn-sm btn-outline-danger" title="删除">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php endif; ?>
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
        <div class="card">
            <div class="card-header">
                <i class="fas fa-<?php echo $edit_domain ? 'edit' : 'plus-circle'; ?>"></i> 
                <?php echo $edit_domain ? '编辑域名' : '添加域名'; ?>
            </div>
            <div class="card-body">
                <?php if ($edit_domain): ?>
                <div class="alert alert-info">
                    正在编辑域名: <strong><?php echo htmlspecialchars($edit_domain['domain']); ?></strong>
                    <a href="domain_list.php" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-times"></i> 取消编辑
                    </a>
                </div>
                <?php endif; ?>
                
                <form method="post">
                    <?php if ($edit_domain): ?>
                    <input type="hidden" name="edit_domain" value="1">
                    <input type="hidden" name="old_domain" value="<?php echo htmlspecialchars($edit_domain['domain']); ?>">
                    <?php else: ?>
                    <input type="hidden" name="add_domain" value="1">
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="domain" class="form-label">域名</label>
                        <input type="text" class="form-control" id="domain" name="domain" 
                               value="<?php echo $edit_domain ? htmlspecialchars($edit_domain['domain']) : ''; ?>"
                               placeholder="example.com" required
                               <?php echo ($edit_domain && $edit_domain['is_used']) ? 'readonly' : ''; ?>>
                        <div class="form-text">
                            <?php if ($edit_domain && $edit_domain['is_used']): ?>
                            已建站的域名不能修改域名名称
                            <?php else: ?>
                            请输入完整域名，如：example.com
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">备注（可选）</label>
                        <input type="text" class="form-control" id="notes" name="notes" 
                               value="<?php echo $edit_domain ? htmlspecialchars($edit_domain['notes'] ?? '') : ''; ?>"
                               placeholder="域名用途说明">
                    </div>
                    
                    <button type="submit" class="btn btn-<?php echo $edit_domain ? 'success' : 'primary'; ?>">
                        <i class="fas fa-<?php echo $edit_domain ? 'save' : 'plus'; ?>"></i> 
                        <?php echo $edit_domain ? '保存修改' : '添加域名'; ?>
                    </button>
                    
                    <?php if ($edit_domain): ?>
                    <a href="domain_list.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> 取消
                    </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        
        <?php if (!$edit_domain): ?>
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-upload"></i> 批量添加
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="batch_domains" class="form-label">域名列表</label>
                        <textarea class="form-control" id="batch_domains" name="batch_domains" 
                                  rows="6" placeholder="每行一个域名，例如：&#10;domain1.com&#10;domain2.com&#10;domain3.com" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="batch_notes" class="form-label">统一备注（可选）</label>
                        <input type="text" class="form-control" id="batch_notes" name="batch_notes" 
                               placeholder="批量添加的域名备注">
                    </div>
                    
                    <button type="submit" name="batch_add_domains" class="btn btn-success">
                        <i class="fas fa-file-import"></i> 批量添加
                    </button>
                </form>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> 使用说明
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li>所有域名必须先在此处添加</li>
                    <li>每个域名只能创建一个网站</li>
                    <li>已建站的域名无法删除</li>
                    <li>支持批量添加域名</li>
                    <li>域名格式：example.com</li>
                    <li>点击编辑按钮可修改域名和备注</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>