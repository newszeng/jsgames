<?php
// demo.php - YouTube搜索分页示例

function reverseVideoId($id) {
    return strrev($id);
}

function search_youtube($query, $max_results = 20, $is_home = 'yes', $continuation_token = null) {
    $key = 'AIzaSyAO_FJ2SlqU8Q4STEHLGCilw_Y9_11qcW8';

    if ($continuation_token) {
        // 使用continuation token获取下一页
        $url = "https://www.youtube.com/youtubei/v1/search?key={$key}";
        $data = array(
            'context' => array(
                'client' => array(
                    'hl' => 'en',
                    'clientName' => 'WEB',
                    'clientVersion' => '2.20210721.00.00',
                )
            ),
            'continuation' => $continuation_token
        );
    } else {
        // 首次搜索
        $url = "https://www.youtube.com/youtubei/v1/search?key={$key}";
        $params = "EgIQAQ%3D%3D";
        $data = array(
            'context' => array(
                'client' => array(
                    'hl' => 'en',
                    'clientName' => 'WEB',
                    'clientVersion' => '2.20210721.00.00',
                )
            ),
            'query' => $query,
            'params' => $params,
        );
    }

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        )
    );

    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    if ($result === FALSE) {
        return ['error' => 'Failed to fetch search results', 'videos' => [], 'nextPageToken' => null];
    }

    $json = json_decode($result, true);

    // 提取视频数据
    $videos = [];
    $next_page_token = null;

    // 查找视频内容
    if (isset($json['contents']['twoColumnSearchResultsRenderer']['primaryContents']['sectionListRenderer']['contents'])) {
        $contents = $json['contents']['twoColumnSearchResultsRenderer']['primaryContents']['sectionListRenderer']['contents'];

        foreach ($contents as $content) {
            // 提取视频
            if (isset($content['itemSectionRenderer']['contents'])) {
                foreach ($content['itemSectionRenderer']['contents'] as $item) {
                    if (isset($item['videoRenderer']) && count($videos) < $max_results) {
                        $video = $item['videoRenderer'];
                        $originalVideoId = $video['videoId'];
                        $videos[] = [
                            "url" => "https://www.youtube.com/watch?v=" . $originalVideoId,
                            "videoId" => reverseVideoId($originalVideoId),
                            "originalVideoId" => $originalVideoId,
                            "title" => $video['title']['runs'][0]['text'] ?? 'No title',
                            "thumbnail" => $video['thumbnail']['thumbnails'][0]['url'] ?? '',
                            "publishedAt" => $video['publishedTimeText']['simpleText'] ?? '',
                            "duration" => $video['lengthText']['simpleText'] ?? '',
                            "viewCount" => $video['viewCountText']['simpleText'] ?? '',
                            "channelName" => $video['ownerText']['runs'][0]['text'] ?? '',
                        ];
                    }
                }
            }

            // 查找continuation token
            if (isset($content['continuationItemRenderer']['continuationEndpoint']['continuationCommand']['token'])) {
                $next_page_token = $content['continuationItemRenderer']['continuationEndpoint']['continuationCommand']['token'];
            }
        }
    }

    // 如果是continuation请求，也检查onResponseReceivedCommands
    if ($continuation_token && isset($json['onResponseReceivedCommands'])) {
        foreach ($json['onResponseReceivedCommands'] as $command) {
            if (isset($command['appendContinuationItemsAction']['continuationItems'])) {
                foreach ($command['appendContinuationItemsAction']['continuationItems'] as $item) {
                    if (isset($item['itemSectionRenderer']['contents'])) {
                        foreach ($item['itemSectionRenderer']['contents'] as $content) {
                            if (isset($content['videoRenderer']) && count($videos) < $max_results) {
                                $video = $content['videoRenderer'];
                                $originalVideoId = $video['videoId'];
                                $videos[] = [
                                    "url" => "https://www.youtube.com/watch?v=" . $originalVideoId,
                                    "videoId" => reverseVideoId($originalVideoId),
                                    "originalVideoId" => $originalVideoId,
                                    "title" => $video['title']['runs'][0]['text'] ?? 'No title',
                                    "thumbnail" => $video['thumbnail']['thumbnails'][0]['url'] ?? '',
                                    "publishedAt" => $video['publishedTimeText']['simpleText'] ?? '',
                                    "duration" => $video['lengthText']['simpleText'] ?? '',
                                    "viewCount" => $video['viewCountText']['simpleText'] ?? '',
                                    "channelName" => $video['ownerText']['runs'][0]['text'] ?? '',
                                ];
                            }
                        }
                    }

                    if (isset($item['continuationItemRenderer']['continuationEndpoint']['continuationCommand']['token'])) {
                        $next_page_token = $item['continuationItemRenderer']['continuationEndpoint']['continuationCommand']['token'];
                    }
                }
            }
        }
    }

    return [
        'videos' => $videos,
        'nextPageToken' => $next_page_token,
        'hasNextPage' => !is_null($next_page_token)
    ];
}

