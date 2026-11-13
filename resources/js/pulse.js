const COLOR = '#19e0ff';
const BASELINE = 110;
const BASELINE_COMPACT = 102;
const AMPLITUDE = -64;
const AMPLITUDE_COMPACT = -40;
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
    let raf = 0;
    let offset = 0;
    let width = 0;
    let height = 0;
    let dpr = 1;

    const resize = () => {
        dpr = Math.min(window.devicePixelRatio || 1, 2);
        width = canvas.clientWidth;
        height = canvas.clientHeight;
        canvas.width = Math.round(width * dpr);
        canvas.height = Math.round(height * dpr);
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    };

    const draw = () => {
        ctx.clearRect(0, 0, width, height);

        if (width <= 0) return;

        // Keep the baseline above the "Scroll" hint. On compact screens the
        // CTA buttons sit close to the bottom, so the pulse is shorter there.
        const compact = width < COMPACT_WIDTH;
        const fold = Math.min(height, window.innerHeight || height);
        const baseY = fold - (compact ? BASELINE_COMPACT : BASELINE);
        const amplitude = compact ? AMPLITUDE_COMPACT : AMPLITUDE;
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

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        draw();
        window.addEventListener('resize', () => { resize(); draw(); });
        return;
    }

    if ('ResizeObserver' in window) {
        new ResizeObserver(() => resize()).observe(canvas);
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
