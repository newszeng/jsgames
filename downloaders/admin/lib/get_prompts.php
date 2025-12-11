<?php
header('Content-Type: application/json');

$prompts_file = '../data/prompts.json';
$prompts = [];

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
    
    // 确保目录存在
    @mkdir('../data', 0777, true);
    file_put_contents($prompts_file, json_encode($prompts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

echo json_encode($prompts);
?>