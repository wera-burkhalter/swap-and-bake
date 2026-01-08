<?php
/**
 * Front Page Template – Bake & Swap
 * Homepage mit Hero, Intro (versetzt) und Lieblingsrezepten (Rechtecke)
 */
get_header();
?>

<main class="home">

  <!-- ===== HERO SECTION ===== -->
  <section class="hero">
    
    <!-- Hintergrundbild -->
    <img 
      src="<?php echo get_template_directory_uri(); ?>/assets/img/Croissants_Homepage.JPG" 
      alt="Croissants Hintergrund" 
      class="hero-bg-img"
    >

    <div class="hero-inner">

      <!-- Logo -->
      <div class="hero-logo-img">
        <img 
          src="<?php echo get_template_directory_uri(); ?>/assets/img/Logo_Home.png" 
          alt="Bake & Swap Logo"
        >
      </div>

    </div>

  </section>


  <!-- ===== INTRO + FAVORITES SECTION ===== -->
  <section class="intro-favorites reveal-on-scroll">
    <div class="intro-favorites-inner">

      <!-- Text versetzt in 2 Spalten -->
      <div class="intro-text-columns">
        
        <div class="intro-text-right">
          <p>
            Bake &amp; Swap ist kein gewöhnliches Rezeptportal. Hier geht es um die Freude am Backen,
            die Liebe zum Design und den spielerischen Umgang mit Zutaten.
          </p>
        </div>

        <div class="intro-text-left">
          <p>
            Jedes Rezept lässt sich mit einem Klick in eine vegane Version verwandeln, die Zutaten,
            Mengen und Tipps passen sich automatisch an.
          </p>
        </div>

      </div>

      <!-- Lieblingsrezepte -->
      <div class="favorites-content">

        <header class="favorites-header">
          <h2 class="favorites-title">Just a little something you might like</h2>
        </header>

        <?php
        // Query: nur Rezepte mit Startseite-Häkchen
        $fav_query = new WP_Query([
          'post_type'      => 'recipe',
          'posts_per_page' => 3,
          'meta_query'     => [
            [
              'key'   => 'startseite',
              'value' => '1',
            ]
          ],
        ]);
        ?>

        <?php if ( $fav_query->have_posts() ) : ?>
          <div class="fav-layout">
            <?php
            while ( $fav_query->have_posts() ) :
              $fav_query->the_post();

              // ACF-Bild holen
              $image = get_field('startseite_bild');
              if ( ! $image ) {
                // Fallback: Beitragsbild
                if ( has_post_thumbnail() ) {
                  $image_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                  $image_alt = get_the_title();
                } else {
                  continue;
                }
              } else {
                $image_url = $image['url'];
                $image_alt = $image['alt'] ?: get_the_title();
              }
            ?>
              <div class="fav-item">
                <a href="<?php the_permalink(); ?>" class="fav-item-link">
                  <img 
                    src="<?php echo esc_url( $image_url ); ?>"
                    alt="<?php echo esc_attr( $image_alt ); ?>"
                  >
                </a>
                <h3 class="fav-item-title">
                  <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                  </a>
                </h3>
              </div>
            <?php endwhile; wp_reset_postdata(); ?>
          </div>
        <?php else : ?>
          <p class="favorites-empty">Lege in den Rezepten welche mit „Startseite"-Häkchen fest.</p>
        <?php endif; ?>

        <div class="favorites-cta">
          <a class="btn btn-light" href="<?php echo esc_url( site_url('/rezepte/') ); ?>">
            alle Rezepte
          </a>
        </div>

      </div>

    </div>
  </section>

</main>

<?php get_footer(); ?>