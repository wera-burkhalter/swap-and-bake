// Smooth scroll vom Hero-Pfeil zur Intro-Section
document.querySelector('.scroll-down')?.addEventListener('click', () => {
  document.getElementById('intro')?.scrollIntoView({ behavior: 'smooth' });
});
