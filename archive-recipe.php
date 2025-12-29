<?php
/**
 * Archive Template – Recipe Archive (Alle Rezepte)
 * URL: /rezepte/
 * Mit Vegan-Modus URL-Parameter Support
 */

// Hilfsfunktion: Extrahiert String aus Array oder gibt String zurück
function get_string_value_archive($value) {
  if (empty($value)) {
    return '';
  }
  
  if (is_array($value)) {
    if (isset($value[0])) {
      $first = $value[0];
      if (is_array($first)) {
        return $first['label'] ?? $first['value'] ?? '';
      }
      return $first;
    }
    return $value['label'] ?? $value['value'] ?? '';
  }
  
  return $value;
}

// Aktuellen Modus aus URL holen
$current_mode = isset($_GET['mode']) && $_GET['mode'] === 'vegan' ? 'vegan' : 'basic';

get_header();
?>

<main class="recipes-archive">

  <!-- ===== HERO SECTION ===== -->
  <section class="recipes-hero">
    <div class="recipes-hero-inner">
      
      <h1 class="recipes-hero-title">ALLE REZEPTE</h1>

      <!-- Basic/Vegan Toggle mit aktuellem Modus -->
      <div class="recipes-toggle">
        <button class="recipes-toggle-btn <?php echo $current_mode === 'basic' ? 'is-active' : ''; ?>" data-mode="basic">Basic</button>
        <button class="recipes-toggle-btn <?php echo $current_mode === 'vegan' ? 'is-active' : ''; ?>" data-mode="vegan">Vegan</button>
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
          // hero_bild nutzen
          $image = get_field('hero_bild');
          
          // Fallback: Beitragsbild
          if ( !$image && has_post_thumbnail() ) {
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $image_alt = get_the_title();
          } elseif ( $image ) {
            $image_url = $image['url'];
            $image_alt = $image['alt'] ?: get_the_title();
          } else {
            continue;
          }

          // Kategorie holen
          $category_raw = get_field('kategorie');
          $category = get_string_value_archive($category_raw);
          
          if (empty($category)) {
            $category = 'divers';
          }
          
          $category = strtolower($category);
          
          // Rezept-Link mit mode-Parameter
          $recipe_url = get_permalink();
          if ($current_mode === 'vegan') {
            $recipe_url = add_query_arg('mode', 'vegan', $recipe_url);
          }
          ?>

          <div class="recipe-grid-item" data-category="<?php echo esc_attr($category); ?>">
            <a href="<?php echo esc_url($recipe_url); ?>" class="recipe-grid-link">
              <img
                src="<?php echo esc_url($image_url); ?>"
                alt="<?php echo esc_attr($image_alt); ?>"
              >
            </a>
            <h3 class="recipe-grid-title">
              <a href="<?php echo esc_url($recipe_url); ?>">
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