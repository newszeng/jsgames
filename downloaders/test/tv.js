/**
 * YouTube TV 客户端 OAuth2 认证完整实现
 * 根据 YouTube.js 官方指南，TV 客户端是目前唯一支持 OAuth2 的方式
 * 
 * 使用前请确保安装依赖：
 * npm install youtubei.js
 */

let Innertube, UniversalCache;

try {
    const youtubeModule = require('youtubei.js');
    Innertube = youtubeModule.Innertube;
    UniversalCache = youtubeModule.UniversalCache;
} catch (error) {
    console.error('❌ 缺少 youtubei.js 模块！');
    console.error('请运行以下命令安装：');
    console.error('npm install youtubei.js');
    process.exit(1);
}

const fs = require('fs');
const path = require('path');

// 凭证文件路径
const CREDS_PATH = path.join(__dirname, 'youtube_tv_credentials.json');

class TVYouTubeClient {
    constructor() {
        this.youtube = null;
        this.credsPath = CREDS_PATH;
        this.isAuthenticated = false;
    }

    /**
     * 初始化 TV 客户端并执行认证
     */
    async initialize() {
        console.log('🔧 初始化 YouTube TV 客户端...');

        // 读取已保存的凭证（如果存在）
        const savedCredentials = this.loadCredentials();
        
        if (savedCredentials) {
            console.log('📁 找到已保存的凭证');
        }

        // 创建 TV 客户端实例
        this.youtube = await Innertube.create({
            // 关键：指定客户端类型为 TV
            client_type: 'TV',
            // 指定客户端名称
            client_name: 'TVHTML5',
            // 生成本地会话数据以提高性能
            generate_session_locally: true,
            // 启用缓存
            enable_session_cache: true,
            // 缓存配置
            cache: new UniversalCache(false),
            // 设备信息（模拟真实电视）
            device_make: 'Samsung',
            device_model: 'SmartTV',
            // 性能优化
            retrieve_player: true,
            enable_safety_mode: false,
            // 位置设置
            location: 'US'
        });

        // 设置事件监听器
        this.setupEventHandlers();

        // 执行登录
        await this.performAuthentication(savedCredentials);

        return this.youtube;
    }

    /**
     * 设置各种事件处理器
     */
    setupEventHandlers() {
        // 认证等待事件
        this.youtube.session.on('auth-pending', (data) => {
            console.log('\n========================================');
            console.log('📺 需要进行设备认证');
            console.log('========================================');
            console.log(`1. 在手机或电脑上打开: ${data.verification_url}`);
            console.log(`2. 输入代码: ${data.user_code}`);
            console.log('========================================');
            console.log('⏳ 等待认证完成...');
            console.log('💡 提示: 保持此窗口打开，认证完成后会自动继续');
        });

        // 认证成功事件
        this.youtube.session.on('auth', ({ credentials }) => {
            console.log('\n✅ 认证成功！');
            
            // 保存凭证到文件
            this.saveCredentials(credentials);
            console.log('💾 凭证已保存到:', this.credsPath);
            this.isAuthenticated = true;
        });

        // 凭证更新事件（令牌刷新时触发）
        this.youtube.session.on('update-credentials', ({ credentials }) => {
            console.log('🔄 凭证已自动更新');
            this.saveCredentials(credentials);
        });

        // 认证错误事件
        this.youtube.session.on('auth-error', (error) => {
            console.error('❌ 认证错误:', error.message);
            
            // 清除损坏的凭证
            if (fs.existsSync(this.credsPath)) {
                console.log('🗑️ 清除损坏的凭证文件');
                fs.unlinkSync(this.credsPath);
            }
        });
    }

    /**
     * 执行认证流程
     */
    async performAuthentication(savedCredentials) {
        try {
            await this.youtube.session.signIn(savedCredentials);
            
            // 验证登录状态
            if (this.youtube.session.logged_in) {
                console.log('✅ 已登录到 YouTube TV');
                this.isAuthenticated = true;
                
                try {
                    // 获取账户信息
                    const accountInfo = await this.youtube.account.getInfo();
                    console.log('👤 账户名称:', accountInfo.name);
                    console.log('🆔 账户 ID:', accountInfo.id);
                } catch (error) {
                    console.log('⚠️ 无法获取账户信息:', error.message);
                }
            } else {
                console.log('⚠️ 登录状态未确认');
            }
        } catch (error) {
            console.error('❌ 登录失败:', error.message);
            throw error;
        }
    }

    /**
     * 加载保存的凭证
     */
    loadCredentials() {
        if (fs.existsSync(this.credsPath)) {
            try {
                const credentials = JSON.parse(fs.readFileSync(this.credsPath, 'utf-8'));
                return credentials;
            } catch (error) {
                console.log('⚠️ 凭证文件损坏，将重新认证');
                // 删除损坏的文件
                fs.unlinkSync(this.credsPath);
                return null;
            }
        }
        return null;
    }

    /**
     * 保存凭证到文件
     */
    saveCredentials(credentials) {
        try {
            fs.writeFileSync(this.credsPath, JSON.stringify(credentials, null, 2));
        } catch (error) {
            console.error('❌ 保存凭证失败:', error.message);
        }
    }

