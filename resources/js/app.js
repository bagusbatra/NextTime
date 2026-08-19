import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/**
 * Scroll reveal untuk listing admin — elemen dengan class "reveal" akan
 * muncul (fade + slide up) saat masuk viewport, dan kembali tersembunyi
 * saat keluar viewport, sehingga animasi terulang tiap kali discroll.
 */
function initScrollReveal() {
    const items = document.querySelectorAll('.reveal');

    if (! items.length || typeof IntersectionObserver === 'undefined') {
        items.forEach((item) => item.classList.add('reveal-visible'));

        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            entry.target.classList.toggle('reveal-visible', entry.isIntersecting);
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    items.forEach((item) => observer.observe(item));
}

document.addEventListener('DOMContentLoaded', initScrollReveal);
document.addEventListener('livewire:navigated', initScrollReveal);
