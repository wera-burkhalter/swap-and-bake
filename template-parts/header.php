<?php
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( !is_front_page() ) : ?>
  <header class="site-header">
    <div class="site-header-inner">
      <a href="<?php echo esc_url( home_url('/') ); ?>" class="site-title-link">
        <?php bloginfo('name'); ?>
      </a>
      <!-- hier könntest du später ein Menü einbauen -->
    </div>
  </header>
<?php endif; ?>
