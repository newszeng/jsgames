<?php
// 这个文件被 website_pages.php 包含，$domain 变量已经可用

$router_file = "../router/{$domain}/router.json";
$router_data = [];

// 读取路由配置
if (file_exists($router_file)) {
    $router_data = json_decode(file_get_contents($router_file), true) ?: [];
}

// 默认路由结构
if (empty($router_data)) {
    $router_data = [
        'routes' => [
            '/' => ['type' => 'page', 'template' => 'home.php'],
            '/contact' => ['type' => 'static', 'template' => 'static.php', 'page' => 'contact'],
            '/privacy' => ['type' => 'static', 'template' => 'static.php', 'page' => 'privacy'],
            '/terms' => ['type' => 'static', 'template' => 'static.php', 'page' => 'terms']
        ],
        'redirects' => [],
        'default_lang' => 'en',
        'languages' => ['en']
    ];
}

// 处理添加重定向
if (isset($_POST['add_redirect'])) {
    $from = $_POST['from'] ?? '';
    $to = $_POST['to'] ?? '';
    $type = $_POST['redirect_type'] ?? '301';
    
    if ($from && $to && $from != $to) {
        $router_data['redirects'][$from] = [
            'to' => $to,
            'type' => $type
        ];
        
        file_put_contents($router_file, json_encode($router_data, JSON_PRETTY_PRINT));
        $success = '重定向规则添加成功';
    } else {
        $error = '无效的重定向配置';
    }
}

// 处理添加路由
if (isset($_POST['add_route'])) {
    $path = $_POST['route_path'] ?? '';
    $template = $_POST['route_template'] ?? '';
    $type = $_POST['route_type'] ?? '';
    $page = $_POST['route_page'] ?? '';
    $slug = $_POST['route_slug'] ?? '';
    
    if ($path && $template && $type) {
        $route_config = [
            'template' => $template,
            'type' => $type
        ];
        
        if ($page) $route_config['page'] = $page;
        if ($slug) $route_config['slug'] = $slug;
        
        $router_data['routes'][$path] = $route_config;
        
        file_put_contents($router_file, json_encode($router_data, JSON_PRETTY_PRINT));
        $success = '路由规则添加成功';
    } else {
        $error = '路由配置不完整';
    }
}

// 处理删除路由
if (isset($_GET['delete_route'])) {
    $path = base64_decode($_GET['delete_route']);
    unset($router_data['routes'][$path]);
    
    file_put_contents($router_file, json_encode($router_data, JSON_PRETTY_PRINT));
    header("Location: website_pages.php?domain={$domain}&act=router&route_deleted=1");
    exit();
}

// 处理编辑路由
if (isset($_POST['edit_route'])) {
    $old_path = $_POST['old_route_path'] ?? '';
    $new_path = $_POST['route_path'] ?? '';
    $template = $_POST['route_template'] ?? '';
    $type = $_POST['route_type'] ?? '';
    $page = $_POST['route_page'] ?? '';
    $slug = $_POST['route_slug'] ?? '';
    
    if ($old_path && $new_path && $template && $type) {
        // 删除旧路由
        unset($router_data['routes'][$old_path]);
        
        // 添加新路由
        $route_config = [
            'template' => $template,
            'type' => $type
        ];
        
        if ($page) $route_config['page'] = $page;
        if ($slug) $route_config['slug'] = $slug;
        
        $router_data['routes'][$new_path] = $route_config;
        
        file_put_contents($router_file, json_encode($router_data, JSON_PRETTY_PRINT));
        $success = '路由更新成功';
    } else {
        $error = '路由配置不完整';
    }
}

// 获取要编辑的路由
$edit_route = null;
if (isset($_GET['edit_route'])) {
    $edit_path = base64_decode($_GET['edit_route']);
    if (isset($router_data['routes'][$edit_path])) {
        $edit_route = [
            'path' => $edit_path,
            'config' => $router_data['routes'][$edit_path]
        ];
    }
}

// 获取要编辑的重定向
$edit_redirect = null;
if (isset($_GET['edit_redirect'])) {
    $edit_from = base64_decode($_GET['edit_redirect']);
    if (isset($router_data['redirects'][$edit_from])) {
        $edit_redirect = [
            'from' => $edit_from,
            'config' => $router_data['redirects'][$edit_from]
        ];
    }
}

