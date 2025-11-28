// /js/main.js

document.addEventListener("DOMContentLoaded", () => {
  console.log("main.js läuft ✨");

  /* =========================================
     1) SCROLL-REVEAL (Intro etc.)
  ========================================== */
  const revealElements = document.querySelectorAll(".reveal-on-scroll");
  if (revealElements.length > 0) {
    const observer = new IntersectionObserver(
      (entries, obs) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            obs.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.2 }
    );

    revealElements.forEach((el) => observer.observe(el));
  }

  /* =========================================
     3) VEGAN-TOGGLE (Zutaten + Tipps)
  ========================================== */

  const toggle = document.querySelector(".ingredients-toggle");
  if (!toggle) {
    // keine Toggle-Leiste, also nichts zu tun
    return;
  }

  const normalList = document.querySelector(".ingredients-list--normal");
  const veganList  = document.querySelector(".ingredients-list--vegan");

  const tipsSection = document.querySelector(".recipe-tips");
  const tipsNormal  = document.querySelector(".tips-variant--normal");
  const tipsVegan   = document.querySelector(".tips-variant--vegan");

  const buttons = toggle.querySelectorAll(".toggle-btn");

  const hasTipsNormal = !!tipsNormal;
  const hasTipsVegan  = !!tipsVegan;

  // --- Initial-Zustand: Standard aktiv ---

  if (normalList) normalList.style.display = "grid";
  if (veganList)  veganList.style.display  = "none";

  if (hasTipsNormal && tipsNormal) {
    tipsNormal.style.display = "grid";
  }
  if (hasTipsVegan && tipsVegan) {
    tipsVegan.style.display = "none";
  }

  // Spezialfall: es gibt nur vegane Tipps → Sektion erst mal verstecken
  if (!hasTipsNormal && hasTipsVegan && tipsSection) {
    tipsSection.style.display = "none";
  }

  // --- Klick-Logik für Buttons ---

  buttons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const target   = btn.dataset.target;
      const showVegan = target === "vegan";

      // Button-Styling
      buttons.forEach((b) => b.classList.remove("is-active"));
      btn.classList.add("is-active");

      // Zutaten umschalten
      if (normalList) normalList.style.display = showVegan ? "none" : "grid";
      if (veganList)  veganList.style.display  = showVegan ? "grid" : "none";

      // Tipps-Logik
      if (!tipsSection) return;

      if (hasTipsNormal && hasTipsVegan) {
        // beide Varianten vorhanden
        tipsSection.style.display = "block";
        if (tipsNormal) tipsNormal.style.display = showVegan ? "none" : "grid";
        if (tipsVegan)  tipsVegan.style.display  = showVegan ? "grid" : "none";

      } else if (hasTipsNormal && !hasTipsVegan) {
        // nur Standard-Tipps vorhanden
        tipsSection.style.display = showVegan ? "none" : "block";
        if (tipsNormal) tipsNormal.style.display = showVegan ? "none" : "grid";

      } else if (!hasTipsNormal && hasTipsVegan) {
        // nur vegane Tipps vorhanden
        tipsSection.style.display = showVegan ? "block" : "none";
        if (tipsVegan) tipsVegan.style.display = showVegan ? "grid" : "none";
      }
    });
  });
});
