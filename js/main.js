/**
 * main.js - Bake & Swap
 * Kombiniert: Archive-Filter + Single-Recipe Toggle
 */

document.addEventListener("DOMContentLoaded", () => {
  console.log("main.js läuft ✨");

  /* =========================================
     1) SCROLL-REVEAL (Homepage Intro etc.)
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
     2) ARCHIVE PAGE: TOGGLE BASIC/VEGAN
  ========================================== */
  const archiveToggleBtns = document.querySelectorAll('.recipes-toggle-btn');
  
  if (archiveToggleBtns.length > 0) {
    archiveToggleBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        // Alle Buttons inaktiv
        archiveToggleBtns.forEach(b => b.classList.remove('is-active'));
        // Diesen Button aktiv
        this.classList.add('is-active');
        
        const mode = this.dataset.mode;
        console.log('Archive: Modus gewechselt zu:', mode);
        
        // TODO: Hier später AJAX oder Seiten-Reload für vegane Rezepte
      });
    });
  }

  /* =========================================
     3) ARCHIVE PAGE: FILTER NACH KATEGORIE
  ========================================== */
  const filterBtns = document.querySelectorAll('.filter-btn');
  const recipeItems = document.querySelectorAll('.recipe-grid-item');
  
  if (filterBtns.length > 0 && recipeItems.length > 0) {
    filterBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        // Alle Buttons inaktiv
        filterBtns.forEach(b => b.classList.remove('is-active'));
        // Diesen Button aktiv
        this.classList.add('is-active');
        
        const category = this.dataset.category;
        
        // Filter anwenden
        recipeItems.forEach(item => {
          const itemCategory = item.dataset.category;
          
          if (category === 'alle' || itemCategory === category) {
            item.style.display = 'block';
            // Fade-In Animation
            item.style.opacity = '0';
            setTimeout(() => {
              item.style.transition = 'opacity 0.3s ease';
              item.style.opacity = '1';
            }, 10);
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  }

  /* =========================================
     4) SINGLE RECIPE: VEGAN-TOGGLE (Zutaten + Tipps)
  ========================================== */
  const toggle = document.querySelector(".ingredients-toggle");
  if (!toggle) {
    // keine Toggle-Leiste auf dieser Seite
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

  // Spezialfall: nur vegane Tipps → Sektion verstecken
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