// 处理删除重定向
if (isset($_GET['delete_redirect'])) {
    $from = base64_decode($_GET['delete_redirect']);
    unset($router_data['redirects'][$from]);
    
    file_put_contents($router_file, json_encode($router_data, JSON_PRETTY_PRINT));
    header("Location: website_pages.php?domain={$domain}&act=router&deleted=1");
    exit();
}

// 处理编辑重定向
if (isset($_POST['edit_redirect'])) {
    $old_from = $_POST['old_redirect_from'] ?? '';
    $new_from = $_POST['from'] ?? '';
    $to = $_POST['to'] ?? '';
    $type = $_POST['redirect_type'] ?? '301';
    
    if ($old_from && $new_from && $to && $new_from != $to) {
        // 删除旧重定向
        unset($router_data['redirects'][$old_from]);
        
        // 添加新重定向
        $router_data['redirects'][$new_from] = [
            'to' => $to,
            'type' => $type
        ];
        
        file_put_contents($router_file, json_encode($router_data, JSON_PRETTY_PRINT));
        $success = '重定向更新成功';
    } else {
        $error = '无效的重定向配置';
    }
}

// 处理单个语言重新生成混淆URL
if (isset($_POST['regenerate_single'])) {
    $lang = $_POST['lang'] ?? '';
    
    if ($lang && in_array($lang, $router_data['languages'] ?? [])) {
        // 生成4位混合大小写的随机后缀，确保不重复
        $max_attempts = 100;
        $attempt = 0;
        do {
            $random_hash = substr(md5($lang . microtime() . rand() . $attempt), 0, 4);
            $suffix = '';
            for ($i = 0; $i < strlen($random_hash); $i++) {
                $char = $random_hash[$i];
                if (ctype_alpha($char)) {
                    // 随机决定大小写
                    $suffix .= rand(0, 1) ? strtoupper($char) : strtolower($char);
                } else {
                    $suffix .= $char;
                }
            }
            $new_obfuscated_url = "/{$lang}{$suffix}";
            $attempt++;
            
            // 检查是否与现有的重定向目标重复
            $is_duplicate = false;
            foreach ($router_data['redirects'] as $redirect) {
                if ($redirect['to'] === $new_obfuscated_url) {
                    $is_duplicate = true;
                    break;
                }
            }
        } while ($is_duplicate && $attempt < $max_attempts);
        
        // 如果达到最大尝试次数仍有重复，使用时间戳确保唯一性
        if ($attempt >= $max_attempts) {
            $suffix = substr(md5($lang . microtime() . uniqid()), 0, 4);
            $new_obfuscated_url = "/{$lang}{$suffix}";
        }
        
        // 更新该语言的重定向
        $search_path = ($lang === $router_data['default_lang']) ? '/' : "/{$lang}";
        $router_data['redirects'][$search_path] = [
            'to' => $new_obfuscated_url,
            'type' => '301'
        ];
        
        file_put_contents($router_file, json_encode($router_data, JSON_PRETTY_PRINT));
        $success = "语言 {$lang} 的混淆URL已重新生成";
    } else {
        $error = '无效的语言代码';
    }
}

