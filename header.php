<?php
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <?php wp_head(); ?>
<link rel="stylesheet" href="https://use.typekit.net/yzl8lpa.css">
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( ! is_front_page() ) : ?>
  <header class="site-header">
    <div class="site-header-inner">
      <a href="<?php echo esc_url( home_url('/') ); ?>" class="site-title-link">
        <img 
          src="<?php echo get_template_directory_uri(); ?>/assets/bake&swap.png"
          alt="bake &amp; swap"
          class="site-logo-img"
        >
      </a>
      <!-- hier könntest du später ein Menü einbauen -->
    </div>
  </header>
<?php endif; ?>

