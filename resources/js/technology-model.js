/*
 * Interactive 3D model for the Technology page.
 *
 * Geometry lives in `public/models/technology-model.bin` — a raw deflate stream
 * of (Uint16 positions, Uint32 indices). META describes how to decode it.
 * Three.js is loaded lazily so the rest of the site never pays for it.
 */

const MODEL_META = {
    vertices: 114239,
    triangles: 291439,
    scale: 420,
    min: [-0.1075761263240709, -0.49984076265655764, -0.28895028552270097],
};

const ACCENT = 0x38bdf8;
const VIOLET = 0x2563eb;
const MODEL_SCALE = 3.4;
const SPIN_SPEED = 0.12; // rad/s auto-rotation
const CAMERA_POSITION = [3.2, 1.4, 4.4];
const CAMERA_TARGET = [0, -0.05, 0];

export function initTechnologyModel() {
    const canvas = document.getElementById('technology-model');
    if (!canvas) return;

    const container = canvas.closest('[data-model-container]') ?? canvas.parentElement;
    const status = container?.querySelector('[data-model-status]');
    const poster = container?.querySelector('[data-model-poster]');

    const setStatus = (text) => {
        if (!status) return;

        if (text === null) {
            status.style.opacity = '0';
            window.setTimeout(() => status.remove(), 600);
            return;
        }

        status.textContent = text;
        status.style.opacity = '1';
    };

    const fail = (message) => {
        setStatus(message || canvas.dataset.error || 'Не удалось загрузить 3D-модель');
    };

    if (typeof DecompressionStream === 'undefined') {
        fail();
        return;
    }

    (async () => {
        let THREE;

        try {
            THREE = await import('three');
        } catch (error) {
            console.error('[technology-model]', error);
            fail();
            return;
        }

        let renderer;

        try {
            renderer = new THREE.WebGLRenderer({
                canvas,
                antialias: true,
                alpha: true,
                powerPreference: 'high-performance',
            });
        } catch (error) {
            console.error('[technology-model]', error);
            fail(canvas.dataset.webglError);
            return;
        }

        renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(32, 1, 0.1, 100);
        camera.position.set(...CAMERA_POSITION);
        camera.lookAt(...CAMERA_TARGET);

        scene.add(new THREE.HemisphereLight(0xbfd8ff, 0x101826, 0.9));

        const keyLight = new THREE.DirectionalLight(0xffffff, 1.1);
        keyLight.position.set(3, 5, 4);
        scene.add(keyLight);

        const rimLight = new THREE.DirectionalLight(ACCENT, 1.4);
        rimLight.position.set(-4, 2, -3);
        scene.add(rimLight);

        const fillLight = new THREE.PointLight(VIOLET, 1.2, 12);
        fillLight.position.set(2, -1, -3);
        scene.add(fillLight);

        const grid = new THREE.GridHelper(14, 40, ACCENT, 0x15314a);
        grid.position.y = -0.62;
        grid.material.transparent = true;
        grid.material.opacity = 0.28;
        scene.add(grid);

        const group = new THREE.Group();
        scene.add(group);

        const uniforms = { uT: { value: 0 } };

        const resize = () => {
            const width = canvas.clientWidth;
            const height = canvas.clientHeight;

            if (!width || !height) return;

            renderer.setSize(width, height, false);
            camera.aspect = width / height;
            camera.position.set(...CAMERA_POSITION);

            if (camera.aspect < 1) {
                camera.position.multiplyScalar(1.45);
            }

            camera.lookAt(...CAMERA_TARGET);
            camera.updateProjectionMatrix();
        };

        const render = () => renderer.render(scene, camera);

        // --- interaction -----------------------------------------------------
        let dragging = false;
        let lastX = 0;
        let spinVelocity = 0;

        const stopDrag = () => {
            dragging = false;
            canvas.classList.remove('is-dragging');
        };

        canvas.addEventListener('pointerdown', (event) => {
            dragging = true;
            lastX = event.clientX;
            spinVelocity = 0;
            canvas.classList.add('is-dragging');
            canvas.setPointerCapture?.(event.pointerId);
        });

        canvas.addEventListener('pointermove', (event) => {
            if (!dragging) return;

            const delta = event.clientX - lastX;
            lastX = event.clientX;
            spinVelocity = delta * 0.3;
            group.rotation.y += delta * 0.008;

            if (!raf) render();
        });

        canvas.addEventListener('pointerup', stopDrag);
        canvas.addEventListener('pointercancel', stopDrag);

        // --- animation -------------------------------------------------------
        const clock = new THREE.Clock();
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let elapsed = 0;
        let raf = 0;

        const frame = () => {
            const delta = Math.min(clock.getDelta(), 0.05);
            elapsed += delta;

            if (!dragging) {
                group.rotation.y += (SPIN_SPEED + spinVelocity) * delta;
                spinVelocity *= Math.pow(0.02, delta);
            }

            uniforms.uT.value = Math.sin(elapsed * 0.9) * 1.05;

            render();
            raf = requestAnimationFrame(frame);
        };

        const start = () => {
            if (reducedMotion || raf) return;
            clock.getDelta();
            raf = requestAnimationFrame(frame);
        };

        const stop = () => {
            if (!raf) return;
            cancelAnimationFrame(raf);
            raf = 0;
        };

        // --- model -----------------------------------------------------------
        try {
            const response = await fetch(canvas.dataset.model || '/models/technology-model.bin');

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const compressed = await response.arrayBuffer();
            const inflated = new Response(
                new Blob([compressed]).stream().pipeThrough(new DecompressionStream('deflate')),
            ).arrayBuffer();

            const buffer = await inflated;
            const { vertices, triangles, scale, min } = MODEL_META;

            const rawPositions = new Uint16Array(buffer, 0, vertices * 3);
            const indices = new Uint32Array(buffer.slice(vertices * 6, vertices * 6 + triangles * 12));

            const positions = new Float32Array(vertices * 3);
            for (let i = 0; i < vertices * 3; i++) {
                positions[i] = rawPositions[i] / scale + min[i % 3];
            }

            const geometry = new THREE.BufferGeometry();
            geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
            geometry.setIndex(new THREE.BufferAttribute(indices, 1));
            geometry.computeBoundingSphere();

            const material = new THREE.MeshStandardMaterial({
                color: 0xb9cbe0,
                metalness: 0.58,
                roughness: 0.34,
                flatShading: true,
                side: THREE.DoubleSide,
            });

            // Travelling energy band + edge glow, tinted with the site accent.
            material.onBeforeCompile = (shader) => {
                shader.uniforms.uT = uniforms.uT;

                shader.vertexShader = shader.vertexShader
                    .replace('#include <common>', '#include <common>\nvarying vec3 vWorldPosition;')
                    .replace(
                        '#include <begin_vertex>',
                        '#include <begin_vertex>\nvWorldPosition = (modelMatrix * vec4(position, 1.0)).xyz;',
                    );

                shader.fragmentShader = shader.fragmentShader
                    .replace('#include <common>', '#include <common>\nvarying vec3 vWorldPosition;\nuniform float uT;')
                    .replace(
                        '#include <dithering_fragment>',
                        `#include <dithering_fragment>
                        float bandDistance = abs(vWorldPosition.y - uT);
                        float band = (1.0 - smoothstep(0.0, 0.07, bandDistance)) * 1.4
                                   + (1.0 - smoothstep(0.0, 0.015, bandDistance)) * 2.0;
                        gl_FragColor.rgb += vec3(0.12, 0.72, 1.0) * band * 0.45;`,
                    );
            };

            const mesh = new THREE.Mesh(geometry, material);
            mesh.rotation.x = -Math.PI / 2;
            mesh.scale.setScalar(MODEL_SCALE);
            group.add(mesh);

            resize();
            render();
            setStatus(null);

            if (poster) {
                poster.style.opacity = '0';
            }

            container?.classList.add('is-ready');
        } catch (error) {
            console.error('[technology-model]', error);
            fail();
            return;
        }

        // Pause rendering when the block is off screen or the tab is hidden.
        const visibility = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => (entry.isIntersecting ? start() : stop()));
            },
            { rootMargin: '150px' },
        );

        visibility.observe(container ?? canvas);

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stop();
            } else if (container ? container.getBoundingClientRect().top < window.innerHeight : true) {
                start();
            }
        });

        if ('ResizeObserver' in window) {
            new ResizeObserver(() => {
                resize();
                if (!raf) render();
            }).observe(canvas);
        } else {
            window.addEventListener('resize', () => {
                resize();
                if (!raf) render();
            });
        }
    })();
}
