import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

function togglePricing() {
    const isYearly = document.getElementById('togglePrice').checked;

    document.querySelectorAll('.price-month').forEach(el => el.classList.toggle('hidden', isYearly));
    document.querySelectorAll('.price-year').forEach(el => el.classList.toggle('hidden', !isYearly));
    document.querySelectorAll('.btn-basic-mensual').forEach(el => el.classList.toggle('hidden', isYearly));
    document.querySelectorAll('.btn-basic-anual').forEach(el => el.classList.toggle('hidden', !isYearly));
    document.querySelectorAll('.btn-pro-mensual').forEach(el => el.classList.toggle('hidden', isYearly));
    document.querySelectorAll('.btn-pro-anual').forEach(el => el.classList.toggle('hidden', !isYearly));
}
