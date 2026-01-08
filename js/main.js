/**
 * main.js - Bake & Swap
 * Mit Vegan-Modus Persistenz über localStorage (KEIN Page Reload)
 */

document.addEventListener("DOMContentLoaded", () => {
  console.log("main.js läuft ✨");

  /* =========================================
     1) SCROLL-REVEAL (Homepage)
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
     2) ARCHIVE PAGE: TOGGLE MIT localStorage
  ========================================== */
  const archiveToggleBtns = document.querySelectorAll('.recipes-toggle-btn');
  
  if (archiveToggleBtns.length > 0) {
    // Gespeicherten Modus laden
    const savedMode = localStorage.getItem('recipeMode') || 'basic';
    
    archiveToggleBtns.forEach(btn => {
      if (btn.dataset.mode === savedMode) {
        btn.classList.add('is-active');
      } else {
        btn.classList.remove('is-active');
      }
    });

    archiveToggleBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        const mode = this.dataset.mode;
        
        // Modus speichern
        localStorage.setItem('recipeMode', mode);
        
        // Button-Styling
        archiveToggleBtns.forEach(b => b.classList.remove('is-active'));
        this.classList.add('is-active');
        
        console.log('Archive: Modus gespeichert:', mode);
      });
    });

    document.querySelectorAll('.recipe-grid-link').forEach(link => {
      link.addEventListener('click', function(e) {
        const mode = localStorage.getItem('recipeMode');
        if (mode === 'vegan') {
          e.preventDefault();
          const url = new URL(this.href);
          url.searchParams.set('mode', 'vegan');
          window.location.href = url.toString();
        }
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
        // Button-Styling
        filterBtns.forEach(b => b.classList.remove('is-active'));
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
     4) SINGLE RECIPE: AUTO-SWITCH + TOGGLE
  ========================================== */
  const toggle = document.querySelector(".ingredients-toggle");
  if (!toggle) {
    return; 
  }

  // Elemente
  const normalList = document.querySelector(".ingredients-list--normal");
  const veganList  = document.querySelector(".ingredients-list--vegan");
  const normalSteps = document.querySelector(".steps-list--normal");
  const veganSteps  = document.querySelector(".steps-list--vegan");
  const tipsSection = document.querySelector(".recipe-tips");
  const tipsNormal  = document.querySelector(".tips-variant--normal");
  const tipsVegan   = document.querySelector(".tips-variant--vegan");
  const buttons = toggle.querySelectorAll(".toggle-btn");

  const hasTipsNormal = !!tipsNormal;
  const hasTipsVegan  = !!tipsVegan;
  const hasStepsNormal = !!normalSteps;
  const hasStepsVegan  = !!veganSteps;

  // Modus ermitteln: URL-Parameter hat Vorrang vor localStorage
  const urlParams = new URLSearchParams(window.location.search);
  const urlMode = urlParams.get('mode');
  const savedMode = localStorage.getItem('recipeMode');
  const startVegan = urlMode === 'vegan' || (!urlMode && savedMode === 'vegan');


  function setMode(showVegan) {
    // Zutaten
    if (normalList) normalList.style.display = showVegan ? "none" : "grid";
    if (veganList)  veganList.style.display  = showVegan ? "grid" : "none";

    // Zubereitung
    if (normalSteps) normalSteps.style.display = showVegan ? "none" : "grid";
    if (veganSteps)  veganSteps.style.display  = showVegan ? "grid" : "none";

    // Tipps
    if (tipsSection) {
      if (hasTipsNormal && hasTipsVegan) {
        tipsSection.style.display = "block";
        if (tipsNormal) tipsNormal.style.display = showVegan ? "none" : "block";
        if (tipsVegan)  tipsVegan.style.display  = showVegan ? "block" : "none";
      } else if (hasTipsNormal && !hasTipsVegan) {
        tipsSection.style.display = showVegan ? "none" : "block";
        if (tipsNormal) tipsNormal.style.display = showVegan ? "none" : "block";
      } else if (!hasTipsNormal && hasTipsVegan) {
        tipsSection.style.display = showVegan ? "block" : "none";
        if (tipsVegan) tipsVegan.style.display = showVegan ? "block" : "none";
      }
    }

    // Button-Styling
    buttons.forEach((btn) => {
      const btnMode = btn.dataset.target;
      if ((showVegan && btnMode === 'vegan') || (!showVegan && btnMode === 'normal')) {
        btn.classList.add('is-active');
      } else {
        btn.classList.remove('is-active');
      }
    });
  }

  // Initial setzen
  setMode(startVegan);

  // Button-Klick Handler
  buttons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const target = btn.dataset.target;
      const showVegan = target === "vegan";
      
      // Modus wechseln
      setMode(showVegan);
      
      // In localStorage speichern
      localStorage.setItem('recipeMode', showVegan ? 'vegan' : 'basic');
    });
  });
});