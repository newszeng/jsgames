<?php
require_once 'header.php';

$domain = $_GET['domain'] ?? '';
if (empty($domain)) {
    header('Location: index.php');
    exit();
}

// 获取查看日期和分页参数
$view_date = $_GET['date'] ?? date('Y-m-d');
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 100;

// 获取流量统计数据
function getTrafficData($domain, $view_date) {
    $analytics_dir = __DIR__ . "/../analytics/{$domain}";
    
    if (!is_dir($analytics_dir)) {
        return [
            'total_visits' => 0,
            'unique_visitors' => 0,
            'page_views' => 0,
            'avg_session_duration' => 0,
            'bounce_rate' => 0,
            'daily_stats' => [],
            'top_pages' => [],
            'referrer_stats' => [],
            'device_stats' => [],
            'country_stats' => []
        ];
    }
    
    $view_timestamp = strtotime($view_date);
    $year_month = date('Ym', $view_timestamp);
    $day_file = date('Ymd', $view_timestamp);
    
    $total_visits = 0;
    $unique_visitors = [];
    $page_views = 0;
    $session_durations = [];
    $daily_stats = [];
    $top_pages = [];
    $referrer_stats = [];
    $device_stats = [];
    $country_stats = [];
    
    // 获取最近7天的数据用于趋势图
    for ($i = 6; $i >= 0; $i--) {
        $date = strtotime("-{$i} days", $view_timestamp);
        $check_year_month = date('Ym', $date);
        $check_day_file = date('Ymd', $date);
        $day_key = date('Y-m-d', $date);
        
        $daily_stats[$day_key] = [
            'visits' => 0,
            'unique_visitors' => [],
            'page_views' => 0
        ];
        
        $log_file = $analytics_dir . '/' . $check_year_month . '/' . $check_day_file . '.log';
        if (file_exists($log_file)) {
            $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $data = explode('|', $line);
                if (count($data) < 20) continue;
                
                $visitor_id = $data[1];
                $daily_stats[$day_key]['visits']++;
                $daily_stats[$day_key]['unique_visitors'][$visitor_id] = true;
                $daily_stats[$day_key]['page_views']++;
            }
        }
    }
    
    // 只处理当天的详细数据
    $log_file = $analytics_dir . '/' . $year_month . '/' . $day_file . '.log';
    $session_max_durations = [];
    
    if (file_exists($log_file)) {
        $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $data = explode('|', $line);
            if (count($data) < 20) continue;
            
            $visitor_id = $data[1];
            $session_id = $data[2];
            $country = $data[4];
            $url = $data[13];
            $referrer = $data[15];
            $device_type = $data[9];
            $duration = intval($data[18]);
            
            $total_visits++;
            $page_views++;
            $unique_visitors[$visitor_id] = true;
            
            // 页面统计
            $page_path = parse_url($url, PHP_URL_PATH) ?: '/';
            if (!isset($top_pages[$page_path])) {
                $top_pages[$page_path] = 0;
            }
            $top_pages[$page_path]++;
            
            // 来源统计
            $referrer_domain = 'direct';
            if (!empty($referrer) && $referrer !== 'direct') {
                $parsed_referrer = parse_url($referrer);
                $referrer_domain = $parsed_referrer['host'] ?? 'unknown';
            }
            if (!isset($referrer_stats[$referrer_domain])) {
                $referrer_stats[$referrer_domain] = 0;
            }
            $referrer_stats[$referrer_domain]++;
            
            // 设备统计
            if (!isset($device_stats[$device_type])) {
                $device_stats[$device_type] = 0;
            }
            $device_stats[$device_type]++;
            
            // 国家统计
            if (!isset($country_stats[$country])) {
                $country_stats[$country] = 0;
            }
            $country_stats[$country]++;
            
            // 收集每个session的最大duration
            if ($duration > 0) {
                if (!isset($session_max_durations[$session_id]) || $duration > $session_max_durations[$session_id]) {
                    $session_max_durations[$session_id] = $duration;
                }
            }
        }
    }
    
    // 读取会话文件获取更准确的会话时长
    $sessions_dir = $analytics_dir . '/' . $year_month . '/sessions';
    if (is_dir($sessions_dir)) {
        $session_files = glob($sessions_dir . '/*.json');
        foreach ($session_files as $session_file) {
            $session_data = json_decode(file_get_contents($session_file), true);
            if ($session_data) {
                // 检查会话是否属于当天（使用start_time更准确）
                $session_start_date = isset($session_data['start_time']) ? 
                    date('Y-m-d', strtotime($session_data['start_time'])) : 
                    date('Y-m-d', strtotime($session_data['timestamp']));
                    
                if ($session_start_date == $view_date) {
                    // 优先使用会话文件中的duration（这是最后更新的时长）
                    if (isset($session_data['duration']) && $session_data['duration'] > 0) {
                        $session_durations[] = $session_data['duration'];
                    } else {
                        // 如果duration为0，计算start_time和last_update的差值
                        if (isset($session_data['start_time']) && isset($session_data['last_update'])) {
                            $start_time = strtotime($session_data['start_time']);
                            $last_update = strtotime($session_data['last_update']);
                            $calculated_duration = $last_update - $start_time;
                            // 合理的会话时长：3秒到1小时
                            if ($calculated_duration >= 3 && $calculated_duration <= 3600) {
                                $session_durations[] = $calculated_duration;
                            }
                        }
                    }
                }
            }
        }
    }
    
    // 从session文件中计算真实的会话时长（用于统计平均时长）
    $session_calculated_durations = [];
    $sessions_dir = $analytics_dir . '/' . $year_month . '/sessions';
    
    if (is_dir($sessions_dir)) {
        $session_files = glob($sessions_dir . '/*.json');
        foreach ($session_files as $session_file) {
            $session_data = json_decode(file_get_contents($session_file), true);
            if ($session_data && isset($session_data['session_id'])) {
                $session_id = $session_data['session_id'];
                
                // 检查是否属于当天
                $session_date = date('Y-m-d', strtotime($session_data['timestamp']));
                if ($session_date == $view_date) {
                    // 计算 last_update - start_time
                    if (isset($session_data['start_time']) && isset($session_data['last_update'])) {
                        $start_time = strtotime($session_data['start_time']);
                        $last_update = strtotime($session_data['last_update']);
                        $calculated_duration = $last_update - $start_time;
                        
                        // 合理的时长范围：1秒到2小时
                        if ($calculated_duration >= 1 && $calculated_duration <= 7200) {
                            $session_calculated_durations[$session_id] = $calculated_duration;
                        }
                    }
                    // 如果没有start_time和last_update，使用session文件中的duration字段
                    elseif (isset($session_data['duration']) && $session_data['duration'] > 0) {
                        $session_calculated_durations[$session_id] = $session_data['duration'];
                    }
                }
            }
        }
    }
    
    // 优先使用计算的会话时长，备选使用日志中的最大时长
    foreach ($session_calculated_durations as $session_id => $duration) {
        if ($duration >= 3 && $duration <= 7200) { // 合理时长：3秒到2小时
            $session_durations[] = $duration;
        }
    }
    
    // 对于没有计算时长的会话，使用日志中的最大时长
    foreach ($session_max_durations as $session_id => $duration) {
        if (!isset($session_calculated_durations[$session_id]) && $duration >= 3 && $duration <= 3600) {
            $session_durations[] = $duration;
        }
    }
    
    // 转换每日统计格式
    foreach ($daily_stats as $day => &$stats) {
        $stats['unique_visitors'] = count($stats['unique_visitors']);
    }
    
    // 排序统计数据
    arsort($top_pages);
    arsort($referrer_stats);
    arsort($device_stats);
    arsort($country_stats);
    
    return [
        'total_visits' => $total_visits,
        'unique_visitors' => count($unique_visitors),
        'page_views' => $page_views,
        'avg_session_duration' => !empty($session_durations) ? round(array_sum($session_durations) / count($session_durations)) : 0,
        'bounce_rate' => !empty($session_durations) ? round((count(array_filter($session_durations, function($d) { return $d <= 10; })) / count($session_durations)) * 100, 1) : 0,
        'daily_stats' => $daily_stats,
        'top_pages' => array_slice($top_pages, 0, 10, true),
        'referrer_stats' => array_slice($referrer_stats, 0, 10, true),
        'device_stats' => $device_stats,
        'country_stats' => array_slice($country_stats, 0, 10, true)
    ];
}

