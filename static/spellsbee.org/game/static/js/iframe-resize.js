document.addEventListener('DOMContentLoaded', function () {
    // Child iframe: report content height to parent so parent can auto-resize the iframe.
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

    function sendHeight() {
        try {
            const root = document.getElementById('root');
            let h = 0;

            if (root) {
                h = Math.max(root.scrollHeight || 0, root.offsetHeight || 0);
            }

            h = Math.max(
                h,
                document.documentElement.scrollHeight || 0,
                document.body.scrollHeight || 0
            );

            if (!window.parent) return;
            if (!parentOrigin) return;

            window.parent.postMessage(
                {
                    type: 'COMBINATIONS_IFRAME_HEIGHT',
                    height: h
                },
                parentOrigin
            );
        } catch (e) {}
    }

    if (typeof ResizeObserver === 'function') {
        try {
            const ro = new ResizeObserver(function () { scheduleSend(); });
            ro.observe(document.documentElement);
            const rootEl = document.getElementById('root');
            if (rootEl) ro.observe(rootEl);
        } catch (e) {}
    }

    try {
        const moTarget = document.getElementById('root') || document.body;
        if (moTarget && typeof MutationObserver === 'function') {
            const mo = new MutationObserver(function () { scheduleSend(); });
            mo.observe(moTarget, { subtree: true, childList: true, attributes: true, characterData: true });
        }
    } catch (e) {}

    window.addEventListener('load', function () {
        scheduleSend();
        setTimeout(scheduleSend, 200);
        setTimeout(scheduleSend, 800);
    });

    window.addEventListener('message', function (event) {
        if (!event || !event.data) return;
        if (event.data.type !== 'COMBINATIONS_IFRAME_PARENT_INIT') return;

        parentOrigin = event.origin;

        try {
            window.parent && window.parent.postMessage({ type: 'COMBINATIONS_IFRAME_READY' }, parentOrigin);
        } catch (e) {}

        scheduleSend();
    });
});
