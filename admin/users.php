<?php
session_start();

// 检查是否已登录且为管理员
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';
$edit_mode = false;
$edit_data = [];

// 用户角色
$roles = [
    'admin' => '管理员',
    'editor' => '编辑者',
    'user' => '普通用户'
];

// 读取用户列表
$users = json_decode(file_get_contents('data/users.json'), true) ?: [];

// 编辑模式
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = (int)$_GET['edit'];
    foreach ($users as $user) {
        if ($user['id'] == $edit_id) {
            $edit_data = $user;
            break;
        }
    }
}

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'user';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($email)) {
        $error = '用户名和邮箱是必填项';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = '邮箱格式无效';
    } else {
        if ($edit_mode) {
            // 更新用户
            $edit_id = (int)$_POST['edit_id'];
            
            // 检查用户名是否已被其他用户使用
            $username_exists = false;
            foreach ($users as $user) {
                if ($user['username'] == $username && $user['id'] != $edit_id) {
                    $username_exists = true;
                    break;
                }
            }
            
            if ($username_exists) {
                $error = '用户名已存在';
            } else {
                // 更新用户信息
                foreach ($users as &$user) {
                    if ($user['id'] == $edit_id) {
                        $user['username'] = $username;
                        $user['email'] = $email;
                        $user['role'] = $role;
                        $user['updated_at'] = date('Y-m-d H:i:s');
                        
                        // 如果提供了新密码则更新密码
                        if (!empty($password)) {
                            $user['password'] = password_hash($password, PASSWORD_DEFAULT);
                        }
                        
                        break;
                    }
                }
                
                file_put_contents('data/users.json', json_encode($users, JSON_PRETTY_PRINT));
                $success = '用户更新成功';
            }
        } else {
            // 添加新用户
            if (empty($password)) {
                $error = '新用户必须设置密码';
            } else {
                // 检查用户名是否已存在
                $username_exists = false;
                foreach ($users as $user) {
                    if ($user['username'] == $username) {
                        $username_exists = true;
                        break;
                    }
                }
                
                if ($username_exists) {
                    $error = '用户名已存在';
                } else {
                    // 生成新的用户ID
                    $new_id = 1;
                    foreach ($users as $user) {
                        if ($user['id'] >= $new_id) {
                            $new_id = $user['id'] + 1;
                        }
                    }
                    
                    // 添加新用户
                    $new_user = [
                        'id' => $new_id,
                        'username' => $username,
                        'email' => $email,
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'role' => $role,
                        'created_at' => date('Y-m-d H:i:s'),
                        'last_login' => null
                    ];
                    
                    $users[] = $new_user;
                    file_put_contents('data/users.json', json_encode($users, JSON_PRETTY_PRINT));
                    $success = '用户添加成功';
                }
            }
        }
        
        if (!$error && !$edit_mode) {
            header('Location: users.php?added=1');
            exit();
        } elseif (!$error && $edit_mode) {
            header('Location: users.php?updated=1');
            exit();
        }
    }
}

// 处理删除用户
if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    
    // 不能删除当前登录的用户
    if ($delete_id == $_SESSION['user_id']) {
        $error = '不能删除当前登录的用户';
    } else {
        $users = array_filter($users, function($user) use ($delete_id) {
            return $user['id'] != $delete_id;
        });
        
        file_put_contents('data/users.json', json_encode(array_values($users), JSON_PRETTY_PRINT));
        header('Location: users.php?deleted=1');
        exit();
    }
}

// 现在包含header开始HTML输出
require_once 'header.php';
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">管理首页</a></li>
        <li class="breadcrumb-item active">用户管理</li>
    </ol>
</nav>

<?php if (isset($_GET['added'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> 用户添加成功！
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (isset($_GET['updated'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> 用户更新成功！
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (isset($_GET['deleted'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> 用户删除成功！
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users"></i> 用户管理</span>
                <span class="badge bg-primary">共 <?php echo count($users); ?> 个用户</span>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <?php if (empty($users)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <p class="text-muted">暂无用户。</p>
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>用户名</th>
                                <th>邮箱</th>
                                <th>角色</th>
                                <th>创建时间</th>
                                <th>最后登录</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                                    <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                    <small class="text-primary">(当前用户)</small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $user['role'] == 'admin' ? 'danger' : ($user['role'] == 'editor' ? 'warning' : 'secondary'); ?>">
                                        <?php echo $roles[$user['role']] ?? $user['role']; ?>
                                    </span>
                                </td>
                                <td><?php echo date('Y-m-d H:i', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <?php if ($user['last_login']): ?>
                                    <?php echo date('Y-m-d H:i', strtotime($user['last_login'])); ?>
                                    <?php else: ?>
                                    <span class="text-muted">从未登录</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="users.php?edit=<?php echo $user['id']; ?>" 
                                           class="btn btn-outline-primary" title="编辑">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                        <button onclick="confirmDelete('删除用户 <?php echo htmlspecialchars($user['username']); ?>？', function() { 
                                            window.location.href = 'users.php?delete=<?php echo $user['id']; ?>'; 
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
    </div>
    
    <div class="col-md-4">
        <div class="form-section">
            <h4><?php echo $edit_mode ? '编辑' : '添加新'; ?>用户</h4>
            
            <form method="post">
                <?php if ($edit_mode): ?>
                <input type="hidden" name="edit_id" value="<?php echo $edit_data['id']; ?>">
                <?php endif; ?>
                
                <div class="mb-3">
                    <label for="username" class="form-label">用户名</label>
                    <input type="text" class="form-control" id="username" name="username" 
                           value="<?php echo htmlspecialchars($edit_data['username'] ?? ''); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">邮箱</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?php echo htmlspecialchars($edit_data['email'] ?? ''); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="role" class="form-label">角色</label>
                    <select class="form-select" id="role" name="role">
                        <?php foreach ($roles as $role_key => $role_name): ?>
                        <option value="<?php echo $role_key; ?>" 
                                <?php echo (($edit_data['role'] ?? 'user') == $role_key) ? 'selected' : ''; ?>>
                            <?php echo $role_name; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">
                        密码 <?php echo $edit_mode ? '(留空则不修改)' : ''; ?>
                    </label>
                    <input type="password" class="form-control" id="password" name="password" 
                           <?php echo $edit_mode ? '' : 'required'; ?>>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?php echo $edit_mode ? '更新' : '添加'; ?>用户
                    </button>
                    <?php if ($edit_mode): ?>
                    <a href="users.php" class="btn btn-secondary">取消</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> 角色说明
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <span class="badge bg-danger">管理员</span>
                    <small class="text-muted ms-2">拥有所有权限，包括用户管理</small>
                </div>
                <div class="mb-2">
                    <span class="badge bg-warning">编辑者</span>
                    <small class="text-muted ms-2">可以管理网站内容，但不能管理用户</small>
                </div>
                <div class="mb-0">
                    <span class="badge bg-secondary">普通用户</span>
                    <small class="text-muted ms-2">只能查看和编辑分配给的网站</small>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-shield-alt"></i> 安全提醒
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li>密码将自动加密存储</li>
                    <li>不能删除当前登录的用户</li>
                    <li>建议定期更换密码</li>
                    <li>管理员角色请谨慎分配</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>