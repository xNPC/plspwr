const GLOW_RADIUS = 440;
const GLOW_PAD = 40;
const MAX_OPACITY = 0.22;
const FADE = 0.97;
const IDLE_FRAMES = 8;

export function initCursorGlow() {
    const canvas = document.getElementById('cursor-glow');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    let raf = 0;
    let width = 0;
    let height = 0;
    let dpr = 1;

    let mouseX = 0;
    let mouseY = 0;
    let idle = IDLE_FRAMES;
    let alpha = 0;
    let lastMoveTime = 0;

    const resize = () => {
        dpr = Math.min(window.devicePixelRatio || 1, 2);
        width = canvas.clientWidth;
        height = canvas.clientHeight;
        canvas.width = Math.round(width * dpr);
        canvas.height = Math.round(height * dpr);
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    };

    const onMove = (e) => {
        idle = IDLE_FRAMES;
        alpha = Math.min(alpha + 0.08, MAX_OPACITY);
        mouseX = e.clientX;
        mouseY = e.clientY;
        lastMoveTime = performance.now();
    };

    const draw = () => {
        ctx.clearRect(0, 0, width, height);

        if (alpha > 0.001) {
            const grad = ctx.createRadialGradient(
                mouseX,
                mouseY,
                0,
                mouseX,
                mouseY,
                GLOW_RADIUS
            );
            grad.addColorStop(0, `rgba(56, 189, 248, ${alpha * 0.5})`);
            grad.addColorStop(0.35, `rgba(56, 189, 248, ${alpha * 0.22})`);
            grad.addColorStop(0.7, `rgba(56, 189, 248, ${alpha * 0.08})`);
            grad.addColorStop(0.85, `rgba(56, 189, 248, ${alpha * 0.03})`);
            grad.addColorStop(1, 'rgba(56, 189, 248, 0)');

            const x = mouseX - GLOW_RADIUS - GLOW_PAD;
            const y = mouseY - GLOW_RADIUS - GLOW_PAD;
            const side = (GLOW_RADIUS + GLOW_PAD) * 2;

            ctx.fillStyle = grad;
            ctx.globalCompositeOperation = 'lighter';
            ctx.fillRect(x, y, side, side);
            ctx.globalCompositeOperation = 'source-over';
        }

        if (idle > 0) {
            idle -= 1;
        } else {
            alpha *= FADE;
            if (alpha < 0.001) alpha = 0;
        }

        raf = requestAnimationFrame(draw);
    };

    const start = () => {
        if (!raf) raf = requestAnimationFrame(draw);
    };

    const stop = () => {
        if (raf) cancelAnimationFrame(raf);
        raf = 0;
    };

    resize();

    if ('ResizeObserver' in window) {
        new ResizeObserver(() => resize()).observe(canvas);
    } else {
        window.addEventListener('resize', resize);
    }

    window.addEventListener('mousemove', onMove, { passive: true });

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) stop();
        else start();
    });

    start();
}
