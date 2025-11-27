<?php
/**
 * Archiv-Seite für Custom Post Type "recipe"
 * URL: /rezepte/
 */

get_header();
?>

<main class="recipes-archive">

  <header class="recipes-archive-header">
    <h1 class="recipes-archive-title">alle rezepte</h1>
  </header>

  <section class="recipes-list">

    <?php
    // Eigene Query: max. 6 Rezepte, damit es nur 2 Balken à 3 gibt
    $recipes_query = new WP_Query([
      'post_type'      => 'recipe',
      'posts_per_page' => 6,
      'orderby'        => 'date',
      'order'          => 'DESC',
    ]);
    ?>

    <?php if ( $recipes_query->have_posts() ) : ?>

      <?php
      $count = 0;
      // Ersten Balken öffnen
      echo '<article class="recipe-strip"><div class="recipe-strip-inner">';

      while ( $recipes_query->have_posts() ) :
        $recipes_query->the_post();

        // Bild holen – erst ACF "startseite_bild", sonst Beitragsbild
        $image = get_field('startseite_bild');
        if ( !$image && has_post_thumbnail() ) {
          $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
          $image_alt = get_the_title();
        } elseif ( $image ) {
          $image_url = $image['url'];
          $image_alt = $image['alt'] ?: get_the_title();
        } else {
          // Wenn gar kein Bild vorhanden ist, dieses Rezept überspringen
          continue;
        }

        $count++;
        ?>

        <a class="recipe-strip-item" href="<?php the_permalink(); ?>">
          <img src="<?php echo esc_url( $image_url ); ?>"
               alt="<?php echo esc_attr( $image_alt ); ?>">
        </a>

        <?php
        // Nach jedem 3. Rezept Balken schließen und – falls noch weitere kommen – neuen öffnen
        if ( $count % 3 === 0 && ( $recipes_query->current_post + 1 ) < $recipes_query->post_count ) {
          echo '</div></article>';
          echo '<article class="recipe-strip"><div class="recipe-strip-inner">';
        }

      endwhile;

      // Letzten offenen Balken schließen
      echo '</div></article>';

      wp_reset_postdata();
      ?>

    <?php else : ?>

      <p class="recipes-empty">Noch keine Rezepte vorhanden.</p>

    <?php endif; ?>

  </section>

</main>

<?php get_footer(); ?>