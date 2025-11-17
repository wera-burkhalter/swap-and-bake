<?php
/* Fallback Template – Swap & Bake */
get_header(); ?>
<main class="site-main" style="padding:2rem">
  <h1><?php bloginfo('name'); ?></h1>
  <p>Standard-Template – kein spezielles Template gefunden.</p>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article><?php the_content(); ?></article>
  <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