// 处理批量提交收录
if (isset($_POST['batch_submit_index'])) {
    $batch = [];
    $custom_urls = trim($_POST['custom_urls'] ?? '');
    
    if ($custom_urls) {
        // 如果填写了自定义URL列表，使用自定义列表
        $lines = array_filter(array_map('trim', explode("\n", $custom_urls)));
        foreach ($lines as $line) {
            // 验证URL格式
            if (filter_var($line, FILTER_VALIDATE_URL)) {
                $batch[] = $line;
            }
        }
    } else {
        // 否则收集所有重定向目标URL
        foreach ($router_data['redirects'] as $from => $redirect) {
            if (preg_match('/^\/[a-z]{2}[A-Za-z0-9]+$/', $redirect['to'])) {
                $batch[] = "https://{$domain}" . $redirect['to'];
                
                // 添加所有标签页面URL
                $pages_dir = "../pages/{$domain}";
                if (is_dir($pages_dir)) {
                    $dirs = scandir($pages_dir);
                    foreach ($dirs as $dir) {
                        if ($dir != '.' && $dir != '..' && is_dir("{$pages_dir}/{$dir}")) {
                            $batch[] = "https://{$domain}" . $redirect['to'] . "/" . $dir;
                        }
                    }
                }
            }
        }
    }
    
    if (!empty($batch)) {
        // 准备提交数据
        $postData = [
            'CampaignName' => 'AI Landing Pages Submit - ' . date('Y-m-d H:i:s'),
            'NumberOfDay' => 1,
            'Urls' => array_values($batch)
        ];
        
        // 发送请求到第三方API
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://app.1hping.com/external/api/campaign/create?culture=en-US',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                'ApiKey: gieterJFQFmGxsbC7J4nht7hbE0IFVgX/1jD7YiNBb0=',
                'Content-Type: application/json'
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        if ($curlError) {
            $error = "提交失败：" . $curlError;
        } elseif ($httpCode >= 200 && $httpCode < 300) {
            $source = $custom_urls ? "自定义" : "混淆";
            $success = "批量提交成功，共提交 " . count($batch) . " 个{$source}URL到收录系统";
        } else {
            $error = "提交失败，HTTP状态码：{$httpCode}，响应：" . substr($response, 0, 200);
        }
    } else {
        $error = $custom_urls ? "没有找到有效的URL格式" : "没有找到混淆URL可以提交";
    }
}

// 处理单个URL提交收录
if (isset($_POST['submit_single_index'])) {
    $url = $_POST['url'] ?? '';
    
    if ($url && filter_var($url, FILTER_VALIDATE_URL)) {
        // 准备提交数据
        $postData = [
            'CampaignName' => 'Single URL Submit - ' . date('Y-m-d H:i:s'),
            'NumberOfDay' => 1,
            'Urls' => [$url]
        ];
        
        // 发送请求到第三方API
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://app.1hping.com/external/api/campaign/create?culture=en-US',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                'ApiKey: gieterJFQFmGxsbC7J4nht7hbE0IFVgX/1jD7YiNBb0=',
                'Content-Type: application/json'
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        if ($curlError) {
            $error = "提交失败：" . $curlError;
        } elseif ($httpCode >= 200 && $httpCode < 300) {
            $success = "单个URL提交成功：{$url}";
        } else {
            $error = "提交失败，HTTP状态码：{$httpCode}，响应：" . substr($response, 0, 200);
        }
    } else {
        $error = "无效的URL";
    }
}

// 处理生成混淆重定向
if (isset($_POST['generate_obfuscated'])) {
    $obfuscated_redirects = [];
    
    // 先清理旧的混淆重定向（保留原始语言路径的重定向）
    foreach ($router_data['redirects'] as $from => $redirect) {
        $to = $redirect['to'];
        // 如果目标是混淆URL格式，则删除这个重定向
        if (preg_match('/^\/[a-z]{2}[A-Za-z0-9]+$/', $to)) {
            unset($router_data['redirects'][$from]);
        }
    }
    
    // 为每个语言生成混淆重定向
    foreach ($router_data['languages'] as $lang) {
        // 生成4位混合大小写的随机后缀，确保不重复
        $max_attempts = 100;
        $attempt = 0;
        do {
            $random_hash = substr(md5($lang . microtime() . rand() . $attempt), 0, 4);
            $suffix = '';
            for ($i = 0; $i < strlen($random_hash); $i++) {
                $char = $random_hash[$i];
                if (ctype_alpha($char)) {
                    // 随机决定大小写
                    $suffix .= rand(0, 1) ? strtoupper($char) : strtolower($char);
                } else {
                    $suffix .= $char;
                }
            }
            $new_obfuscated_url = "/{$lang}{$suffix}";
            $attempt++;
            
            // 检查是否与现有的重定向目标重复
            $is_duplicate = false;
            foreach ($router_data['redirects'] as $redirect) {
                if ($redirect['to'] === $new_obfuscated_url) {
                    $is_duplicate = true;
                    break;
                }
            }
        } while ($is_duplicate && $attempt < $max_attempts);
        
        // 如果达到最大尝试次数仍有重复，使用时间戳确保唯一性
        if ($attempt >= $max_attempts) {
            $suffix = substr(md5($lang . microtime() . uniqid()), 0, 4);
        }
        
        // 添加原始语言路径的重定向
        if ($lang === $router_data['default_lang']) {
            // 默认语言重定向到根路径
            $router_data['redirects']['/'] = [
                'to' => $new_obfuscated_url,
                'type' => '301'
            ];
        } else {
            // 其他语言重定向到语言路径
            $router_data['redirects']["/{$lang}"] = [
                'to' => $new_obfuscated_url,
                'type' => '301'
            ];
        }
    }
    
    file_put_contents($router_file, json_encode($router_data, JSON_PRETTY_PRINT));
    $success = '混淆重定向生成成功';
}