    /**
     * 获取视频信息（支持私有/会员内容）
     */
    async getVideoInfo(videoId) {
        if (!this.isAuthenticated) {
            throw new Error('需要先进行认证');
        }

        try {
            console.log(`🎬 获取视频信息: ${videoId}`);
            const info = await this.youtube.getInfo(videoId);
            
            if (info && info.basic_info) {
                console.log(`📹 标题: ${info.basic_info.title}`);
                console.log(`👤 作者: ${info.basic_info.author}`);
                console.log(`⏱️ 时长: ${info.basic_info.duration?.seconds_total || 0} 秒`);
                
                // 检查是否有流媒体数据
                if (info.streaming_data) {
                    const formatCount = (info.streaming_data.formats?.length || 0) + 
                                      (info.streaming_data.adaptive_formats?.length || 0);
                    console.log(`🎬 可用格式: ${formatCount}`);
                    
                    return {
                        success: true,
                        videoInfo: info,
                        client: 'TV (Authenticated)'
                    };
                } else {
                    console.log('⚠️ 无流媒体数据');
                    return {
                        success: false,
                        error: 'No streaming data available',
                        videoInfo: info,
                        client: 'TV (Authenticated)'
                    };
                }
            } else {
                throw new Error('无法获取视频信息');
            }
        } catch (error) {
            console.error(`❌ 获取视频 ${videoId} 失败:`, error.message);
            return {
                success: false,
                error: error.message,
                videoId,
                client: 'TV (Authenticated)'
            };
        }
    }

    /**
     * 获取用户播放列表
     */
    async getPlaylists() {
        if (!this.isAuthenticated) {
            throw new Error('需要先进行认证');
        }

        try {
            console.log('📋 获取播放列表...');
            const playlists = await this.youtube.account.getPlaylists();
            console.log(`✅ 找到 ${playlists.length} 个播放列表`);
            return playlists;
        } catch (error) {
            console.error('❌ 获取播放列表失败:', error.message);
            throw error;
        }
    }

    /**
     * 获取订阅内容
     */
    async getSubscriptions() {
        if (!this.isAuthenticated) {
            throw new Error('需要先进行认证');
        }

        try {
            console.log('📺 获取订阅内容...');
            const subscriptions = await this.youtube.getSubscriptionsFeed();
            console.log('✅ 订阅内容已加载');
            return subscriptions;
        } catch (error) {
            console.error('❌ 获取订阅失败:', error.message);
            throw error;
        }
    }

    /**
     * 获取观看历史
     */
    async getHistory() {
        if (!this.isAuthenticated) {
            throw new Error('需要先进行认证');
        }

        try {
            console.log('📜 获取观看历史...');
            const history = await this.youtube.getHistory();
            console.log('✅ 历史记录已加载');
            return history;
        } catch (error) {
            console.error('❌ 获取历史记录失败:', error.message);
            throw error;
        }
    }

    /**
     * 搜索视频
     */
    async searchVideos(query, limit = 10) {
        try {
            console.log(`🔍 搜索: "${query}"`);
            const results = await this.youtube.search(query, {
                type: 'video'
            });

            const videos = results.videos.slice(0, limit).map(video => ({
                videoId: video.id,
                title: video.title.text,
                author: video.author.name,
                duration: video.duration?.seconds_total,
                viewCount: video.view_count?.text,
                publishedTime: video.published?.text,
                thumbnail: video.thumbnails[0]?.url,
                url: `https://www.youtube.com/watch?v=${video.id}`
            }));

            console.log(`✅ 找到 ${videos.length} 个视频`);
            return videos;
        } catch (error) {
            console.error('❌ 搜索失败:', error.message);
            throw error;
        }
    }

    /**
     * 登出并清除凭证
     */
    async logout() {
        try {
            if (this.youtube && this.youtube.session.logged_in) {
                await this.youtube.session.signOut();
                console.log('✅ 已从 YouTube 登出');
            }
            
            // 删除本地凭证文件
            if (fs.existsSync(this.credsPath)) {
                fs.unlinkSync(this.credsPath);
                console.log('🗑️ 本地凭证已清除');
            }
            
            this.isAuthenticated = false;
            console.log('✅ 登出完成');
        } catch (error) {
            console.error('❌ 登出失败:', error.message);
            throw error;
        }
    }

    /**
     * 检查认证状态
     */
    isLoggedIn() {
        return this.isAuthenticated && this.youtube && this.youtube.session.logged_in;
    }

    /**
     * 获取客户端信息
     */
    getClientInfo() {
        if (!this.youtube) {
            return null;
        }

        return {
            clientName: this.youtube.session.client_name,
            clientVersion: this.youtube.session.client_version,
            loggedIn: this.isLoggedIn(),
            hasCredentials: fs.existsSync(this.credsPath)
        };
    }
}

/**
 * 快速测试函数
 */
async function testTVClient() {
    console.log('🚀 开始测试 YouTube TV 客户端');
    console.log('=' .repeat(50));

    const tvClient = new TVYouTubeClient();
    
    try {
        // 初始化并认证
        await tvClient.initialize();
        
        if (tvClient.isLoggedIn()) {
            console.log('\n📊 客户端信息:');
            console.log(tvClient.getClientInfo());
            
            // 测试获取视频信息
            console.log('\n🧪 测试视频获取功能...');
            const testVideos = ['Oi-Dyp8I56U', 'dQw4w9WgXcQ'];
            
            for (const videoId of testVideos) {
                const result = await tvClient.getVideoInfo(videoId);
                console.log(`\n${result.success ? '✅' : '❌'} ${videoId}: ${
                    result.success ? result.videoInfo.basic_info.title : result.error
                }`);
            }
            
            // 可以测试其他功能
            // const playlists = await tvClient.getPlaylists();
            // const subscriptions = await tvClient.getSubscriptions();
            
        } else {
            console.log('❌ 认证失败，无法继续测试');
        }
        
    } catch (error) {
        console.error('❌ 测试失败:', error.message);
    }
}

// 如果直接运行此文件，则执行测试
if (require.main === module) {
    testTVClient().catch(console.error);
}

module.exports = {
    TVYouTubeClient,
    testTVClient
};