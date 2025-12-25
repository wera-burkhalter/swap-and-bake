<?php
/**
 * Archive Template – Recipe Archive (Alle Rezepte)
 * URL: /rezepte/
 * Nutzt ACF-Feld "hero_bild" für die Rezeptbilder
 */
get_header();
?>

<main class="recipes-archive">

  <!-- ===== HERO SECTION ===== -->
  <section class="recipes-hero">
    <div class="recipes-hero-inner">
      
      <h1 class="recipes-hero-title">ALLE REZEPTE</h1>

      <!-- Basic/Vegan Toggle -->
      <div class="recipes-toggle">
        <button class="recipes-toggle-btn is-active" data-mode="basic">Basic</button>
        <button class="recipes-toggle-btn" data-mode="vegan">Vegan</button>
      </div>

      <!-- Filter Buttons -->
      <div class="recipes-filters">
        <button class="filter-btn is-active" data-category="alle">Alle</button>
        <button class="filter-btn" data-category="cookies">Cookies</button>
        <button class="filter-btn" data-category="kuchen">Kuchen</button>
        <button class="filter-btn" data-category="divers">Divers</button>
      </div>

    </div>
  </section>

  <!-- ===== REZEPT GRID ===== -->
  <section class="recipes-grid-section">
    <div class="recipes-grid">
      
      <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

          <?php
          // WICHTIG: Nutze ACF-Feld "hero_bild" (nicht "startseite_bild")
          $image = get_field('hero_bild');
          
          // Fallback: Beitragsbild
          if ( !$image && has_post_thumbnail() ) {
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $image_alt = get_the_title();
          } elseif ( $image ) {
            $image_url = $image['url'];
            $image_alt = $image['alt'] ?: get_the_title();
          } else {
            // Kein Bild vorhanden - überspringen
            continue;
          }

          // Kategorie holen (falls du ein ACF-Feld hast)
          $category = get_field('kategorie') ?: 'divers';
          ?>

          <div class="recipe-grid-item" data-category="<?php echo esc_attr( strtolower($category) ); ?>">
            <a href="<?php the_permalink(); ?>" class="recipe-grid-link">
              <img
                src="<?php echo esc_url( $image_url ); ?>"
                alt="<?php echo esc_attr( $image_alt ); ?>"
              >
            </a>
            <h3 class="recipe-grid-title">
              <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
              </a>
            </h3>
          </div>

        <?php endwhile; ?>

      <?php else : ?>

        <p class="recipes-empty">Noch keine Rezepte vorhanden.</p>

      <?php endif; ?>

    </div>
  </section>

</main>

<?php get_footer(); ?>