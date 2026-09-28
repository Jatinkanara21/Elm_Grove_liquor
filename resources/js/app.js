import './catalog';

const AGE_KEY = 'egl_age_verified';
const FOCUSABLE =
    'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

/** Keep Tab / Shift+Tab inside a container. */
function trapFocus(container, event) {
    if (event.key !== 'Tab') return;
    const items = [...container.querySelectorAll(FOCUSABLE)].filter((el) => el.offsetParent !== null);
    if (!items.length) return;
    const first = items[0];
    const last = items[items.length - 1];
    if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
    }
}

/* ---------------- Age verification ---------------- */
function initAgeGate() {
    const root = document.documentElement;
    const gate = document.getElementById('age-gate');
    const site = document.getElementById('site');
    if (!gate || root.classList.contains('age-ok')) return;

    const yes = document.getElementById('age-yes');
    const exit = document.getElementById('age-exit');
    const prompt = document.getElementById('age-gate-prompt');
    const denied = document.getElementById('age-gate-denied');

    if (site) site.inert = true;
    yes?.focus();

    const onKey = (e) => trapFocus(gate, e);
    gate.addEventListener('keydown', onKey);

    yes?.addEventListener('click', () => {
        try {
            localStorage.setItem(AGE_KEY, '1');
        } catch (e) {
            /* storage blocked: the gate will simply show again next visit */
        }
        root.classList.add('age-ok');
        if (site) site.inert = false;
        gate.removeEventListener('keydown', onKey);
        document.getElementById('main')?.focus();
    });

    exit?.addEventListener('click', () => {
        prompt.hidden = true;
        denied.hidden = false;
        denied.focus();
    });
}

/* ---------------- Mobile menu ---------------- */
function initMobileMenu() {
    const root = document.documentElement;
    const menu = document.getElementById('mobile-menu');
    const openBtn = document.getElementById('menu-open');
    const closeBtn = document.getElementById('menu-close');
    if (!menu || !openBtn) return;

    const panel = menu.querySelector('.mobile-menu__panel');

    const open = () => {
        menu.classList.add('is-open');
        menu.setAttribute('aria-hidden', 'false');
        openBtn.setAttribute('aria-expanded', 'true');
        root.classList.add('menu-open');
        closeBtn?.focus();
    };

    const close = () => {
        menu.classList.remove('is-open');
        menu.setAttribute('aria-hidden', 'true');
        openBtn.setAttribute('aria-expanded', 'false');
        root.classList.remove('menu-open');
        openBtn.focus();
    };

    openBtn.addEventListener('click', open);
    closeBtn?.addEventListener('click', close);
    menu.querySelectorAll('[data-menu-close]').forEach((el) => el.addEventListener('click', close));
    menu.querySelectorAll('a').forEach((a) =>
        a.addEventListener('click', () => {
            menu.classList.remove('is-open');
            root.classList.remove('menu-open');
        })
    );

    document.addEventListener('keydown', (e) => {
        if (!menu.classList.contains('is-open')) return;
        if (e.key === 'Escape') close();
        else trapFocus(panel, e);
    });

    window.matchMedia('(min-width: 1024px)').addEventListener('change', (e) => {
        if (e.matches && menu.classList.contains('is-open')) close();
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initAgeGate();
    initMobileMenu();
});

if (document.body.hasAttribute('data-admin')) {
    import('./admin');
}