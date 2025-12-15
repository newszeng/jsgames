import {Innertube} from 'youtubei.js';
const youtube = await Innertube.create({
    // 可选：使用特定player_id避免问题
    retrieve_player: false  // 如果不需要下载，可以禁用
});
// 获取视频信息
const info = await youtube.getInfo('video_id');