// 处理更新语言设置
if (isset($_POST['update_languages'])) {
    $router_data['default_lang'] = $_POST['default_lang'] ?? 'en';
    $router_data['languages'] = $_POST['languages'] ?? ['en'];
    
    file_put_contents($router_file, json_encode($router_data, JSON_PRETTY_PRINT));
    $success = '语言设置更新成功';
}

// 获取可用语言
$available_languages = ['en'];
$i18n_dir = "../i18n/{$domain}";
if (is_dir($i18n_dir)) {
    $files = scandir($i18n_dir);
    foreach ($files as $file) {
        if (preg_match('/^([a-z]{2})\.json$/', $file, $matches)) {
            $available_languages[] = $matches[1];
        }
    }
    $available_languages = array_unique($available_languages);
}
?>

<div class="row">
    <div class="col-md-8">
        <div class="form-section">
            <h4>路由器配置</h4>
            
            <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-success">重定向删除成功</div>
            <?php endif; ?>
            
            <?php if (isset($_GET['route_deleted'])): ?>
            <div class="alert alert-success">路由删除成功</div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <h5 class="mb-3">语言设置</h5>
            
            <form method="post">
                <input type="hidden" name="update_languages" value="1">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="default_lang" class="form-label">默认语言</label>
                            <select class="form-select" id="default_lang" name="default_lang">
                                <?php foreach ($available_languages as $lang): ?>
                                <option value="<?php echo $lang; ?>" <?php echo $router_data['default_lang'] == $lang ? 'selected' : ''; ?>>
                                    <?php echo strtoupper($lang); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">启用语言</label>
                            <div>
                                <?php foreach ($available_languages as $lang): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" 
                                           name="languages[]" value="<?php echo $lang; ?>" 
                                           id="lang_<?php echo $lang; ?>"
                                           <?php echo in_array($lang, $router_data['languages'] ?? []) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="lang_<?php echo $lang; ?>">
                                        <?php echo strtoupper($lang); ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> 更新语言设置
                </button>
            </form>
            
            <hr class="my-4">
            
            <h5 class="mb-3">混淆URL保护</h5>
            
            <div class="alert alert-warning">
                <h6><i class="fas fa-shield-alt"></i> 防DMCA保护</h6>
                <p class="small mb-2">生成混淆URL以进行DMCA保护。该功能将：</p>
                <ul class="small mb-2">
                    <li>从原始URL（/、/de、/fr等）创建重定向到混淆版本</li>
                    <li>混淆URL使用格式：<code>/{语言}{随机}</code>（例如：/enXz1, /deA1z, /frBc2d）</li>
                    <li>前2个字母自动识别语言，随机部分为大小写混合的字母数字</li>
                    <li><strong>智能识别：</strong>任何符合格式的URL都会被识别为对应语言的首页</li>
                </ul>
                <form method="post" class="d-inline">
                    <input type="hidden" name="generate_obfuscated" value="1">
                    <button type="submit" class="btn btn-warning btn-sm" 
                            onclick="return confirm('这将生成新的混淆URL，可能会覆盖现有重定向。继续？')">
                        <i class="fas fa-random"></i> 生成混淆URL
                    </button>
                </form>
            </div>
            
            <hr class="my-3">
            
            <h5 class="mb-3">批量提交收录</h5>
            
            <form method="post">
                <input type="hidden" name="batch_submit_index" value="1">
                <div class="mb-3">
                    <label for="custom_urls" class="form-label">自定义URL列表（可选）</label>
                    <textarea class="form-control" id="custom_urls" name="custom_urls" rows="5" 
                              placeholder="每行一个URL，例如：&#10;https://ytdownloader.io/en0881&#10;https://ytdownloader.io/deA42d&#10;留空则提交所有混淆URL"></textarea>
                    <div class="form-text">如果填写了URL列表，将提交这些URL；如果留空，将自动提交所有混淆URL。</div>
                </div>
                <button type="submit" class="btn btn-success" 
                        onclick="return confirm('确定批量提交到收录系统？')">
                    <i class="fas fa-upload"></i> 批量提交收录
                </button>
            </form>
            
            <hr class="my-3">
            
            <h5 class="mb-3">URL重定向</h5>
            
            <?php if (empty($router_data['redirects'])): ?>
            <div class="alert alert-info">尚未配置重定向规则。</div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>来源URL</th>
                            <th>目标URL</th>
                            <th>类型</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($router_data['redirects'] as $from => $redirect): ?>
                        <tr>
                            <td><code><?php echo htmlspecialchars($from); ?></code></td>
                            <td><code><?php echo htmlspecialchars($redirect['to']); ?></code></td>
                            <td>
                                <span class="badge bg-<?php echo $redirect['type'] == '301' ? 'success' : 'warning'; ?>">
                                    <?php echo $redirect['type']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="website_pages.php?domain=<?php echo $domain; ?>&act=router&edit_redirect=<?php echo base64_encode($from); ?>" 
                                   class="btn btn-sm btn-outline-primary me-1" title="编辑">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <?php 
                                // 检查是否是语言重定向（/ 或 /语言代码 -> /语言代码+随机字符）
                                $is_language_redirect = false;
                                $lang_code = '';
                                
                                if ($from === '/') {
                                    // 默认语言
                                    $is_language_redirect = true;
                                    $lang_code = $router_data['default_lang'];
                                } elseif (preg_match('/^\/([a-z]{2})$/', $from, $matches)) {
                                    // 其他语言
                                    $lang_code = $matches[1];
                                    if (in_array($lang_code, $router_data['languages'])) {
                                        $is_language_redirect = true;
                                    }
                                }
                                
                                // 检查目标URL是否是混淆格式
                                if ($is_language_redirect && preg_match('/^\/[a-z]{2}[A-Za-z0-9]+$/', $redirect['to'])) {
                                ?>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="regenerate_single" value="1">
                                    <input type="hidden" name="lang" value="<?php echo $lang_code; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-warning me-1" title="重新生成混淆URL"
                                            onclick="return confirm('确定重新生成 <?php echo $lang_code; ?> 的混淆URL？这将改变当前的重定向目标。')">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>
                                
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="submit_single_index" value="1">
                                    <input type="hidden" name="url" value="https://<?php echo $domain . $redirect['to']; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-success me-1" title="提交单个收录"
                                            onclick="return confirm('确定提交 https://<?php echo $domain . $redirect['to']; ?> 到收录系统？')">
                                        <i class="fas fa-upload"></i>
                                    </button>
                                </form>
                                <?php } ?>
                                
                                <button onclick="confirmDelete('确定删除此重定向？', function() { 
                                    window.location.href = 'website_pages.php?domain=<?php echo $domain; ?>&act=router&delete_redirect=<?php echo base64_encode($from); ?>'; 
                                })" class="btn btn-sm btn-outline-danger" title="删除">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
            
            <h6 class="mt-4 mb-3"><?php echo $edit_redirect ? '编辑重定向' : '添加新重定向'; ?></h6>
            
            <?php if ($edit_redirect): ?>
            <div class="alert alert-info">
                正在编辑重定向: <code><?php echo htmlspecialchars($edit_redirect['from']); ?></code>
                <a href="website_pages.php?domain=<?php echo $domain; ?>&act=router" class="btn btn-sm btn-outline-secondary ms-2">
                    <i class="fas fa-times"></i> 取消编辑
                </a>
            </div>
            <?php endif; ?>
            
            <form method="post">
                <input type="hidden" name="<?php echo $edit_redirect ? 'edit_redirect' : 'add_redirect'; ?>" value="1">
                <?php if ($edit_redirect): ?>
                <input type="hidden" name="old_redirect_from" value="<?php echo htmlspecialchars($edit_redirect['from']); ?>">
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="from" class="form-label">来源URL</label>
                            <input type="text" class="form-control" id="from" name="from" 
                                   placeholder="/旧页面" value="<?php echo $edit_redirect ? htmlspecialchars($edit_redirect['from']) : ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="to" class="form-label">目标URL</label>
                            <input type="text" class="form-control" id="to" name="to" 
                                   placeholder="/新页面" value="<?php echo $edit_redirect ? htmlspecialchars($edit_redirect['config']['to']) : ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="redirect_type" class="form-label">类型</label>
                            <select class="form-select" id="redirect_type" name="redirect_type">
                                <option value="301" <?php echo ($edit_redirect && $edit_redirect['config']['type'] === '301') ? 'selected' : ''; ?>>301</option>
                                <option value="302" <?php echo ($edit_redirect && $edit_redirect['config']['type'] === '302') ? 'selected' : ''; ?>>302</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-<?php echo $edit_redirect ? 'success' : 'primary'; ?>">
                    <i class="fas fa-<?php echo $edit_redirect ? 'save' : 'plus'; ?>"></i> <?php echo $edit_redirect ? '更新重定向' : '添加重定向'; ?>
                </button>
                <?php if ($edit_redirect): ?>
                <a href="website_pages.php?domain=<?php echo $domain; ?>&act=router" class="btn btn-secondary ms-2">
                    <i class="fas fa-times"></i> 取消
                </a>
                <?php endif; ?>
            </form>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-route"></i> 路由管理
            </div>
            <div class="card-body">
                <h6 class="mb-3">现有系统路由(不用操作)</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>路径</th>
                                <th>类型</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($router_data['routes'] as $path => $route): ?>
                            <tr>
                                <td><code><?php echo htmlspecialchars($path); ?></code></td>
                                <td>
                                    <span class="badge bg-primary"><?php echo $route['type']; ?></span>
                                </td>
                                <td>
                                    <a href="website_pages.php?domain=<?php echo $domain; ?>&act=router&edit_route=<?php echo base64_encode($path); ?>" 
                                       class="btn btn-sm btn-outline-primary me-1" title="编辑">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($path !== '/'): ?>
                                    <button onclick="confirmDelete('确定删除路由 <?php echo htmlspecialchars($path); ?>？', function() { 
                                        window.location.href = 'website_pages.php?domain=<?php echo $domain; ?>&act=router&delete_route=<?php echo base64_encode($path); ?>'; 
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
                
                <h6 class="mt-4 mb-3"><?php echo $edit_route ? '编辑路由' : '添加新路由'; ?></h6>
                
                <?php if ($edit_route): ?>
                <div class="alert alert-info">
                    正在编辑路由: <code><?php echo htmlspecialchars($edit_route['path']); ?></code>
                    <a href="website_pages.php?domain=<?php echo $domain; ?>&act=router" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-times"></i> 取消编辑
                    </a>
                </div>
                <?php endif; ?>
                
                <form method="post">
                    <input type="hidden" name="<?php echo $edit_route ? 'edit_route' : 'add_route'; ?>" value="1">
                    <?php if ($edit_route): ?>
                    <input type="hidden" name="old_route_path" value="<?php echo htmlspecialchars($edit_route['path']); ?>">
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="route_path" class="form-label">路径</label>
                        <input type="text" class="form-control form-control-sm" id="route_path" name="route_path" 
                               placeholder="/新路径" value="<?php echo $edit_route ? htmlspecialchars($edit_route['path']) : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="route_type" class="form-label">类型</label>
                        <select class="form-select form-select-sm" id="route_type" name="route_type" required onchange="toggleRouteFields()">
                            <option value="">选择类型</option>
                            <option value="home" <?php echo ($edit_route && $edit_route['config']['type'] === 'home') ? 'selected' : ''; ?>>首页</option>
                            <option value="static" <?php echo ($edit_route && $edit_route['config']['type'] === 'static') ? 'selected' : ''; ?>>静态页</option>
                            <option value="page" <?php echo ($edit_route && $edit_route['config']['type'] === 'page') ? 'selected' : ''; ?>>页面</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="route_template" class="form-label">模板</label>
                        <select class="form-select form-select-sm" id="route_template" name="route_template" required>
                            <option value="">选择模板</option>
                            <option value="home.php" <?php echo ($edit_route && $edit_route['config']['template'] === 'home.php') ? 'selected' : ''; ?>>home.php</option>
                            <option value="static.php" <?php echo ($edit_route && $edit_route['config']['template'] === 'static.php') ? 'selected' : ''; ?>>static.php</option>
                            <option value="page.php" <?php echo ($edit_route && $edit_route['config']['template'] === 'page.php') ? 'selected' : ''; ?>>page.php</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="page_field" style="display:<?php echo ($edit_route && $edit_route['config']['type'] === 'static') ? 'block' : 'none'; ?>;">
                        <label for="route_page" class="form-label">页面名称</label>
                        <input type="text" class="form-control form-control-sm" id="route_page" name="route_page" 
                               placeholder="contact, about等" value="<?php echo ($edit_route && isset($edit_route['config']['page'])) ? htmlspecialchars($edit_route['config']['page']) : ''; ?>">
                    </div>
                    
                    <div class="mb-3" id="slug_field" style="display:<?php echo ($edit_route && $edit_route['config']['type'] === 'page') ? 'block' : 'none'; ?>;">
                        <label for="route_slug" class="form-label">Slug</label>
                        <input type="text" class="form-control form-control-sm" id="route_slug" name="route_slug" 
                               placeholder="页面slug" value="<?php echo ($edit_route && isset($edit_route['config']['slug'])) ? htmlspecialchars($edit_route['config']['slug']) : ''; ?>">
                    </div>
                    
                    <button type="submit" class="btn btn-<?php echo $edit_route ? 'success' : 'primary'; ?> btn-sm">
                        <i class="fas fa-<?php echo $edit_route ? 'save' : 'plus'; ?>"></i> <?php echo $edit_route ? '更新路由' : '添加路由'; ?>
                    </button>
                    <?php if ($edit_route): ?>
                    <a href="website_pages.php?domain=<?php echo $domain; ?>&act=router" class="btn btn-secondary btn-sm ms-2">
                        <i class="fas fa-times"></i> 取消
                    </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-question-circle"></i> 重定向类型说明
            </div>
            <div class="card-body">
                <p class="small mb-2"><strong>301（永久）：</strong> 用于页面已永久移动的情况。搜索引擎将更新其索引。</p>
                <p class="small mb-0"><strong>302（临时）：</strong> 用于临时重定向。搜索引擎将在其索引中保留原始URL。</p>
            </div>
        </div>
    </div>
