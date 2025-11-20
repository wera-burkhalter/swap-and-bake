// Smooth scroll vom Hero-Pfeil zur Intro-Section
document.querySelector('.scroll-down')?.addEventListener('click', () => {
  document.getElementById('intro')?.scrollIntoView({ behavior: 'smooth' });
});

document.addEventListener("DOMContentLoaded", () => {
  const toggle = document.querySelector(".ingredients-toggle");
  if (!toggle) return;

  const normalList = document.querySelector(".ingredients-list--normal");
  const veganList  = document.querySelector(".ingredients-list--vegan");
  const buttons    = toggle.querySelectorAll(".toggle-btn");

  if (veganList) veganList.style.display = "none";

  buttons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const target = btn.dataset.target;

      buttons.forEach(b => b.classList.remove("is-active"));
      btn.classList.add("is-active");

      if (target === "vegan") {
        if (normalList) normalList.style.display = "none";
        if (veganList) veganList.style.display = "block";
      } else {
        if (normalList) normalList.style.display = "block";
        if (veganList) veganList.style.display = "none";
      }
    });
  });
});
