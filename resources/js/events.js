import './catalog';
import './events';

/* Countdown for events that have "Show countdown" enabled. */
function initCountdowns() {
    document.querySelectorAll('[data-countdown]').forEach((el) => {
        const target = new Date(`${el.dataset.countdown}T00:00:00`).getTime();
        const units = {
            days: el.querySelector('[data-unit="days"]'),
            hours: el.querySelector('[data-unit="hours"]'),
            minutes: el.querySelector('[data-unit="minutes"]'),
            seconds: el.querySelector('[data-unit="seconds"]'),
        };

        const tick = () => {
            const diff = Math.max(0, target - Date.now());
            units.days.textContent = Math.floor(diff / 86400000);
            units.hours.textContent = String(Math.floor((diff % 86400000) / 3600000)).padStart(2, '0');
            units.minutes.textContent = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
            units.seconds.textContent = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
            if (diff === 0) clearInterval(timer);
        };

        const timer = setInterval(tick, 1000);
        tick();
    });
}

document.addEventListener('DOMContentLoaded', initCountdowns);