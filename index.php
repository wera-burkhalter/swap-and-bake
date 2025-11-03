<?php
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <main class="site-main" role="main" style="padding:2rem">
    <h1><?php bloginfo('name'); ?></h1>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; else : ?>
      <p>No content yet.</p>
    <?php endif; ?>
  </main>
  <?php wp_footer(); ?>
</body>
</html>
