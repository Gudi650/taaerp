<x-loading id="actionLoader" size="lg" color="brand" full-page="true" message="Please wait..." :show="false" />

<script>
    
    (function () {
        let pending = 0;

        window.showActionLoader = function (message) {
            const el = document.getElementById('actionLoader');
            const text = document.getElementById('actionLoaderText');
            if (text && message) text.textContent = message;
            if (!el) return;
            pending++;
            el.classList.remove('hidden');
            el.classList.add('flex');
        };

        window.hideActionLoader = function () {
            pending = Math.max(0, pending - 1);
            if (pending > 0) return;
            const el = document.getElementById('actionLoader');
            if (!el) return;
            el.classList.add('hidden');
            el.classList.remove('flex');
        };

        document.addEventListener('submit', function (e) {
            if (e.defaultPrevented || e.target?.dataset?.noLoader !== undefined) return;
            showActionLoader();
        });

        const origFetch = window.fetch.bind(window);
        window.fetch = function (input, init) {
            const method = String(init?.method || 'GET').toUpperCase();
            const wait = ['POST', 'PUT', 'PATCH', 'DELETE'].includes(method);
            if (wait) showActionLoader();
            return origFetch(input, init).finally(() => { if (wait) hideActionLoader(); });
        };
    })();

</script>