// 处理AJAX请求
if (isset($_POST['action']) && $_POST['action'] === 'search') {
    header('Content-Type: application/json');

    $query = $_POST['query'] ?? '';
    $continuation = $_POST['continuation'] ?? null;
    $page = $_POST['page'] ?? 1;

    if (empty($query)) {
        echo json_encode(['error' => 'Query is required', 'videos' => []]);
        exit;
    }

    $result = search_youtube($query, 10, 'yes', $continuation);

    // 添加页码信息
    $result['page'] = $page;
    $result['query'] = $query;

    echo json_encode($result);
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube 搜索分页演示</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .search-box {
            background: white;
            border-radius: 50px;
            padding: 10px 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .search-box input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 16px;
            padding: 10px;
        }

        .search-box button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: transform 0.2s;
        }

        .search-box button:hover {
            transform: scale(1.05);
        }

        .search-box button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .info-bar {
            background: rgba(255,255,255,0.9);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
        }

        .info-bar.show {
            display: block;
        }

        .videos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .video-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .video-thumbnail {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: #f0f0f0;
        }

        .video-info {
            padding: 15px;
        }

        .video-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.4;
            max-height: 2.8em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .video-meta {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .video-channel {
            color: #333;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .video-stats {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #999;
        }

        .load-more {
            text-align: center;
            margin: 40px 0;
        }

        .load-more button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 50px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            transition: all 0.3s;
        }

        .load-more button:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        }

        .load-more button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: scale(1);
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: white;
            font-size: 18px;
        }

        .error {
            background: #ff4444;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }

        .no-results {
            text-align: center;
            color: white;
            font-size: 20px;
            margin-top: 50px;
        }

        .spinner {
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top: 3px solid white;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .debug-info {
            background: rgba(0,0,0,0.8);
            color: #00ff00;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🎬 YouTube 搜索分页演示</h1>
        <p>测试YouTube API的分页功能</p>
    </div>

    <div class="search-box">
        <input type="text" id="searchInput" placeholder="输入搜索关键词..." value="JavaScript tutorial">
        <button onclick="performSearch()" id="searchBtn">搜索</button>
    </div>

    <div class="info-bar" id="infoBar">
        <strong>搜索信息：</strong>
        <span id="searchInfo"></span>
        <div class="debug-info" id="debugInfo"></div>
    </div>

    <div class="loading" id="loading" style="display: none;">
        <div class="spinner"></div>
        正在加载...
    </div>

    <div class="error" id="error" style="display: none;"></div>

    <div class="videos-grid" id="videosGrid"></div>

    <div class="load-more" id="loadMoreContainer" style="display: none;">
        <button onclick="loadMore()" id="loadMoreBtn">加载更多</button>
        <div class="debug-info" id="tokenInfo" style="margin-top: 10px;"></div>
    </div>

    <div class="no-results" id="noResults" style="display: none;">
        没有找到相关视频
    </div>
</div>

<script>
    let currentQuery = '';
    let nextPageToken = null;
    let currentPage = 0;
    let isLoading = false;
    let totalVideos = 0;

    // 页面加载时自动执行搜索
    window.onload = function() {
        performSearch();
    };

    function performSearch() {
        const query = document.getElementById('searchInput').value.trim();
        if (!query) {
            showError('请输入搜索关键词');
            return;
        }

        // 重置状态
        currentQuery = query;
        nextPageToken = null;
        currentPage = 0;
        totalVideos = 0;
        document.getElementById('videosGrid').innerHTML = '';
        document.getElementById('loadMoreContainer').style.display = 'none';
        document.getElementById('noResults').style.display = 'none';

        // 执行搜索
        searchVideos(query, null);
    }

    function searchVideos(query, continuation) {
        if (isLoading) return;

        isLoading = true;
        currentPage++;

        // 显示加载状态
        document.getElementById('loading').style.display = 'block';
        document.getElementById('error').style.display = 'none';
        document.getElementById('searchBtn').disabled = true;
        document.getElementById('loadMoreBtn').disabled = true;

        // 发送AJAX请求
        const formData = new FormData();
        formData.append('action', 'search');
        formData.append('query', query);
        formData.append('page', currentPage);
        if (continuation) {
            formData.append('continuation', continuation);
        }

        fetch('demo.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log('API Response:', data);

                if (data.error) {
                    showError(data.error);
                    return;
                }

                // 显示视频
                displayVideos(data.videos);

                // 更新统计信息
                totalVideos += data.videos.length;
                updateInfo(data);

                // 处理分页
                nextPageToken = data.nextPageToken;

                if (nextPageToken) {
                    document.getElementById('loadMoreContainer').style.display = 'block';
                    document.getElementById('tokenInfo').innerHTML = `
                        <strong>调试信息：</strong><br>
                        Next Page Token: ${nextPageToken ? nextPageToken.substring(0, 50) + '...' : 'null'}<br>
                        当前页码: ${currentPage}<br>
                        已加载视频: ${totalVideos}
                    `;
                } else {
                    document.getElementById('loadMoreContainer').style.display = 'none';
                }

                // 如果没有结果
                if (currentPage === 1 && data.videos.length === 0) {
                    document.getElementById('noResults').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('请求失败: ' + error.message);
            })
            .finally(() => {
                isLoading = false;
                document.getElementById('loading').style.display = 'none';
                document.getElementById('searchBtn').disabled = false;
                document.getElementById('loadMoreBtn').disabled = false;
            });
    }

    function loadMore() {
        if (nextPageToken && currentQuery) {
            searchVideos(currentQuery, nextPageToken);
        }
    }

    function displayVideos(videos) {
        const grid = document.getElementById('videosGrid');

        videos.forEach((video, index) => {
            const card = document.createElement('div');
            card.className = 'video-card';
            card.style.animationDelay = `${index * 0.05}s`;

            card.innerHTML = `
                    <a href="${video.url}" target="_blank" style="text-decoration: none; color: inherit;">
                        <img src="${video.thumbnail}" alt="${video.title}" class="video-thumbnail"
                             onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 320 180%22><rect fill=%22%23ddd%22 width=%22320%22 height=%22180%22/><text fill=%22%23999%22 font-family=%22sans-serif%22 font-size=%2216%22 x=%2250%%22 y=%2250%%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22>No Thumbnail</text></svg>'">
                        <div class="video-info">
                            <div class="video-title">${video.title}</div>
                            <div class="video-channel">📺 ${video.channelName}</div>
                            <div class="video-stats">
                                <span>👁 ${video.viewCount || 'N/A'}</span>
                                <span>⏱ ${video.duration || 'N/A'}</span>
                            </div>
                            <div class="video-meta">
                                ${video.publishedAt || '发布时间未知'}
                            </div>
                            <div class="video-meta" style="font-size: 11px; color: #ccc;">
                                ID: ${video.originalVideoId}
                            </div>
                        </div>
                    </a>
                `;

            grid.appendChild(card);
        });
    }

    function updateInfo(data) {
        const infoBar = document.getElementById('infoBar');
        const searchInfo = document.getElementById('searchInfo');
        const debugInfo = document.getElementById('debugInfo');

        infoBar.classList.add('show');
        searchInfo.innerHTML = `
                关键词: <strong>${currentQuery}</strong> |
                第 <strong>${currentPage}</strong> 页 |
                本页加载: <strong>${data.videos.length}</strong> 个视频 |
                总计: <strong>${totalVideos}</strong> 个视频
            `;

        debugInfo.innerHTML = `
                Has Next Page: ${data.hasNextPage ? 'YES ✅' : 'NO ❌'}<br>
                Next Token Length: ${data.nextPageToken ? data.nextPageToken.length : 0} characters<br>
                API Response Time: ${new Date().toLocaleTimeString()}
            `;
    }

    function showError(message) {
        const errorDiv = document.getElementById('error');
        errorDiv.innerHTML = '❌ ' + message;
        errorDiv.style.display = 'block';

        setTimeout(() => {
            errorDiv.style.display = 'none';
        }, 5000);
    }

    // 支持回车键搜索
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
</script>
</body>
</html>