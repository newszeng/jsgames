// Child iframe: report content height to parent for auto-resizing
document.addEventListener('DOMContentLoaded', function () {
    let parentOrigin = null;
    let scheduled = false;

    function scheduleSend() {
        if (scheduled) return;
        scheduled = true;
        (window.requestAnimationFrame || function (cb) { return setTimeout(cb, 16); })(function () {
            scheduled = false;
            sendHeight();
        });
    }

    function calculateHeight() {
        let h = 0;
        const body = document.body;
        const html = document.documentElement;
        
        if (body && html) {
            const bodyHeight = body.scrollHeight;
            const htmlHeight = html.scrollHeight;
            h = Math.max(bodyHeight, htmlHeight);
            
            const bodyStyle = window.getComputedStyle(body);
            const marginTop = parseFloat(bodyStyle.marginTop) || 0;
            const marginBottom = parseFloat(bodyStyle.marginBottom) || 0;
            h = h + marginTop + marginBottom;
        }
        
        if (h === 0) {
            const root = document.getElementById('root');
            if (root) {
                h = root.scrollHeight || root.offsetHeight || 0;
            }
        }
        
        return Math.max(h, 100);
    }

    function sendHeight() {
        try {
            const height = calculateHeight();
            
            if (!window.parent) return;
            window.parent.postMessage({
                type: 'COMBINATIONS_IFRAME_HEIGHT',
                height: height
            }, parentOrigin || '*');
        } catch (e) {
            console.error('Failed to send iframe height:', e);
        }
    }

    // Monitor element size changes
    if (typeof ResizeObserver === 'function') {
        try {
            const ro = new ResizeObserver(function () { scheduleSend(); });
            ro.observe(document.documentElement);
            const rootEl = document.getElementById('root');
            if (rootEl) ro.observe(rootEl);
        } catch (e) {
            console.error('ResizeObserver setup failed:', e);
        }
    }

    // Monitor DOM changes
    try {
        const moTarget = document.getElementById('root') || document.body;
        if (moTarget && typeof MutationObserver === 'function') {
            const mo = new MutationObserver(function () { scheduleSend(); });
            mo.observe(moTarget, { subtree: true, childList: true, attributes: true, characterData: true });
        }
    } catch (e) {
        console.error('MutationObserver setup failed:', e);
    }

    // Send height on page load and with minimal delays for React apps
    window.addEventListener('load', function () {
        scheduleSend();
        // Only minimal delays for React app initialization
        setTimeout(scheduleSend, 500);
        setTimeout(scheduleSend, 1000);
    });

    // More efficient React app ready detection
    let reactCheckCount = 0;
    const maxReactChecks = 30; // Max 3 seconds of checking
    const checkReactReady = setInterval(function() {
        const root = document.getElementById('root');
        reactCheckCount++;
        
        if ((root && root.children.length > 0) || reactCheckCount >= maxReactChecks) {
            if (root && root.children.length > 0) {
                scheduleSend();
            }
            clearInterval(checkReactReady);
        }
    }, 100);

    // Listen for parent initialization message
    window.addEventListener('message', function (event) {
        if (!event || !event.data) return;
        if (event.data.type !== 'COMBINATIONS_IFRAME_PARENT_INIT') return;
        parentOrigin = event.origin;
        try {
            window.parent && window.parent.postMessage({ type: 'COMBINATIONS_IFRAME_READY' }, parentOrigin);
        } catch (e) {
            console.error('Failed to send iframe ready message:', e);
        }
        scheduleSend();
    });
});
