import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    initNavbar();
    initMobileMenu();
    initReveal();
    initWishlistButtons();
});

function initNavbar() {
    const nav = document.querySelector('[data-site-nav]');
    if (!nav) return;

    const onScroll = () => {
        nav.classList.toggle('is-scrolled', window.scrollY > 24);
    };

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}

function initMobileMenu() {
    const toggle = document.querySelector('[data-mobile-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');
    const overlay = document.querySelector('[data-mobile-overlay]');

    if (!toggle || !menu) return;

    const close = () => {
        menu.classList.add('translate-x-full');
        menu.classList.remove('translate-x-0');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('overflow-hidden');
        overlay?.classList.add('hidden');
    };

    const open = () => {
        menu.classList.remove('translate-x-full');
        menu.classList.add('translate-x-0');
        toggle.setAttribute('aria-expanded', 'true');
        document.body.classList.add('overflow-hidden');
        overlay?.classList.remove('hidden');
    };

    toggle.addEventListener('click', () => {
        const isOpen = toggle.getAttribute('aria-expanded') === 'true';
        isOpen ? close() : open();
    });

    overlay?.addEventListener('click', close);
    menu.querySelectorAll('a').forEach((link) => link.addEventListener('click', close));

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') close();
    });
}

function initReveal() {
    const items = document.querySelectorAll('.reveal');
    if (!items.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );

    items.forEach((el) => observer.observe(el));
}

function initWishlistButtons() {
    document.querySelectorAll('[data-wishlist]').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            btn.classList.toggle('text-gold-500');
            btn.classList.toggle('scale-110');
            const filled = btn.querySelector('[data-wishlist-filled]');
            const outline = btn.querySelector('[data-wishlist-outline]');
            filled?.classList.toggle('hidden');
            outline?.classList.toggle('hidden');
        });
    });
}
