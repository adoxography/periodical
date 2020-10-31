require('./bootstrap');
const Turbolinks = require('turbolinks');

Turbolinks.start();
Turbolinks.setProgressBarDelay(0);

document.addEventListener('turbolinks:load', () => {
  document.querySelectorAll('#main-content img').forEach(img => {
    img.classList.add('animate__animated', 'animate__fadeIn');
  });
});
