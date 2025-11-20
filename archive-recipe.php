<?php
/**
 * Archivseite für Rezepte (CPT: recipe)
 */

get_header();
?>

<main class="recipes-archive">

  <section class="recipes-archive-header">
    <h1>lieblingsrezepte</h1>
    <p>Kleine, feine Auswahl – von chewy Cookies bis zum zitronigen Kuchen.</p>
  </section>

  <section class="recipes-grid">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'template-parts/recipe-card' ); ?>
      <?php endwhile; ?>

      <div class="recipes-pagination">
        <?php the_posts_pagination(); ?>
      </div>
    <?php else : ?>
      <p>Noch keine Rezepte angelegt.</p>
    <?php endif; ?>
  </section>

</main>

<?php
get_footer();
