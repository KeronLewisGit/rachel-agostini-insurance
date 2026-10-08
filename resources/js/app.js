import Alpine from 'alpinejs';
import { registerCalculators } from './calculators';

document.documentElement.classList.add('js');

registerCalculators(Alpine);

/**
 * Animated counter for the stats band.
 */
Alpine.data('countUp', (target, duration = 1400) => ({
    value: 0,
    start() {
        const begin = performance.now();
        const step = (now) => {
            const t = Math.min(1, (now - begin) / duration);
            const eased = 1 - Math.pow(1 - t, 3);
            this.value = Math.round(target * eased);
            if (t < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    },
}));

/**
 * "Where should I start?" quick recommender on the home page.
 */
Alpine.data('starter', (paths) => ({
    paths,
    picked: Object.keys(paths)[0],
    get current() {
        return this.paths[this.picked];
    },
}));

window.Alpine = Alpine;
Alpine.start();

/**
 * Scroll reveal.
 */
const revealTargets = document.querySelectorAll('[data-reveal]');
if ('IntersectionObserver' in window && revealTargets.length) {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { rootMargin: '0px 0px -10% 0px', threshold: 0.1 }
    );
    revealTargets.forEach((el) => observer.observe(el));
} else {
    revealTargets.forEach((el) => el.classList.add('is-visible'));
}
