export function initHeader() {
    const header = document.getElementById('site-header');
    const heroLogo = document.getElementById('hero-logo');
    const headerLogo = document.getElementById('header-logo');
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileBackdrop = document.getElementById('mobile-menu-backdrop');
    const mobileClose = document.getElementById('mobile-menu-close');

    const onScroll = () => {
        if (!header) return;
        if (window.scrollY > 40) {
            header.classList.add('glass', 'backdrop-blur-md', 'shadow-lg', 'shadow-ink-950/40');
            header.classList.remove('border-transparent');
            if (heroLogo) {
                heroLogo.classList.add('opacity-0', '-translate-y-6', 'pointer-events-none');
            }
            if (headerLogo && heroLogo) {
                headerLogo.classList.remove('lg:opacity-0', 'lg:invisible');
            }
        } else {
            header.classList.remove('glass', 'backdrop-blur-md', 'shadow-lg', 'shadow-ink-950/40');
            header.classList.add('border-white/5');
            if (heroLogo) {
                heroLogo.classList.remove('opacity-0', '-translate-y-6', 'pointer-events-none');
            }
            if (headerLogo && heroLogo) {
                headerLogo.classList.add('lg:opacity-0', 'lg:invisible');
            }
        }
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    // Pause hero background animations while scrolling or while the section
    // is off-screen, so scrolling stays smooth (SMIL sparks + SVG effects are
    // main-thread heavy).
    const heroSection = document.getElementById('hero');
    if (heroSection) {
        const fonSvg = heroSection.querySelector('svg.hero-fon');
        let heroVisible = false;
        let isScrolling = false;
        let resumeTimer = null;

        const setAnimations = (running) => {
            heroSection.classList.toggle('hero-anim-paused', !running);
            if (!fonSvg) return;
            if (running) {
                fonSvg.unpauseAnimations();
            } else {
                fonSvg.pauseAnimations();
            }
        };

        const applyState = () => setAnimations(heroVisible && !isScrolling);

        const updateHeroVisible = () => {
            const rect = heroSection.getBoundingClientRect();
            heroVisible = rect.bottom > -200 && rect.top < window.innerHeight + 200;
        };

        const noteScroll = () => {
            if (!('IntersectionObserver' in window)) updateHeroVisible();
            isScrolling = true;
            applyState();
            if (resumeTimer) window.clearTimeout(resumeTimer);
            resumeTimer = window.setTimeout(() => {
                isScrolling = false;
                applyState();
            }, 160);
        };

        if ('IntersectionObserver' in window) {
            const io = new IntersectionObserver((entries) => {
                for (const entry of entries) {
                    heroVisible = entry.isIntersecting;
                    applyState();
                }
            }, { rootMargin: '200px 0px' });
            io.observe(heroSection);
        } else {
            updateHeroVisible();
        }

        window.addEventListener('scroll', noteScroll, { passive: true });
        applyState();
    }

    const openMobile = () => {
        if (!mobileMenu) return;
        mobileMenu.classList.remove('invisible', 'opacity-0');
        mobileMenu.querySelector('div.absolute.right-0')?.classList.remove('translate-x-full');
        document.body.classList.add('overflow-hidden');
    };
    const closeMobile = () => {
        if (!mobileMenu) return;
        mobileMenu.classList.add('opacity-0');
        mobileMenu.querySelector('div.absolute.right-0')?.classList.add('translate-x-full');
        document.body.classList.remove('overflow-hidden');
        window.setTimeout(() => {
            if (mobileMenu.classList.contains('opacity-0')) {
                mobileMenu.classList.add('invisible');
            }
        }, 300);
    };

    mobileBtn?.addEventListener('click', openMobile);
    mobileClose?.addEventListener('click', closeMobile);
    mobileBackdrop?.addEventListener('click', closeMobile);

    // Re-flow menu items on resize.
    if (mobileMenu) {
        const dismissOnResize = () => {
            if (window.innerWidth >= 1024) closeMobile();
        };
        window.addEventListener('resize', dismissOnResize);
    }
}
