import './bootstrap';
import { initSmoothScroll, initAnimations } from './animations';
import { initHeader } from './header';
import { initPulse } from './pulse';
import { initCursorGlow } from './cursor-glow';
import { initTechnologyModel } from './technology-model';

document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    initSmoothScroll();
    initAnimations();
    initPulse();
    initCursorGlow();
    initTechnologyModel();
});
