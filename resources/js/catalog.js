/* Product search/filter via fetch, plus a double-submit guard for forms. */

function initProductFilters() {
    const form = document.getElementById('product-filters');
    const results = document.getElementById('product-results');
    if (!form || !results) return;

    const clear = document.getElementById('clear-filters');
    let timer;
    let controller;

    const load = async (url) => {
        controller?.abort();
        controller = new AbortController();
        results.setAttribute('aria-busy', 'true');
        results.classList.add('opacity-50');

        try {
            const res = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
                signal: controller.signal,
            });
            if (!res.ok) throw new Error('Request failed');
            const data = await res.json();
            results.innerHTML = data.html;
            history.replaceState(null, '', url);
        } catch (e) {
            if (e.name !== 'AbortError') {
                results.innerHTML =
                    '<p class="rounded-2xl bg-white/70 p-8 text-center text-ink/70">Something went wrong. Please try again.</p>';
            }
        } finally {
            results.removeAttribute('aria-busy');
            results.classList.remove('opacity-50');
        }
    };

    const urlFromForm = () => {
        const params = new URLSearchParams(new FormData(form));
        [...params].forEach(([key, value]) => {
            if (!value) params.delete(key);
        });
        const query = params.toString();
        return form.action + (query ? `?${query}` : '');
    };

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        load(urlFromForm());
    });

    form.addEventListener('input', (e) => {
        if (e.target.type !== 'search') return;
        clearTimeout(timer);
        timer = setTimeout(() => load(urlFromForm()), 300);
    });

    form.addEventListener('change', (e) => {
        if (e.target.tagName === 'SELECT') load(urlFromForm());
    });

    clear?.addEventListener('click', (e) => {
        e.preventDefault();
        form.querySelectorAll('input[type="search"], select').forEach((el) => (el.value = ''));
        load(form.action);
    });

    results.addEventListener('click', (e) => {
        const link = e.target.closest('a[href*="page="]');
        if (!link) return;
        e.preventDefault();
        load(link.href);
        results.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
}

function initFormGuards() {
    document.querySelectorAll('form[data-once]').forEach((form) => {
        form.addEventListener('submit', () => {
            const btn = form.querySelector('[type="submit"]');
            if (!btn) return;
            btn.dataset.label = btn.textContent;
            btn.textContent = btn.dataset.loading || 'Submitting...';
            btn.disabled = true;
        });
    });

    // Restore buttons if the browser brings the page back from its back/forward cache.
    window.addEventListener('pageshow', (e) => {
        if (!e.persisted) return;
        document.querySelectorAll('form[data-once] [type="submit"]').forEach((btn) => {
            btn.disabled = false;
            if (btn.dataset.label) btn.textContent = btn.dataset.label;
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initProductFilters();
    initFormGuards();
});