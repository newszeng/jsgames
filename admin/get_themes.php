<?php
header('Content-Type: application/json');

// 获取游戏类型参数
$type = $_GET['type'] ?? '';

if (empty($type)) {
    echo json_encode([]);
    exit();
}

// 获取游戏主题列表的函数（与 website.php 中的相同）
function getThemes($type) {
    $themes = [];
    
    // 为游戏网站提供预设主题
    switch($type) {
        case 'wordle':
            $themes = [
                ['name' => 'theme1', 'description' => '<p>经典 Wordle 样式，简洁清爽</p>'],
                ['name' => 'theme2', 'description' => '<p>深色主题，护眼模式</p>'],
            ];
            break;
        case 'tetris':
            $themes = [
                ['name' => 'theme1', 'description' => '<p>经典俄罗斯方块样式</p>'],
                ['name' => 'theme2', 'description' => '<p>现代彩色主题</p>'],
            ];
            break;
        case 'snake':
            $themes = [
                ['name' => 'theme1', 'description' => '<p>经典贪吃蛇绿色主题</p>'],
                ['name' => 'theme2', 'description' => '<p>霓虹灯效果主题</p>'],
            ];
            break;
        case '2048':
            $themes = [
                ['name' => 'theme1', 'description' => '<p>经典 2048 橙色主题</p>'],
                ['name' => 'theme2', 'description' => '<p>蓝色科技主题</p>'],
            ];
            break;
        default:
            $themes = [
                ['name' => 'theme1', 'description' => '<p>默认主题</p>'],
            ];
    }
    
    return $themes;
}

// 获取并返回主题列表
$themes = getThemes($type);
echo json_encode($themes);
?>