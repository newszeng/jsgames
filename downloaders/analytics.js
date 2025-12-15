(function() {
    'use strict';

    function getVisitorId() {
        let visitorId = localStorage.getItem('_vid');
        if (!visitorId) {
            visitorId = 'v_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            localStorage.setItem('_vid', visitorId);
        }
        return visitorId;
    }

    function getSessionId() {
        let sessionId = sessionStorage.getItem('_sid');
        if (!sessionId) {
            sessionId = 's_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            sessionStorage.setItem('_sid', sessionId);
        }
        return sessionId;
    }

    function getDeviceType() {
        const ua = navigator.userAgent.toLowerCase();
        if (/mobile|android|iphone|ipad|phone/i.test(ua)) {
            return 'mobile';
        } else if (/tablet|ipad/i.test(ua)) {
            return 'tablet';
        }
        return 'desktop';
    }

    function getPageInfo() {
        return {
            url: window.location.href,
            title: document.title,
            referrer: document.referrer || 'direct',
            screenResolution: window.screen.width + 'x' + window.screen.height,
            viewport: window.innerWidth + 'x' + window.innerHeight,
            deviceType: getDeviceType(),
            userAgent: navigator.userAgent,
            language: navigator.language || navigator.userLanguage,
            browserLanguage: navigator.language || navigator.userLanguage,
            timezone: Intl.DateTimeFormat().resolvedOptions().timeZone
        };
    }

    const pageLoadTime = Date.now();

    function sendAnalytics(duration, isHeartbeat) {
        let sessionPageCount = sessionStorage.getItem('_session_page_count') || '0';
        sessionPageCount = parseInt(sessionPageCount) + (duration === 0 ? 1 : 0);
        sessionStorage.setItem('_session_page_count', sessionPageCount.toString());
        
        const data = {
            visitorId: getVisitorId(),
            sessionId: getSessionId(),
            pageInfo: getPageInfo(),
            duration: duration,
            sessionPageCount: sessionPageCount,
            timestamp: new Date().toISOString(),
            isHeartbeat: isHeartbeat || false
        };

        const payload = JSON.stringify(data);
        if (navigator.sendBeacon) {
            navigator.sendBeacon('/api/track.php', payload);
        } else {
            // 降级使用 fetch
            fetch('/api/track.php', {
                method: 'POST',
                body: payload,
                headers: {
                    'Content-Type': 'application/json'
                },
                keepalive: true
            }).catch(function(error) {
                console.error('Analytics error:', error);
            });
        }
    }

    if (document.readyState === 'complete') {
        sendAnalytics(0, false);
    } else {
        window.addEventListener('load', function() {
            sendAnalytics(0, false);
        });
    }

    window.addEventListener('beforeunload', function() {
        const duration = Math.round((Date.now() - pageLoadTime) / 1000); // 秒
        sendAnalytics(duration, true);
    });

    let hiddenTime = 0;
    let visibleTime = pageLoadTime;
    
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            hiddenTime = Date.now();
        } else {
            if (hiddenTime > 0) {
                const hiddenDuration = Date.now() - hiddenTime;
                visibleTime += hiddenDuration;
                hiddenTime = 0;
            }
        }
    });

    // 心跳间隔改为10秒，更容易测试
    setInterval(function() {
        if (!document.hidden) {
            const duration = Math.round((Date.now() - pageLoadTime) / 1000);
            sendAnalytics(duration, true);
        }
    }, 10000);
    
    // 添加更多退出事件监听
    window.addEventListener('unload', function() {
        const duration = Math.round((Date.now() - pageLoadTime) / 1000);
        sendAnalytics(duration, true);
    });
    
    window.addEventListener('pagehide', function() {
        const duration = Math.round((Date.now() - pageLoadTime) / 1000);
        sendAnalytics(duration, true);
    });
    
    // 调试功能：暴露发送函数到全局
    window._debugAnalytics = function() {
        const duration = Math.round((Date.now() - pageLoadTime) / 1000);
        console.log('Sending analytics with duration:', duration);
        sendAnalytics(duration, true);
    };
    
})();