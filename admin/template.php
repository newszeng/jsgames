<?php
// 这个文件被 website_pages.php 包含，$domain 变量已经可用

$template_dir = "../tpl/{$domain}";
$static_dir = "../static/{$domain}";
$current_file = $_GET['file'] ?? '';
$file_type = $_GET['type'] ?? 'template';

// 获取模板文件列表
$template_files = [];
if (is_dir($template_dir)) {
    $files = scandir($template_dir);
    foreach ($files as $file) {
        if (preg_match('/\.(php|html?)$/', $file)) {
            $template_files[] = $file;
        }
    }
}

// 处理文件保存
if (isset($_POST['save_file'])) {
    $filename = $_POST['filename'] ?? '';
    $content = $_POST['content'] ?? '';
    
    if ($filename && in_array($filename, $template_files)) {
        $filepath = "{$template_dir}/{$filename}";
        file_put_contents($filepath, $content);
        $success = 'File saved successfully';
    }
}

// 处理文件上传
if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] !== UPLOAD_ERR_NO_FILE) {
    $upload_type = $_POST['upload_type'] ?? 'js';
    $allowed_types = [
        'js' => ['js'],
        'css' => ['css'],
        'images' => ['jpg', 'jpeg', 'png', 'gif', 'svg', 'ico', 'webp'],
        'upload' => ['jpg', 'jpeg', 'png', 'gif', 'svg', 'pdf', 'doc', 'docx', 'zip', 'rar']
    ];
    
    $file = $_FILES['upload_file'];
    
    // 检查上传错误
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $upload_errors = [
            UPLOAD_ERR_INI_SIZE => '文件大小超过服务器限制',
            UPLOAD_ERR_FORM_SIZE => '文件大小超过表单限制',
            UPLOAD_ERR_PARTIAL => '文件只有部分被上传',
            UPLOAD_ERR_NO_FILE => '没有文件被上传',
            UPLOAD_ERR_NO_TMP_DIR => '缺少临时文件夹',
            UPLOAD_ERR_CANT_WRITE => '文件写入失败',
            UPLOAD_ERR_EXTENSION => '文件上传被扩展阻止'
        ];
        $error = '上传错误：' . ($upload_errors[$file['error']] ?? '未知错误');
    } else {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (isset($allowed_types[$upload_type]) && in_array($ext, $allowed_types[$upload_type])) {
            $target_dir = "{$static_dir}/{$upload_type}";
            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    $error = '无法创建目录：' . $target_dir;
                }
            }
            
            if (!isset($error)) {
                $target_file = $target_dir . '/' . basename($file['name']);
                if (move_uploaded_file($file['tmp_name'], $target_file)) {
                    $success = '文件上传成功：' . basename($file['name']);
                } else {
                    $error = '无法移动文件到目标目录。请检查目录权限。';
                }
            }
        } else {
            $error = '不允许的文件类型：' . $ext . '。允许的类型：' . implode(', ', $allowed_types[$upload_type]);
        }
    }
}

// 读取当前文件内容
$file_content = '';
if ($current_file && in_array($current_file, $template_files)) {
    $filepath = "{$template_dir}/{$current_file}";
    if (file_exists($filepath)) {
        $file_content = file_get_contents($filepath);
    }
}

