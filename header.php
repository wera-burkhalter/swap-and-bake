<?php
/**
 * Header Template – Bake & Swap
 * Wird auf allen Seiten außer der Homepage angezeigt
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
  
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( ! is_front_page() ) : ?>
  <header class="site-header">

    <!-- Logo + Navigation -->
    <div class="site-header-main">
      <div class="site-header-inner">
        
        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header-logo">
          <img
            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Logo Header.png"
            alt="Bake &amp; Swap"
          >
        </a>

        <!-- Navigation -->
        <nav class="site-header-nav" aria-label="Hauptnavigation">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Startseite</a>
          <a href="<?php echo esc_url( site_url( '/rezepte/' ) ); ?>">Rezepte</a>
        </nav>
        
      </div>
    </div>

  </header>
<?php endif; ?>


