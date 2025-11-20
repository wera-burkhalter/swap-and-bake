<?php
/**
 * Einzelnes Rezept (CPT: recipe)
 */

get_header();
?>

<main class="recipe-page">
  <?php
  while ( have_posts() ) :
    the_post();

    // gesamter Rezept-Inhalt als Template-Part:
    get_template_part( 'template-parts/recipe-content' );

  endwhile;
  ?>
</main>

<?php
get_footer();
