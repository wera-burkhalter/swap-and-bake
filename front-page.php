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

    <!-- Dekobilder -->
    <img
      class="hero-deco hero-deco-cookie"
      src="<?php echo get_template_directory_uri(); ?>/assets/img/cookie.png"
      alt="Chocolate Chip Cookie">

    <img
      class="hero-deco hero-deco-pancake"
      src="<?php echo get_template_directory_uri(); ?>/assets/img/pancake.png"
      alt="Pancake Stapel">

  </section>


  <!-- INTRO -->
  <section class="intro reveal-on-scroll" id="intro">
    <div class="intro-inner">
      <p>
        Bake &amp; Swap ist kein gewöhnliches Rezeptportal. Hier geht es um die Freude am Backen,
        die Liebe zum Design und den spielerischen Umgang mit Zutaten. Jedes Rezept lässt sich
        mit einem Klick in eine vegane Version verwandeln, die Zutaten, Mengen und Tipps passen
        sich automatisch an.
      </p>
    </div>
  </section>


  <!-- LIEBLINGSREZEPTE -->
  <section class="favorites">
    <div class="favorites-inner reveal-on-scroll">

      <header class="favorites-header">
        <h2 class="favorites-title">lieblingsrezepte</h2>
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
                continue; // nichts anzeigen, wenn gar kein Bild
              }
            } else {
              $image_url = $image['url'];
              $image_alt = $image['alt'] ?: get_the_title();
            }
          ?>
            <a class="fav-item" href="<?php the_permalink(); ?>">
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
          alle Rezepte
        </a>
      </div>

    </div>
  </section>

</main>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      console.log("Simple Scroll-Reveal läuft ✨");

      const revealElements = document.querySelectorAll(".reveal-on-scroll");
      console.log("Reveal-Elemente gefunden:", revealElements.length);

      function revealOnScroll() {
        const triggerBottom = window.innerHeight * 0.85; // etwas über dem unteren Rand

        revealElements.forEach(function (el) {
          const rect = el.getBoundingClientRect();
          // Sobald das Element in den sichtbaren Bereich kommt:
          if (rect.top < triggerBottom) {
            el.classList.add("is-visible");
          }
        });
      }

      // Beim Laden und bei jedem Scroll prüfen
      revealOnScroll();
      window.addEventListener("scroll", revealOnScroll);
    });
  </script>

<?php get_footer(); ?>