// 获取静态资源文件列表
function getStaticFiles($dir) {
    $files = [];
    if (is_dir($dir)) {
        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item != '.' && $item != '..') {
                $path = $dir . '/' . $item;
                if (is_file($path)) {
                    $files[] = [
                        'name' => $item,
                        'size' => filesize($path),
                        'modified' => filemtime($path)
                    ];
                }
            }
        }
    }
    return $files;
}
?>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">Template Files</div>
            <div class="list-group list-group-flush">
                <?php foreach ($template_files as $file): ?>
                <a href="website_pages.php?domain=<?php echo $domain; ?>&act=template&file=<?php echo $file; ?>" 
                   class="list-group-item list-group-item-action <?php echo $current_file == $file ? 'active' : ''; ?>">
                    <i class="fas fa-file-code"></i> <?php echo $file; ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">Quick Links</div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action" onclick="showStaticFiles(); return false;">
                    <i class="fas fa-folder"></i> Static Files
                </a>
                <a href="#" class="list-group-item list-group-item-action" onclick="showUploadModal(); return false;">
                    <i class="fas fa-upload"></i> Upload Resources
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="form-section">
            <?php if ($current_file): ?>
            <h4>Edit: <?php echo htmlspecialchars($current_file); ?></h4>
            
            <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="post" action="website_pages.php?domain=<?php echo $domain; ?>&act=template&file=<?php echo urlencode($current_file); ?>">
                <input type="hidden" name="save_file" value="1">
                <input type="hidden" name="filename" value="<?php echo htmlspecialchars($current_file); ?>">
                
                <div class="mb-3">
                    <div id="editor" style="height: 500px; border: 1px solid #ddd;"><?php echo htmlspecialchars($file_content); ?></div>
                    <textarea name="content" id="content" style="display: none;"><?php echo htmlspecialchars($file_content); ?></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary" onclick="saveContent()">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                
                <button type="button" class="btn btn-secondary" onclick="formatCode()">
                    <i class="fas fa-indent"></i> Format Code
                </button>
            </form>
            <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-code fa-3x text-muted mb-3"></i>
                <h5>Select a template file to edit</h5>
                <p class="text-muted">Choose a file from the list on the left to start editing</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Resource File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="website_pages.php?domain=<?php echo $domain; ?>&act=template" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="upload_type" class="form-label">File Type</label>
                        <select class="form-select" id="upload_type" name="upload_type">
                            <option value="js">JavaScript (js)</option>
                            <option value="css">CSS (css)</option>
                            <option value="images">Images (jpg, png, gif, svg, etc)</option>
                            <option value="upload">Other Files</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="upload_file" class="form-label">Select File</label>
                        <input type="file" class="form-control" id="upload_file" name="upload_file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Static Files Modal -->
<div class="modal fade" id="staticFilesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Static Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-js">JavaScript</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-css">CSS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-images">Images</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-upload">Uploads</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-js">
                        <?php $js_files = getStaticFiles("{$static_dir}/js"); ?>
                        <?php if (empty($js_files)): ?>
                        <p class="text-muted">No JavaScript files uploaded yet</p>
                        <?php else: ?>
                        <ul class="list-group">
                            <?php foreach ($js_files as $file): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?php echo $file['name']; ?></span>
                                <small class="text-muted"><?php echo round($file['size']/1024, 2); ?> KB</small>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    
                    <div class="tab-pane fade" id="tab-css">
                        <?php $css_files = getStaticFiles("{$static_dir}/css"); ?>
                        <?php if (empty($css_files)): ?>
                        <p class="text-muted">No CSS files uploaded yet</p>
                        <?php else: ?>
                        <ul class="list-group">
                            <?php foreach ($css_files as $file): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?php echo $file['name']; ?></span>
                                <small class="text-muted"><?php echo round($file['size']/1024, 2); ?> KB</small>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    
                    <div class="tab-pane fade" id="tab-images">
                        <?php $image_files = getStaticFiles("{$static_dir}/images"); ?>
                        <?php if (empty($image_files)): ?>
                        <p class="text-muted">No images uploaded yet</p>
                        <?php else: ?>
                        <div class="row">
                            <?php foreach ($image_files as $file): ?>
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <img src="/static/<?php echo $domain; ?>/images/<?php echo $file['name']; ?>" 
                                         class="card-img-top" style="height: 100px; object-fit: cover;">
                                    <div class="card-body p-2">
                                        <small class="text-truncate d-block"><?php echo $file['name']; ?></small>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="tab-pane fade" id="tab-upload">
                        <?php $upload_files = getStaticFiles("{$static_dir}/upload"); ?>
                        <?php if (empty($upload_files)): ?>
                        <p class="text-muted">No files uploaded yet</p>
                        <?php else: ?>
                        <ul class="list-group">
                            <?php foreach ($upload_files as $file): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?php echo $file['name']; ?></span>
                                <small class="text-muted"><?php echo round($file['size']/1024, 2); ?> KB</small>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include ACE Editor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.14/ace.js"></script>
<script>
// Initialize ACE Editor
var editor = ace.edit("editor");
editor.setTheme("ace/theme/monokai");
editor.session.setMode("ace/mode/php");
editor.setOptions({
    fontSize: "14px",
    showPrintMargin: false,
    wrap: true
});

function saveContent() {
    document.getElementById('content').value = editor.getValue();
}

function formatCode() {
    editor.session.setValue(editor.getValue());
}

function showUploadModal() {
    new bootstrap.Modal(document.getElementById('uploadModal')).show();
}

function showStaticFiles() {
    new bootstrap.Modal(document.getElementById('staticFilesModal')).show();
}
</script>