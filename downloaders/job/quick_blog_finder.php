<?php
/**
 * 快速博客查找脚本
 * 提供实用的博客列表和搜索策略
 */

// 高质量博客列表（按类别分类）
$qualityBlogs = [
    'technology' => [
        ['url' => 'https://techcrunch.com', 'notes' => '科技新闻，Disqus评论'],
        ['url' => 'https://thenextweb.com', 'notes' => '科技媒体，原生评论'],
        ['url' => 'https://venturebeat.com', 'notes' => '科技商业新闻'],
        ['url' => 'https://readwrite.com', 'notes' => '技术深度分析'],
        ['url' => 'https://9to5mac.com', 'notes' => 'Apple 新闻，活跃评论'],
        ['url' => 'https://androidauthority.com', 'notes' => 'Android 新闻'],
        ['url' => 'https://www.theverge.com', 'notes' => '科技文化媒体'],
        ['url' => 'https://arstechnica.com', 'notes' => '技术深度报道'],
    ],
    
    'marketing' => [
        ['url' => 'https://neilpatel.com/blog/', 'notes' => 'SEO和营销，开放评论'],
        ['url' => 'https://backlinko.com/blog', 'notes' => 'SEO策略'],
        ['url' => 'https://www.quicksprout.com/blog/', 'notes' => '营销增长'],
        ['url' => 'https://moz.com/blog', 'notes' => 'SEO工具和策略'],
        ['url' => 'https://blog.hubspot.com', 'notes' => '入站营销'],
        ['url' => 'https://contentmarketinginstitute.com/blog/', 'notes' => '内容营销'],
    ],
    
    'wordpress' => [
        ['url' => 'https://www.wpbeginner.com', 'notes' => 'WordPress 教程'],
        ['url' => 'https://www.elegantthemes.com/blog/', 'notes' => 'Divi 主题博客'],
        ['url' => 'https://torquemag.io', 'notes' => 'WordPress 新闻'],
        ['url' => 'https://wptavern.com', 'notes' => 'WordPress 社区'],
        ['url' => 'https://www.codeinwp.com/blog/', 'notes' => 'WordPress 开发'],
    ],
    
    'business' => [
        ['url' => 'https://www.entrepreneur.com', 'notes' => '创业者杂志'],
        ['url' => 'https://www.inc.com', 'notes' => '商业杂志'],
        ['url' => 'https://www.businessinsider.com', 'notes' => '商业内幕'],
        ['url' => 'https://hbr.org', 'notes' => '哈佛商业评论'],
    ],
    
    'lifestyle' => [
        ['url' => 'https://www.huffpost.com', 'notes' => '生活方式综合'],
        ['url' => 'https://www.buzzfeed.com', 'notes' => '流行文化'],
        ['url' => 'https://lifehacker.com', 'notes' => '生活技巧'],
    ],
    
    'food' => [
        ['url' => 'https://www.seriouseats.com', 'notes' => '美食深度内容'],
        ['url' => 'https://food52.com', 'notes' => '食谱社区'],
        ['url' => 'https://www.thekitchn.com', 'notes' => '厨房和食谱'],
    ],
];

// 查找 CommentLuv 博客的搜索查询
$commentLuvSearches = [
    'technology' => [
        '"this blog uses commentluv" technology',
        '"commentluv enabled" tech blog',
        '"reward top commenters" technology',
    ],
    'marketing' => [
        '"commentluv enabled" marketing',
        '"this blog uses premium commentluv" SEO',
        '"reward commenters" digital marketing',
    ],
    'general' => [
        '"notify me of followup comments" "name" "email" "website"',
        '"leave a reply" "your email address will not be published"',
        'inurl:blog "post comment" -"comments are closed"',
    ],
];

// 博客质量检查清单
$qualityChecklist = [
    '更新频率' => '查看最近的发布日期，活跃的博客更好',
    '评论数量' => '查看文章是否有评论，有评论说明开放且活跃',
    '作者回复' => '博主是否回复评论，表明重视互动',
    'Domain Authority' => '使用 MozBar 插件查看 DA 值（建议 > 30）',
    '内容质量' => '原创、深度、有价值的内容',
    '社交信号' => '文章是否被分享，表明受欢迎程度',
    '评论政策' => '查看是否有评论政策页面',
    'HTTPS' => '使用 HTTPS 的网站更专业',
    '响应式设计' => '移动友好的网站',
    '加载速度' => '快速加载的网站用户体验更好',
];

