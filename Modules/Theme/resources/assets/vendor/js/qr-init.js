import { mountQR } from './qr-styling';

document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('qr');
  if (!el) return;
  mountQR('qr', el.dataset.url, el.dataset.logo);
});
