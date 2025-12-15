<?php
require_once 'header.php';

$prompts_file = 'data/prompts.json';
$prompts = [];
$error = '';
$success = '';

// 确保数据目录存在
@mkdir('data', 0777, true);

// 加载现有的提示词
if (file_exists($prompts_file)) {
    $prompts = json_decode(file_get_contents($prompts_file), true) ?: [];
}

// 如果没有提示词，创建默认的
if (empty($prompts)) {
    $prompts = [
        [
            'id' => 1,
            'name' => 'SEO文案生成模板',
            'template' => '请按我的语言包格式，生成一套能够在 google seo 效果很好的文案json，

我的站点名是 {site_name}，
我的主关键词是 {main_keywords}，

SEO要求:
  {main_keywords} 在 seo title 精准靠前出现，标题尽量参考Serp中同行的写法，
  seo description 尽量通俗化，参考Serp中同行的写法，并且包含主关键词，
  {main_keywords} 密度控制在3-5%，尽量往上，
  页面布局要尽可能含{main_keywords} 的LSI关键词的布局,
  
数据结构一致性:
  1. 请保持json的key和我的示例json是完全一致，
  2. 我的示例json: 

{lang_json}

数据事实参考：
  另外生成的内容需要参考 google SERP搜索结果: {serp_json}

数据返回要求：
  请直接返回完整的JSON格式内容，不要添加任何额外的解释文字。
  确保JSON格式化正确且可以直接解析。index字段必须有数字值，不能为空。',
            'created_at' => date('Y-m-d H:i:s'),
            'is_active' => true
        ]
    ];
    file_put_contents($prompts_file, json_encode($prompts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// 处理删除提示词
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $prompts = array_filter($prompts, function($prompt) use ($id) {
        return $prompt['id'] != $id;
    });
    file_put_contents($prompts_file, json_encode(array_values($prompts), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $success = '提示词删除成功';
}

// 处理设置默认提示词
if (isset($_GET['set_default'])) {
    $id = (int)$_GET['set_default'];
    foreach ($prompts as &$prompt) {
        $prompt['is_active'] = ($prompt['id'] == $id);
    }
    file_put_contents($prompts_file, json_encode($prompts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $success = '默认提示词设置成功';
}

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $template = trim($_POST['template'] ?? '');
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    if (empty($name)) {
        $error = '提示词名称不能为空';
    } elseif (empty($template)) {
        $error = '提示词模板不能为空';
    } else {
        if ($id > 0) {
            // 更新现有提示词
            foreach ($prompts as &$prompt) {
                if ($prompt['id'] == $id) {
                    $prompt['name'] = $name;
                    $prompt['template'] = $template;
                    $prompt['updated_at'] = date('Y-m-d H:i:s');
                    break;
                }
            }
            $success = '提示词更新成功';
        } else {
            // 创建新提示词
            $new_id = empty($prompts) ? 1 : max(array_column($prompts, 'id')) + 1;
            $prompts[] = [
                'id' => $new_id,
                'name' => $name,
                'template' => $template,
                'created_at' => date('Y-m-d H:i:s'),
                'is_active' => false
            ];
            $success = '提示词创建成功';
        }
        file_put_contents($prompts_file, json_encode($prompts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

// 获取编辑的提示词
$edit_prompt = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    foreach ($prompts as $prompt) {
        if ($prompt['id'] == $edit_id) {
            $edit_prompt = $prompt;
            break;
        }
    }
}
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">管理首页</a></li>
        <li class="breadcrumb-item active">提示词管理</li>
    </ol>
</nav>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-robot"></i> 提示词管理
                </h5>
                <p class="text-muted">管理AI生成文案的提示词模板，支持变量替换和多模板切换</p>
            </div>
        </div>
    </div>
</div>

<?php if ($error): ?>
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
</div>
<?php endif; ?>

<?php if ($success): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit"></i> <?php echo $edit_prompt ? '编辑提示词' : '创建新提示词'; ?>
            </div>
            <div class="card-body">
                <form method="post">
                    <?php if ($edit_prompt): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_prompt['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">提示词名称</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?php echo htmlspecialchars($edit_prompt['name'] ?? ''); ?>" 
                               placeholder="输入提示词名称，如：SEO文案生成模板" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="template" class="form-label">提示词模板</label>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> <strong>支持的变量：</strong>
                            <ul class="mb-0 mt-2">
                                <li><code>{site_name}</code> - 站点名称</li>
                                <li><code>{main_keywords}</code> - 主关键词</li>
                                <li><code>{lang_json}</code> - 语言包JSON内容</li>
                                <li><code>{serp_json}</code> - Google SERP搜索结果JSON</li>
                            </ul>
                        </div>
                        <textarea class="form-control" id="template" name="template" rows="20" 
                                  placeholder="输入提示词模板，可以使用变量如 {site_name}、{main_keywords} 等" required><?php echo htmlspecialchars($edit_prompt['template'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> <?php echo $edit_prompt ? '更新提示词' : '创建提示词'; ?>
                            </button>
                            <?php if ($edit_prompt): ?>
                            <a href="prompt.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> 取消编辑
                            </a>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-outline-info" onclick="showVariableHelp()">
                            <i class="fas fa-question-circle"></i> 变量说明
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list"></i> 现有提示词 (<?php echo count($prompts); ?>)
            </div>
            <div class="card-body">
                <?php if (empty($prompts)): ?>
                <p class="text-muted mb-0">还没有创建提示词</p>
                <?php else: ?>
                <div class="list-group">
                    <?php foreach ($prompts as $prompt): ?>
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <?php echo htmlspecialchars($prompt['name']); ?>
                                    <?php if ($prompt['is_active']): ?>
                                    <span class="badge bg-success">默认</span>
                                    <?php endif; ?>
                                </h6>
                                <small class="text-muted">
                                    创建时间: <?php echo $prompt['created_at']; ?>
                                    <?php if (isset($prompt['updated_at'])): ?>
                                    <br>更新时间: <?php echo $prompt['updated_at']; ?>
                                    <?php endif; ?>
                                </small>
                            </div>
                            <div class="btn-group btn-group-sm">
                                <?php if (!$prompt['is_active']): ?>
                                <a href="prompt.php?set_default=<?php echo $prompt['id']; ?>" 
                                   class="btn btn-outline-success" title="设为默认">
                                    <i class="fas fa-star"></i>
                                </a>
                                <?php endif; ?>
                                <a href="prompt.php?edit=<?php echo $prompt['id']; ?>" 
                                   class="btn btn-outline-primary" title="编辑">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete('删除提示词 <?php echo htmlspecialchars($prompt['name']); ?>？', function() { 
                                    window.location.href = 'prompt.php?delete=<?php echo $prompt['id']; ?>'; 
                                })" class="btn btn-outline-danger" title="删除">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> 使用说明
            </div>
            <div class="card-body">
                <ul class="small">
                    <li><strong>创建模板:</strong> 填写名称和模板内容</li>
                    <li><strong>使用变量:</strong> 用花括号包围变量名</li>
                    <li><strong>设为默认:</strong> 点击星形图标设为默认模板</li>
                    <li><strong>在首页使用:</strong> 选择模板后生成提示词</li>
                </ul>
                <hr>
                <p class="small mb-0">
                    <strong>变量替换示例:</strong><br>
                    <code>{site_name}</code> → Y2mate<br>
                    <code>{main_keywords}</code> → YouTube Downloader
                </p>
            </div>
        </div>
    </div>
</div>

<!-- 变量说明模态框 -->
<div class="modal fade" id="variableModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-code"></i> 提示词变量说明
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>变量名</th>
                                <th>描述</th>
                                <th>示例值</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>{site_name}</code></td>
                                <td>站点名称，从语言包的site_name字段获取</td>
                                <td>Y2mate</td>
                            </tr>
                            <tr>
                                <td><code>{main_keywords}</code></td>
                                <td>主关键词，用户输入或从home.title获取</td>
                                <td>YouTube Downloader</td>
                            </tr>
                            <tr>
                                <td><code>{lang_json}</code></td>
                                <td>完整的语言包JSON内容</td>
                                <td>{"site_name": "...", "home": {...}}</td>
                            </tr>
                            <tr>
                                <td><code>{serp_json}</code></td>
                                <td>Google SERP搜索结果JSON数据</td>
                                <td>{"search_results": [...], "paa": [...]}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> <strong>注意事项：</strong>
                    <ul class="mb-0 mt-2">
                        <li>变量名区分大小写，必须完全匹配</li>
                        <li>花括号 {} 是必需的，不能省略</li>
                        <li>如果变量不存在，将显示原始文本</li>
                        <li>建议在模板中添加备用文本处理</li>
                    </ul>
                </div>
                
                <h6><i class="fas fa-lightbulb"></i> 模板示例：</h6>
                <pre class="bg-light p-3 rounded"><code>请帮我优化 {site_name} 的SEO内容。

主要关键词：{main_keywords}

SEO要求：
关键词密度控制在3-5%
你的标题要求
你的内容要求

请参考以下JSON结构生成内容：
{lang_json}

同时参考搜索结果数据：
{serp_json}

数据返回要求：
  请直接返回完整的JSON格式内容，不要添加任何额外的解释文字。
  确保JSON格式化正确且可以直接解析。
</code></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<script>
function showVariableHelp() {
    const modal = new bootstrap.Modal(document.getElementById('variableModal'));
    modal.show();
}

// 自动调整textarea高度
document.getElementById('template').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});
</script>

<?php require_once 'footer.php'; ?>