// 获取访问日志
function getAccessLogs($domain, $view_date, $page, $per_page) {
    $analytics_dir = __DIR__ . "/../analytics/{$domain}";
    $view_timestamp = strtotime($view_date);
    $year_month = date('Ym', $view_timestamp);
    $day_file = date('Ymd', $view_timestamp);
    
    $log_file = $analytics_dir . '/' . $year_month . '/' . $day_file . '.log';
    
    if (!file_exists($log_file)) {
        return [
            'logs' => [],
            'total' => 0,
            'pages' => 0,
            'current_page' => $page
        ];
    }
    
    $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    // 从session文件中计算真实的会话时长
    $session_calculated_durations = [];
    $sessions_dir = $analytics_dir . '/' . $year_month . '/sessions';
    
    if (is_dir($sessions_dir)) {
        $session_files = glob($sessions_dir . '/*.json');
        foreach ($session_files as $session_file) {
            $session_data = json_decode(file_get_contents($session_file), true);
            if ($session_data && isset($session_data['session_id'])) {
                $session_id = $session_data['session_id'];
                
                // 检查是否属于当天
                $session_date = date('Y-m-d', strtotime($session_data['timestamp']));
                if ($session_date == $view_date) {
                    // 计算 last_update - start_time
                    if (isset($session_data['start_time']) && isset($session_data['last_update'])) {
                        $start_time = strtotime($session_data['start_time']);
                        $last_update = strtotime($session_data['last_update']);
                        $calculated_duration = $last_update - $start_time;
                        
                        // 合理的时长范围：1秒到2小时
                        if ($calculated_duration >= 1 && $calculated_duration <= 7200) {
                            $session_calculated_durations[$session_id] = $calculated_duration;
                        }
                    }
                    // 如果没有start_time和last_update，使用session文件中的duration字段
                    elseif (isset($session_data['duration']) && $session_data['duration'] > 0) {
                        $session_calculated_durations[$session_id] = $session_data['duration'];
                    }
                }
            }
        }
    }
    
    // 作为备选方案，仍然记录日志中的最大时长
    $session_max_durations = [];
    foreach ($lines as $line) {
        $data = explode('|', $line);
        if (count($data) < 20) continue;
        
        $session_id = $data[2];
        $duration = intval($data[18]);
        
        if ($duration > 0) {
            if (!isset($session_max_durations[$session_id]) || $duration > $session_max_durations[$session_id]) {
                $session_max_durations[$session_id] = $duration;
            }
        }
    }
    
    // 按时间倒序排序（最新的在前面）
    usort($lines, function($a, $b) {
        $time_a = explode('|', $a)[0];
        $time_b = explode('|', $b)[0];
        return strtotime($time_b) - strtotime($time_a);
    });
    
    $total = count($lines);
    $pages = ceil($total / $per_page);
    
    // 计算分页偏移
    $offset = ($page - 1) * $per_page;
    $page_lines = array_slice($lines, $offset, $per_page);
    
    $logs = [];
    foreach ($page_lines as $line) {
        $data = explode('|', $line);
        if (count($data) < 20) continue;
        
        $session_id = $data[2];
        $current_duration = intval($data[18]);
        
        // 时长显示优先级：
        // 1. 当前记录的duration（如果>0）
        // 2. session文件计算的时长（last_update - start_time）
        // 3. 日志中该session的最大duration
        $display_duration = $current_duration;
        $is_heartbeat = $current_duration > 0;
        $duration_source = 'current';
        
        if ($current_duration == 0) {
            if (isset($session_calculated_durations[$session_id])) {
                $display_duration = $session_calculated_durations[$session_id];
                $duration_source = 'calculated';
            } elseif (isset($session_max_durations[$session_id])) {
                $display_duration = $session_max_durations[$session_id];
                $duration_source = 'max';
            }
        }
        
        $logs[] = [
            'timestamp' => $data[0],
            'visitor_id' => $data[1],
            'session_id' => $session_id,
            'ip' => $data[3],
            'country' => $data[4],
            'country_code' => $data[5],
            'region' => $data[6],
            'city' => $data[7],
            'isp' => $data[8],
            'device_type' => $data[9],
            'user_agent' => $data[10],
            'screen_resolution' => $data[11],
            'viewport' => $data[12],
            'url' => $data[13],
            'title' => $data[14],
            'referrer' => $data[15],
            'language' => $data[16],
            'browser_language' => $data[17],
            'duration' => $display_duration,
            'original_duration' => $current_duration,
            'session_page_count' => intval($data[19]),
            'is_heartbeat' => $is_heartbeat,
            'duration_source' => $duration_source
        ];
    }
    
    return [
        'logs' => $logs,
        'total' => $total,
        'pages' => $pages,
        'current_page' => $page
    ];
}

