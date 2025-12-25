<?php
get_header();
?>

<main class="single-recipe">  <!-- WICHTIG: Klasse geändert -->
  <?php
  while ( have_posts() ) :
    the_post();
    get_template_part( 'template-parts/recipe-content' );
  endwhile;
  ?>
</main>

<?php
get_footer();
