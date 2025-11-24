<?php
/**
 * Front Page Template – Bake & Swap
 */
get_header();
?>

<main class="home">

  <!-- HERO -->
<section class="hero">
  <div class="hero-inner">

    <div class="hero-logo-img">
      <img 
        src="<?php echo get_template_directory_uri(); ?>/assets/img/bake&swap.png" 
        alt="Bake & Swap Logo"
      >
    </div>
  </div>

    <!-- Dekobilder (später mit deinen freigestellten PNGs ersetzen) -->
    <img
      class="hero-deco hero-deco-cookie"
      src="<?php echo get_template_directory_uri(); ?>/assets/img/cookie.png"
      alt="Chocolate Chip Cookie">

    <img
      class="hero-deco hero-deco-pancake"
      src="<?php echo get_template_directory_uri(); ?>/assets/img/pancake.png"
      alt="Pancake Stapel">

    <button class="scroll-down" type="button" aria-label="Nach unten scrollen">
      <span>↓</span>
    </button>
  </section>


  <!-- INTRO -->
  <section class="intro" id="intro">
    <div class="intro-inner">
      <p>
        Bake &amp; Swap ist kein gewöhnliches Rezeptportal. Hier geht es um die Freude am Backen,
        die Liebe zum Design und den spielerischen Umgang mit Zutaten. Jedes Rezept lässt sich
        mit einem Klick in eine vegane Version verwandeln – die Zutaten, Mengen und Tipps passen
        sich automatisch an.
      </p>
    </div>
  </section>


  <!-- LIEBLINGSREZEPTE -->
  <section class="favorites">
    <div class="favorites-inner">

      <header class="favorites-header">
        <h2 class="favorites-title">lieblings-<br>rezepte</h2>
      </header>

      <?php
      // Query: nur Rezepte mit Startseite-Häkchen
      $fav_query = new WP_Query([
        'post_type'      => 'recipe',
        'posts_per_page' => 3,            // max. 3
        'meta_query'     => [
          [
            'key'   => 'startseite',      // ACF-Feldname
            'value' => '1',
          ]
        ],
      ]);
      ?>

      <?php if ( $fav_query->have_posts() ) : ?>
        <div class="fav-layout">
          <?php
          $index = 0;
          while ( $fav_query->have_posts() ) :
            $fav_query->the_post();
            $index++;

            // ACF Bild holen
            $image = get_field('startseite_bild');
            if ( ! $image ) {
              // Fallback: Beitragsbild
              if ( has_post_thumbnail() ) {
                $image_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                $image_alt = get_the_title();
              } else {
                continue; // nichts anzeigen, wenn gar kein Bild
              }
            } else {
              $image_url = $image['url'];
              $image_alt = $image['alt'] ?: get_the_title();
            }

            // Position-Klasse je nach Index (1,2,3) -> fürs Layout
            $pos_class = 'fav-item-' . $index;
          ?>
            <a class="fav-item <?php echo esc_attr( $pos_class ); ?>"
               href="<?php the_permalink(); ?>">
              <img src="<?php echo esc_url( $image_url ); ?>"
                   alt="<?php echo esc_attr( $image_alt ); ?>">
            </a>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      <?php else : ?>
        <p>Lege in den Rezepten welche mit „Startseite“-Häkchen fest.</p>
      <?php endif; ?>

      <div class="favorites-cta">
        <a class="btn" href="<?php echo esc_url( site_url('/rezepte/') ); ?>">
          Alle Rezepte ansehen
        </a>
      </div>

    </div>
  </section>


</main>

<?php get_footer(); ?>
