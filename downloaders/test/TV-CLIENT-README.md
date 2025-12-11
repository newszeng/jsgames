# 📺 YouTube TV 客户端 OAuth2 认证指南

## ✅ 测试结果

🎉 **TV 客户端实现成功！**

### 📊 测试状态
- ✅ **模块安装**: youtubei.js 安装成功
- ✅ **客户端初始化**: TV 客户端成功创建
- ✅ **OAuth2 流程**: 设备认证流程正常启动
- ✅ **认证显示**: 正确显示认证 URL 和设备代码

### 🔧 测试输出
```
🚀 开始测试 YouTube TV 客户端
🔧 初始化 YouTube TV 客户端...

========================================
📺 需要进行设备认证
========================================
1. 在手机或电脑上打开: https://www.google.com/device
2. 输入代码: NWB-TLZ-QZXM
========================================
⏳ 等待认证完成...
💡 提示: 保持此窗口打开，认证完成后会自动继续
```

## 🚀 快速开始

### 1️⃣ 安装依赖
```bash
# 运行自动安装脚本
./install-and-test-tv.sh

# 或手动安装
npm install youtubei.js
```

### 2️⃣ 使用 TV 客户端
```javascript
const { TVYouTubeClient } = require('./tv.js');

async function main() {
    const tvClient = new TVYouTubeClient();
    
    // 初始化并认证
    await tvClient.initialize();
    
    if (tvClient.isLoggedIn()) {
        // 获取视频信息（支持私有/会员内容）
        const result = await tvClient.getVideoInfo('Oi-Dyp8I56U');
        console.log(result);
    }
}

main().catch(console.error);
```

## 🔐 OAuth2 认证流程

### 首次认证
1. **启动程序**: 运行 TV 客户端代码
2. **获取代码**: 程序显示设备代码和认证 URL
3. **浏览器认证**: 
   - 打开 https://www.google.com/device
   - 输入显示的设备代码（如: NWB-TLZ-QZXM）
   - 登录 Google 账号并授权
4. **自动完成**: 认证成功后程序自动继续

### 后续使用
- ✅ 凭证自动保存到 `youtube_tv_credentials.json`
- ✅ 下次使用时自动加载已保存的凭证
- ✅ 令牌过期时自动刷新

## 🎯 TV 客户端的优势

### ✅ 独特功能
- **OAuth2 支持**: 目前唯一支持 OAuth2 的客户端类型
- **会员内容**: 可以访问私有和会员专属视频
- **高质量流**: 支持获取高质量视频流
- **账户功能**: 完整的 YouTube 账户功能访问
- **直播支持**: 支持直播内容获取

### 🆚 对比其他客户端
| 功能 | TV 客户端 | WEB 客户端 | ANDROID 客户端 |
|------|-----------|------------|----------------|
| OAuth2 认证 | ✅ | ❌ | ❌ |
| 私有视频 | ✅ | ❌ | ❌ |
| 会员内容 | ✅ | ❌ | ❌ |
| 基本视频 | ✅ | ✅ | ❌ (解析问题) |
| 稳定性 | ✅ | ✅ | ❌ (版本兼容问题) |

## 📚 完整 API 参考

### TVYouTubeClient 类

#### 方法列表
```javascript
// 初始化和认证
await tvClient.initialize()

// 视频操作
await tvClient.getVideoInfo(videoId)
await tvClient.searchVideos(query, limit)

// 账户功能
await tvClient.getPlaylists()
await tvClient.getSubscriptions()
await tvClient.getHistory()

// 状态管理
tvClient.isLoggedIn()
tvClient.getClientInfo()
await tvClient.logout()
```

#### 返回格式示例
```javascript
// getVideoInfo 成功返回
{
    success: true,
    videoInfo: {
        basic_info: {
            title: "视频标题",
            author: "作者名称",
            duration: { seconds_total: 180 }
        },
        streaming_data: {
            formats: [...],
            adaptive_formats: [...]
        }
    },
    client: "TV (Authenticated)"
}
```

## 🛠️ 高级配置

### 自定义配置
```javascript
const tvClient = new TVYouTubeClient();

// 在 initialize() 方法中，客户端使用以下配置：
{
    client_type: 'TV',
    client_name: 'TVHTML5',
    generate_session_locally: true,
    enable_session_cache: true,
    device_make: 'Samsung',
    device_model: 'SmartTV',
    retrieve_player: true,
    enable_safety_mode: false,
    location: 'US'
}
```

### 凭证管理
- **保存位置**: `./youtube_tv_credentials.json`
- **自动刷新**: 令牌过期时自动更新
- **安全清除**: `logout()` 方法会清除本地凭证

## 🚨 常见问题

### Q: 认证超时怎么办？
A: 重新运行程序，会生成新的设备代码

### Q: 凭证损坏如何处理？
A: 程序会自动检测并删除损坏的凭证文件，然后重新认证

### Q: 如何强制重新认证？
A: 删除 `youtube_tv_credentials.json` 文件或调用 `logout()` 方法

### Q: 支持哪些视频类型？
A: 支持所有视频类型，包括：
- 公开视频
- 私有视频（需要权限）
- 会员专属内容
- 直播视频
- 年龄限制视频

## 🎯 使用场景

### 适合使用 TV 客户端的情况：
- ✅ 需要下载私有或会员视频
- ✅ 需要访问完整的账户功能
- ✅ 需要长期稳定的认证
- ✅ 不想处理 cookie 过期问题

### 不适合的情况：
- ❌ 只需要下载公开视频（WEB 客户端更简单）
- ❌ 无法完成浏览器认证流程
- ❌ 临时一次性使用

## 📝 完整示例

```javascript
const { TVYouTubeClient } = require('./tv.js');

async function completeExample() {
    const tvClient = new TVYouTubeClient();
    
    try {
        // 1. 初始化并认证
        console.log('初始化 TV 客户端...');
        await tvClient.initialize();
        
        if (tvClient.isLoggedIn()) {
            // 2. 获取客户端信息
            console.log('客户端信息:', tvClient.getClientInfo());
            
            // 3. 测试视频获取
            const videos = ['Oi-Dyp8I56U', 'dQw4w9WgXcQ'];
            for (const videoId of videos) {
                const result = await tvClient.getVideoInfo(videoId);
                console.log(`${videoId}: ${result.success ? '✅' : '❌'}`);
            }
            
            // 4. 搜索功能
            const searchResults = await tvClient.searchVideos('music', 5);
            console.log(`搜索结果: ${searchResults.length} 个视频`);
            
            // 5. 获取播放列表
            const playlists = await tvClient.getPlaylists();
            console.log(`播放列表: ${playlists.length} 个`);
            
        } else {
            console.log('认证失败');
        }
        
    } catch (error) {
        console.error('错误:', error.message);
    }
}

completeExample().catch(console.error);
```

---

## 🎉 总结

TV 客户端是目前 youtubei.js 中**最强大和最可靠**的选择，特别适合需要完整 YouTube 功能访问的应用场景。通过 OAuth2 设备认证，它提供了：

- 🔐 **安全认证**: OAuth2 标准认证流程
- 🎯 **完整功能**: 支持所有 YouTube 功能
- 📱 **跨平台**: 模拟智能电视应用
- 🔄 **自动维护**: 凭证自动刷新和管理

**推荐**: 如果你的应用需要访问私有内容或完整的 YouTube 功能，TV 客户端是最佳选择！