</div>

<script>
function toggleRouteFields() {
    const typeSelect = document.getElementById('route_type');
    const templateSelect = document.getElementById('route_template');
    const pageField = document.getElementById('page_field');
    const slugField = document.getElementById('slug_field');
    
    const selectedType = typeSelect.value;
    
    // 重置模板选项
    templateSelect.innerHTML = '<option value="">选择模板</option>';
    
    // 隐藏所有字段
    pageField.style.display = 'none';
    slugField.style.display = 'none';
    
    // 根据类型显示相应的模板选项和字段
    switch(selectedType) {
        case 'home':
            templateSelect.innerHTML += '<option value="home.php">home.php</option>';
            break;
        case 'static':
            templateSelect.innerHTML += '<option value="static.php">static.php</option>';
            pageField.style.display = 'block';
            break;
        case 'page':
            templateSelect.innerHTML += '<option value="page.php">page.php</option>';
            slugField.style.display = 'block';
            break;
        default:
            templateSelect.innerHTML += '<option value="home.php">home.php</option>';
            templateSelect.innerHTML += '<option value="static.php">static.php</option>';
            templateSelect.innerHTML += '<option value="page.php">page.php</option>';
            break;
    }
}

// 自动根据模板选择更新类型
document.getElementById('route_template').addEventListener('change', function() {
    const template = this.value;
    const typeSelect = document.getElementById('route_type');
    
    if (template === 'home.php' && !typeSelect.value) {
        typeSelect.value = 'home';
        toggleRouteFields();
    } else if (template === 'static.php' && !typeSelect.value) {
        typeSelect.value = 'static';
        toggleRouteFields();
    } else if (template === 'page.php' && !typeSelect.value) {
        typeSelect.value = 'page';
        toggleRouteFields();
    }
});
</script>