import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

gsap.registerPlugin(ScrollTrigger);

let lenis = null;

export function initSmoothScroll() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    lenis = new Lenis({
        duration: 1.15,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        smoothWheel: true,
    });

    lenis.on('scroll', ScrollTrigger.update);

    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });
    gsap.ticker.lagSmoothing(0);

    window.lenis = lenis;
}

export function scrollToId(selector, offset = -80) {
    if (!lenis) {
        const el = document.querySelector(selector);
        if (el) el.scrollIntoView({ behavior: 'smooth' });
        return;
    }
    lenis.scrollTo(selector, { offset });
}

function initReveal() {
    const items = document.querySelectorAll('[data-reveal]');

    items.forEach((el) => {
        gsap.fromTo(
            el,
            { opacity: 0, y: 28 },
            {
                opacity: 1,
                y: 0,
                duration: 0.7,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: el,
                    // Reveal as soon as the element enters the viewport. The old
                    // "top 88%" threshold left above-the-fold hero CTAs hidden
                    // on shorter screens (viewport-height dependent).
                    start: 'top bottom',
                    toggleActions: 'play none none reverse',
                },
            }
        );
    });
}

function initCounters() {
    const counters = document.querySelectorAll('[data-counter]');

    counters.forEach((el) => {
        const target = parseFloat(el.dataset.counter);
        const decimals = el.dataset.decimals ? parseInt(el.dataset.decimals, 10) : 0;
        const suffix = el.dataset.suffix || '';

        gsap.fromTo(
            el,
            { innerText: 0 },
            {
                innerText: target,
                duration: 2,
                ease: 'power1.out',
                snap: { innerText: 1 },
                scrollTrigger: {
                    trigger: el,
                    start: 'top 90%',
                },
                onUpdate: function () {
                    const val = Number(this.targets()[0].innerText).toLocaleString('en-US', {
                        minimumFractionDigits: decimals,
                        maximumFractionDigits: decimals,
                    });
                    el.textContent = val + suffix;
                },
            }
        );
    });
}

function initMarquee() {
    const tracks = document.querySelectorAll('[data-marquee]');
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    tracks.forEach((track) => {
        const content = track.firstElementChild;
        if (!content) return;
        track.appendChild(content.cloneNode(true));
    });
}

export function initAnimations() {
    initReveal();
    initCounters();
    initMarquee();
}
