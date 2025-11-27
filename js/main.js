document.addEventListener("DOMContentLoaded", () => {
  console.log("main.js läuft ✨");

  /* SCROLLYTELLING: Elemente beim Scrollen einblenden */

  const revealElements = document.querySelectorAll(".reveal-on-scroll");
  console.log("Reveal-Elemente gefunden:", revealElements.length);

  if (revealElements.length > 0) {
    const observer = new IntersectionObserver(
      (entries, obs) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            console.log("Element sichtbar:", entry.target);
            entry.target.classList.add("is-visible");
            obs.unobserve(entry.target); // nur einmal animieren
          }
        });
      },
      {
        threshold: 0.2,
      }
    );

    revealElements.forEach((el) => observer.observe(el));
  }

  /* Zutaten-Toggle (normal / vegan) */
  const toggle = document.querySelector(".ingredients-toggle");
  if (!toggle) return;

  const normalList = document.querySelector(".ingredients-list--normal");
  const veganList  = document.querySelector(".ingredients-list--vegan");
  const buttons    = toggle.querySelectorAll(".toggle-btn");

  if (veganList) veganList.style.display = "none";

  buttons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const target = btn.dataset.target;

      buttons.forEach((b) => b.classList.remove("is-active"));
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