// 实用函数：生成特定领域的搜索查询
function generateSearchQueries($niche, $keywords = []) {
    $queries = [];
    
    $baseQueries = [
        '"leave a comment" %s %s',
        '"post a comment" %s %s', 
        'intitle:%s "comments" -"comments are closed"',
        '"%s blog" "notify me" comment',
        'site:wordpress.com %s "leave a reply"',
        '"powered by wordpress" %s comment name email',
    ];
    
    foreach ($keywords as $keyword) {
        foreach ($baseQueries as $template) {
            $queries[] = sprintf($template, $niche, $keyword);
        }
    }
    
    return $queries;
}

// 实用函数：检查博客是否值得评论
function assessBlogQuality($url) {
    $criteria = [
        'domain_age' => '域名年龄（越老越好）',
        'content_freshness' => '最近更新（30天内有更新最好）',
        'comment_activity' => '评论活跃度',
        'social_presence' => '社交媒体存在',
        'page_rank' => '页面权重',
        'spam_score' => '垃圾邮件分数（越低越好）',
        'mobile_friendly' => '移动友好性',
        'ssl_certificate' => 'SSL证书',
    ];
    
    echo "评估博客质量: $url\n";
    echo "检查项目:\n";
    foreach ($criteria as $key => $description) {
        echo "  □ $description\n";
    }
    echo "\n使用工具:\n";
    echo "  • Moz Link Explorer\n";
    echo "  • Ahrefs Site Explorer\n";
    echo "  • Google PageSpeed Insights\n";
    echo "  • Mobile-Friendly Test\n";
}

// ============ 主程序 ============

echo "=== 高质量博客快速查找工具 ===\n\n";

// 1. 显示分类博客列表
echo "1. 精选博客列表（按类别）:\n\n";
foreach ($qualityBlogs as $category => $blogs) {
    echo "【" . ucfirst($category) . "】\n";
    foreach ($blogs as $i => $blog) {
        echo "  " . ($i + 1) . ". {$blog['url']} - {$blog['notes']}\n";
    }
    echo "\n";
}

// 2. 显示搜索策略
echo "2. Google 搜索策略:\n\n";
echo "查找 CommentLuv 博客:\n";
foreach ($commentLuvSearches['general'] as $search) {
    echo "  • $search\n";
}

// 3. 生成自定义搜索
echo "\n3. 生成自定义搜索查询:\n\n";
$customQueries = generateSearchQueries('artificial intelligence', ['machine learning', 'deep learning']);
echo "AI 领域博客搜索:\n";
foreach (array_slice($customQueries, 0, 5) as $query) {
    echo "  • $query\n";
}

// 4. 博客质量评估
echo "\n4. 博客质量检查清单:\n\n";
foreach ($qualityChecklist as $item => $description) {
    echo "  ✓ $item: $description\n";
}

// 5. 快速提示
echo "\n5. 快速提示:\n\n";
echo "  • 使用 site:domain.com \"leave a comment\" 检查特定网站\n";
echo "  • 在 Google 搜索中使用 Tools > Any time > Past month 查找活跃博客\n";
echo "  • 安装 MozBar 浏览器插件快速查看 DA/PA\n";
echo "  • 查找 'Top [niche] blogs [year]' 文章获取列表\n";
echo "  • 关注 AllTop.com 的分类获取优质博客\n";
echo "  • 使用 -site:domain.com 排除特定网站\n";
echo "  • 搜索 '[niche] blog awards' 找获奖博客\n";

// 6. 保存搜索结果模板
$searchTemplate = "# 博客搜索记录模板

日期: " . date('Y-m-d') . "
关键词: [YOUR KEYWORDS]
领域: [YOUR NICHE]

## 找到的博客:
1. URL: 
   - 支持评论: 是/否
   - 评论系统: WordPress/Disqus/其他
   - DA/PA: 
   - 备注: 

2. URL: 
   - 支持评论: 是/否
   - 评论系统: WordPress/Disqus/其他
   - DA/PA: 
   - 备注: 

## 搜索查询使用:
- 
- 
- 

## 下次改进:
- 
";

file_put_contents('blog_search_template.txt', $searchTemplate);
echo "\n\n已创建搜索记录模板: blog_search_template.txt\n";

?>