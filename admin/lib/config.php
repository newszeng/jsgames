<?php
// Google Serper API 配置
$config = [
    'google_serper' => [
        'url' => 'https://google.serper.dev/search',
        'api_key' => '408e8b4f23f73c06bf6542cadfe481e988014a06', // 请替换为您的 API Key
        'timeout' => 30
    ],
    'development' => [
        'ssl_verify' => false // 开发环境可以设置为 false，生产环境建议设置为 true
    ]
];
?>