$traffic_data = getTrafficData($domain, $view_date);
$log_data = getAccessLogs($domain, $view_date, $page, $per_page);
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">管理首页</a></li>
        <li class="breadcrumb-item active">流量统计 - <?php echo htmlspecialchars($domain); ?> (<?php echo $view_date; ?>)</li>
    </ol>
</nav>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-chart-line"></i> 流量统计 - <?php echo htmlspecialchars($domain); ?> 
                    <small class="text-muted">(<?php echo $view_date; ?>)</small>
                </h5>
                <form method="get" class="row g-3">
                    <input type="hidden" name="domain" value="<?php echo htmlspecialchars($domain); ?>">
                    <div class="col-md-6">
                        <label for="date" class="form-label">查看日期</label>
                        <input type="date" class="form-control" id="date" name="date" 
                               value="<?php echo htmlspecialchars($view_date); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> 查看
                            </button>
                            <a href="traffic.php?domain=<?php echo urlencode($domain); ?>" class="btn btn-secondary">
                                <i class="fas fa-calendar-day"></i> 今天
                            </a>
                            <a href="traffic.php?domain=<?php echo urlencode($domain); ?>&date=<?php echo date('Y-m-d', strtotime('-1 day')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-chevron-left"></i> 昨天
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 概览统计 -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary"><?php echo number_format($traffic_data['total_visits']); ?></h3>
                <p class="text-muted mb-0">总访问量</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info"><?php echo number_format($traffic_data['unique_visitors']); ?></h3>
                <p class="text-muted mb-0">独立访客</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success"><?php echo number_format($traffic_data['page_views']); ?></h3>
                <p class="text-muted mb-0">页面浏览量</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning"><?php echo $traffic_data['avg_session_duration']; ?>s</h3>
                <p class="text-muted mb-0">平均会话时长</p>
                <?php if ($traffic_data['avg_session_duration'] == 0): ?>
                <small class="text-danger">
                    调试：检查 analytics/<?php echo $domain; ?>/<?php echo date('Ym', strtotime($view_date)); ?>/sessions/ 目录
                </small>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-danger"><?php echo $traffic_data['bounce_rate']; ?>%</h3>
                <p class="text-muted mb-0">跳出率</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-secondary"><?php echo $traffic_data['unique_visitors'] > 0 ? round($traffic_data['page_views'] / $traffic_data['unique_visitors'], 1) : 0; ?></h3>
                <p class="text-muted mb-0">页面/会话</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- 每日趋势图 -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-area"></i> 最近7天访问趋势 (包含 <?php echo $view_date; ?>)
            </div>
            <div class="card-body">
                <canvas id="dailyChart" height="100"></canvas>
            </div>
        </div>
    </div>
    
    <!-- 热门页面 -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-alt"></i> 热门页面
            </div>
            <div class="card-body">
                <?php if (empty($traffic_data['top_pages'])): ?>
                <p class="text-muted text-center">暂无数据</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>页面路径</th>
                                <th>访问次数</th>
                                <th>占比</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($traffic_data['top_pages'] as $page => $count): ?>
                            <tr>
                                <td><code><?php echo htmlspecialchars($page); ?></code></td>
                                <td><?php echo number_format($count); ?></td>
                                <td><?php echo $traffic_data['page_views'] > 0 ? round(($count / $traffic_data['page_views']) * 100, 1) : 0; ?>%</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- 来源统计 -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-external-link-alt"></i> 流量来源
            </div>
            <div class="card-body">
                <?php if (empty($traffic_data['referrer_stats'])): ?>
                <p class="text-muted text-center">暂无数据</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>来源</th>
                                <th>访问次数</th>
                                <th>占比</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($traffic_data['referrer_stats'] as $referrer => $count): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($referrer); ?></td>
                                <td><?php echo number_format($count); ?></td>
                                <td><?php echo $traffic_data['total_visits'] > 0 ? round(($count / $traffic_data['total_visits']) * 100, 1) : 0; ?>%</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- 设备统计 -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-mobile-alt"></i> 设备类型
            </div>
            <div class="card-body">
                <?php if (empty($traffic_data['device_stats'])): ?>
                <p class="text-muted text-center">暂无数据</p>
                <?php else: ?>
                <canvas id="deviceChart" height="150"></canvas>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- 地理位置 -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-globe"></i> 访客地理分布
            </div>
            <div class="card-body">
                <?php if (empty($traffic_data['country_stats'])): ?>
                <p class="text-muted text-center">暂无数据</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>国家/地区</th>
                                <th>访问次数</th>
                                <th>占比</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($traffic_data['country_stats'] as $country => $count): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($country); ?></td>
                                <td><?php echo number_format($count); ?></td>
                                <td><?php echo $traffic_data['total_visits'] > 0 ? round(($count / $traffic_data['total_visits']) * 100, 1) : 0; ?>%</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- 访问日志 -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <i class="fas fa-list"></i> 访问日志 
                    <small class="text-muted">(共 <?php echo number_format($log_data['total']); ?> 条记录)</small>
                    <?php if (empty(array_filter(array_column($log_data['logs'], 'duration')))): ?>
                    <small class="text-warning">调试：无有效时长数据</small>
                    <?php endif; ?>
                </span>
                <?php if ($log_data['pages'] > 1): ?>
                <span class="text-muted">
                    第 <?php echo $log_data['current_page']; ?> 页，共 <?php echo $log_data['pages']; ?> 页
                </span>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <?php if (empty($log_data['logs'])): ?>
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>该日期暂无访问记录</h5>
                    <p class="text-muted">请选择其他日期查看</p>
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>时间</th>
                                <th>访客ID</th>
                                <th>IP地址</th>
                                <th>地理位置</th>
                                <th>设备</th>
                                <th>访问页面</th>
                                <th>来源</th>
                                <th>停留时长</th>
                                <th style="width: 60px;">原始值</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($log_data['logs'] as $log): ?>
                            <tr>
                                <td>
                                    <small><?php echo date('H:i:s', strtotime($log['timestamp'])); ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-info" title="<?php echo htmlspecialchars($log['visitor_id']); ?>">
                                        <?php echo substr($log['visitor_id'], -8); ?>
                                    </span>
                                </td>
                                <td>
                                    <code><?php echo htmlspecialchars($log['ip']); ?></code>
                                </td>
                                <td>
                                    <small>
                                        <?php echo htmlspecialchars($log['city']); ?>, 
                                        <?php echo htmlspecialchars($log['country']); ?>
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $log['device_type'] == 'mobile' ? 'primary' : 
                                            ($log['device_type'] == 'tablet' ? 'warning' : 'secondary'); 
                                    ?>">
                                        <?php echo ucfirst($log['device_type']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="max-width: 200px;">
                                        <small title="<?php echo htmlspecialchars($log['url']); ?>">
                                            <?php 
                                            $url_path = parse_url($log['url'], PHP_URL_PATH) ?: '/';
                                            echo htmlspecialchars(strlen($url_path) > 30 ? substr($url_path, 0, 30) . '...' : $url_path); 
                                            ?>
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <small>
                                        <?php 
                                        if ($log['referrer'] == 'direct' || empty($log['referrer'])) {
                                            echo '<span class="text-muted">直接访问</span>';
                                        } else {
                                            $referrer_host = parse_url($log['referrer'], PHP_URL_HOST) ?: $log['referrer'];
                                            echo htmlspecialchars(strlen($referrer_host) > 20 ? substr($referrer_host, 0, 20) . '...' : $referrer_host);
                                        }
                                        ?>
                                    </small>
                                </td>
                                <td>
                                    <?php if ($log['duration'] > 0): ?>
                                        <?php
                                        $badge_class = 'bg-secondary';
                                        $title = '未知来源';
                                        
                                        if ($log['is_heartbeat']) {
                                            $badge_class = 'bg-success';
                                            $title = '实时心跳数据';
                                        } elseif ($log['duration_source'] == 'calculated') {
                                            $badge_class = 'bg-primary';
                                            $title = '会话时长计算 (last_update - start_time)';
                                        } elseif ($log['duration_source'] == 'max') {
                                            $badge_class = 'bg-info';
                                            $title = '会话最大时长';
                                        }
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>" title="<?php echo $title; ?>">
                                            <?php echo $log['duration']; ?>s
                                        </span>
                                    <?php else: ?>
                                    <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted">原始:<?php echo $log['original_duration']; ?></small>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- 分页导航 -->
                <?php if ($log_data['pages'] > 1): ?>
                <div class="d-flex justify-content-between align-items-center p-3 border-top">
                    <div class="text-muted">
                        显示第 <?php echo (($log_data['current_page'] - 1) * $per_page + 1); ?> 到 
                        <?php echo min($log_data['current_page'] * $per_page, $log_data['total']); ?> 条，
                        共 <?php echo number_format($log_data['total']); ?> 条记录
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <?php
                            $base_url = "traffic.php?domain=" . urlencode($domain) . "&date=" . urlencode($view_date);
                            
                            // 上一页
                            if ($log_data['current_page'] > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $base_url; ?>&page=<?php echo $log_data['current_page'] - 1; ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                </li>
                            <?php endif;
                            
                            // 页码显示逻辑
                            $start_page = max(1, $log_data['current_page'] - 2);
                            $end_page = min($log_data['pages'], $log_data['current_page'] + 2);
                            
                            // 如果不是从第1页开始，显示第1页和省略号
                            if ($start_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $base_url; ?>&page=1">1</a>
                                </li>
                                <?php if ($start_page > 2): ?>
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                                <?php endif; ?>
                            <?php endif;
                            
                            // 显示当前页附近的页码
                            for ($i = $start_page; $i <= $end_page; $i++): ?>
                                <li class="page-item <?php echo $i == $log_data['current_page'] ? 'active' : ''; ?>">
                                    <a class="page-link" href="<?php echo $base_url; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor;
                            
                            // 如果不是到最后一页，显示省略号和最后一页
                            if ($end_page < $log_data['pages']): ?>
                                <?php if ($end_page < $log_data['pages'] - 1): ?>
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $base_url; ?>&page=<?php echo $log_data['pages']; ?>"><?php echo $log_data['pages']; ?></a>
                                </li>
                            <?php endif;
                            
                            // 下一页
                            if ($log_data['current_page'] < $log_data['pages']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $base_url; ?>&page=<?php echo $log_data['current_page'] + 1; ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// 每日趋势图
const dailyData = <?php echo json_encode($traffic_data['daily_stats']); ?>;
// 确保日期按时间顺序排序
const dates = Object.keys(dailyData).sort((a, b) => new Date(a) - new Date(b));
const visits = dates.map(date => dailyData[date] ? dailyData[date]['visits'] : 0);
const uniqueVisitors = dates.map(date => dailyData[date] ? dailyData[date]['unique_visitors'] : 0);

const dailyCtx = document.getElementById('dailyChart').getContext('2d');
new Chart(dailyCtx, {
    type: 'line',
    data: {
        labels: dates,
        datasets: [{
            label: '访问量',
            data: visits,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }, {
            label: '独立访客',
            data: uniqueVisitors,
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// 设备类型饼图
<?php if (!empty($traffic_data['device_stats'])): ?>
const deviceData = <?php echo json_encode($traffic_data['device_stats']); ?>;
const deviceCtx = document.getElementById('deviceChart').getContext('2d');
new Chart(deviceCtx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(deviceData),
        datasets: [{
            data: Object.values(deviceData),
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
<?php endif; ?>

// 测试analytics功能
function testAnalytics() {
    if (typeof window._debugAnalytics === 'function') {
        window._debugAnalytics();
        alert('已发送测试数据，请等待几秒后刷新页面查看');
    } else {
        alert('Analytics调试函数未找到，请确认analytics.js已正确加载');
    }
}
</script>

<?php require_once 'footer.php'; ?>