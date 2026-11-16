const COLOR = '#19e0ff';
// Distance from the bottom edge to the waveform baseline. The "Scroll" hint is
// gone, so the pulse can sit closer to the bottom of the hero.
const BASELINE = 48;
const BASELINE_COMPACT = 40;
// Wave height. Shrinks automatically when the hero is short.
const AMPLITUDE = -64;
const AMPLITUDE_COMPACT = -40;
// Air between the CTA row and the top of the wave.
const AIR = 24;
const AIR_COMPACT = 16;
const MIN_AMPLITUDE = 14;
const COMPACT_WIDTH = 640;
const PULSES = 4;
const SPEED = 2.4;
// Trapezoid geometry, as fractions of one pulse period.
const EDGE = 0.035;     // sloped rise/fall (horizontal span)
const TOP = 0.20;       // flat top
const EDGE_MIN = 7;     // px floor, keeps room for corner rounding on narrow screens
const ROUND_RATIO = 0.11;
const ROUND_MAX = 10;

export function initPulse() {
    const canvas = document.getElementById('pulse');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    const hero = document.getElementById('hero');
    // The waveform is tied to the CTA row instead of the viewport bottom: a
    // browser with its own chrome (Yandex vs Chrome) gives a different viewport
    // height, which used to change the gap between the buttons and the pulse.
    const anchor = document.querySelector('[data-pulse-anchor]');
    let anchorBottom = null;

    let raf = 0;
    let offset = 0;
    let width = 0;
    let height = 0;
    let dpr = 1;

    const measureAnchor = () => {
        if (!anchor) return;

        const rect = anchor.getBoundingClientRect();
        if (!rect.height && !rect.width) return;

        anchorBottom = rect.bottom - canvas.getBoundingClientRect().top;
    };

    const resize = () => {
        dpr = Math.min(window.devicePixelRatio || 1, 2);
        width = canvas.clientWidth;
        height = canvas.clientHeight;
        canvas.width = Math.round(width * dpr);
        canvas.height = Math.round(height * dpr);
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        measureAnchor();
    };

    const draw = () => {
        ctx.clearRect(0, 0, width, height);

        if (width <= 0) return;

        // The wave stays at the bottom of the hero (like the original design) and
        // only flattens when the CTA row comes close to it, so it never runs
        // through the buttons. Because the hero height is stable (svh), Chrome
        // and Yandex now show the same picture.
        const compact = width < COMPACT_WIDTH;
        const clearance = compact ? BASELINE_COMPACT : BASELINE;
        const air = compact ? AIR_COMPACT : AIR;
        const maxAmplitude = compact ? AMPLITUDE_COMPACT : AMPLITUDE;

        let baseY = height - clearance;
        let amplitude = maxAmplitude;

        if (anchorBottom !== null) {
            const room = baseY - (anchorBottom + air);

            if (room < Math.abs(maxAmplitude)) {
                if (room >= MIN_AMPLITUDE) {
                    amplitude = -room;
                } else {
                    // Too little space under the buttons: lift the wave a bit
                    // instead of letting it collapse to a flat line.
                    baseY = Math.min(anchorBottom + air + MIN_AMPLITUDE, height - 8);
                    amplitude = -MIN_AMPLITUDE;
                }
            }
        }

        const period = width / PULSES;

        // Trapezoidal pulse with rounded corners: sloped edges, flat top,
        // sized relative to the visible width so exactly PULSES pulses fit.
        const edge = Math.max(period * EDGE, EDGE_MIN);
        const topWidth = period * TOP;
        const topY = baseY + amplitude;
        const riseLength = Math.hypot(edge, amplitude);
        const shift = ((offset % period) + period) % period;

        // Corner rounding length, scaled with the pulse height so both the
        // shoulders and the feet stay visibly curved without collapsing the
        // straight parts of the slope and the flat top.
        const radius = Math.max(
            2,
            Math.min(
                period * ROUND_RATIO,
                ROUND_MAX,
                Math.abs(amplitude) * 0.16,
                topWidth * 0.45,
                riseLength * 0.35,
            ),
        );

        // Unit directions of travel: up the rise, along the top, down the fall.
        const ux = edge / riseLength;
        const uy = amplitude / riseLength;

        // Curve through a corner: stop `radius` before it, then a quadratic
        // with the vertex itself as control point. Works for both convex
        // (top shoulders) and concave (bottom feet) corners.
        const corner = (cx, cy, ix, iy, ox, oy) => {
            ctx.lineTo(cx - ix * radius, cy - iy * radius);
            ctx.quadraticCurveTo(cx, cy, cx + ox * radius, cy + oy * radius);
        };

        ctx.strokeStyle = COLOR;
        ctx.lineWidth = 2;
        ctx.shadowColor = COLOR;
        ctx.shadowBlur = 12;
        ctx.lineJoin = 'round';
        ctx.lineCap = 'round';
        ctx.beginPath();

        let started = false;

        for (let i = -1; i <= PULSES + 1; i++) {
            const startX = i * period - shift;
            const p1x = startX;
            const p1y = baseY;
            const p2x = startX + edge;
            const p2y = topY;
            const p3x = p2x + topWidth;
            const p3y = topY;
            const p4x = p3x + edge;
            const p4y = baseY;

            if (!started) {
                ctx.moveTo(p1x - edge, baseY);
                started = true;
            }

            corner(p1x, p1y, 1, 0, ux, uy);        // foot: baseline -> rise
            corner(p2x, p2y, ux, uy, 1, 0);        // shoulder: rise -> top
            corner(p3x, p3y, 1, 0, ux, -uy);       // shoulder: top -> fall
            corner(p4x, p4y, ux, -uy, 1, 0);       // foot: fall -> baseline
        }

        ctx.stroke();
    };

    const frame = () => {
        draw();
        offset -= SPEED;
        raf = requestAnimationFrame(frame);
    };

    const start = () => {
        if (!raf) raf = requestAnimationFrame(frame);
    };

    const stop = () => {
        if (raf) cancelAnimationFrame(raf);
        raf = 0;
    };

    resize();

    // Web fonts and the hero logo finish loading after the first paint and can
    // change the content height, so re-measure and repaint once they are in.
    const refresh = () => {
        resize();
        if (!raf) draw();
    };

    if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(refresh);
    }
    window.addEventListener('load', refresh);

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        draw();
        window.addEventListener('resize', refresh);
        return;
    }

    if ('ResizeObserver' in window) {
        const observer = new ResizeObserver(() => resize());
        observer.observe(canvas);
        if (anchor) observer.observe(anchor);
    } else {
        window.addEventListener('resize', resize);
    }

    if (hero && 'IntersectionObserver' in window) {
        new IntersectionObserver((entries) => {
            entries.forEach((entry) => (entry.isIntersecting ? start() : stop()));
        }).observe(hero);
    } else {
        start();
    }

    document.addEventListener('visibilitychange', () => {
        document.hidden ? stop() : start();
    });
}
