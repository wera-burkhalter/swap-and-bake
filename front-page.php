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
        src="<?php echo get_template_directory_uri(); ?>/assets/bake&swap.png" 
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


  <!-- TRENNER (Zuckerstangen-Streifen etc.) -->
  <section class="stripe-sep" aria-hidden="true"></section>


  <!-- LIEBLINGSREZEPTE -->
  <section class="favorites">
    <div class="favorites-inner">
      <header class="favorites-header">
        <h2>lieblings<br>rezepte</h2>
        <p class="favorites-sub">
          Kleine, feine Auswahl an Rezepten – von chewy Cookies bis zum zitronig-frischen Kuchen.
        </p>
      </header>

      <div class="fav-grid">
        <?php
        $fav_query = new WP_Query([
          'post_type'      => 'recipe',
          'posts_per_page' => 6,
          'orderby'        => 'date',
          'order'          => 'DESC',
        ]);

        if ($fav_query->have_posts()) :
          while ($fav_query->have_posts()) : $fav_query->the_post(); ?>
            <article class="recipe-card">
              <a href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) : ?>
                  <div class="recipe-card-img">
                    <?php the_post_thumbnail('medium_large'); ?>
                  </div>
                <?php endif; ?>

                <h3 class="recipe-card-title"><?php the_title(); ?></h3>
              </a>
            </article>
          <?php
          endwhile;
          wp_reset_postdata();
        else :
          echo '<p>Noch keine Rezepte angelegt.</p>';
        endif;
        ?>
      </div>

      <div class="favorites-cta">
        <a class="btn" href="<?php echo esc_url( site_url('/rezepte/') ); ?>">
          Alle Rezepte ansehen
        </a>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
