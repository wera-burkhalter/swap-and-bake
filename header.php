<?php
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Adobe Fonts -->
  <link rel="stylesheet" href="https://use.typekit.net/yzl8lpa.css">

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( ! is_front_page() ) : ?>
  <header class="site-header">

    <!-- Streifen oben (gleiches Muster wie Footer) -->
    <div class="site-header-stripes"></div>

    <!-- Roter Balken mit Logo + Navigation -->
    <div class="site-header-main">
      <div class="site-header-inner">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header-logo">
          <img
            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/bake-swap-footer-logo-white.png"
            alt="Bake &amp; Swap"
          >
        </a>

        <nav class="site-header-nav" aria-label="Hauptnavigation">
          <a href="<?php echo esc_url( site_url( '/rezepte/' ) ); ?>">Rezepte</a>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Startseite</a>
        </nav>
      </div>
    </div>

  </header>
<?php endif; ?>


