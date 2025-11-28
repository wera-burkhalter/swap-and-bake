<?php
/**
 * Archiv-Seite für Custom Post Type "recipe"
 * URL: /rezepte/
 */

get_header();
?>

<main class="recipes-archive">

  <!-- HERO: Streifen + Titel + Suche -->
  <section class="recipes-hero">
    <div class="recipes-hero-inner">

      <h1 class="recipes-hero-title">rezeptsammlung</h1>

      <!-- Ovale Suchleiste -->
      <form
        class="recipes-search-container"
        method="get"
        action="<?php echo esc_url( home_url( '/rezepte/' ) ); ?>"
      >
        <input
          type="search"
          name="s"
          class="recipes-search"
          placeholder="suchen..."
          value="<?php echo esc_attr( get_search_query() ); ?>"
        >
        <input type="hidden" name="post_type" value="recipe">
      </form>

      <!-- Falls du später Filter willst, könntest du hier noch eine Filter-Zeile einbauen -->

    </div>
  </section>

  <!-- GRID mit Rezept-Bildern -->
  <section class="recipes-grid">
    <?php if ( have_posts() ) : ?>

      <?php while ( have_posts() ) : the_post(); ?>

        <?php
        // Bild holen – zuerst ACF "startseite_bild", sonst Beitragsbild
        $image = get_field('startseite_bild');
        if ( !$image && has_post_thumbnail() ) {
          $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
          $image_alt = get_the_title();
        } elseif ( $image ) {
          $image_url = $image['url'];
          $image_alt = $image['alt'] ?: get_the_title();
        } else {
          // kein Bild → dieses Rezept überspringen
          continue;
        }
        ?>

        <a class="recipe-grid-item" href="<?php the_permalink(); ?>">
          <img
            src="<?php echo esc_url( $image_url ); ?>"
            alt="<?php echo esc_attr( $image_alt ); ?>"
          >
          <!-- KEIN Titel darunter, weil der im Bild steckt -->
        </a>

      <?php endwhile; ?>

    <?php else : ?>

      <p class="recipes-empty">Noch keine Rezepte vorhanden.</p>

    <?php endif; ?>
  </section>

  <!-- Pagination (falls du mehr als 10 Rezepte hast) -->
  <div class="recipes-pagination">
    <?php
    the_posts_pagination([
      'prev_text' => '&laquo;',
      'next_text' => '&raquo;',
    ]);
    ?>
  </div>

</main>

<?php get_footer(); ?>