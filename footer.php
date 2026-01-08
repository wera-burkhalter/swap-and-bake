<?php
/**
 * Footer Template – Bake & Swap
 * Footer mit Cookie-Hintergrund, Logo und Navigation
 */
?>

<footer class="site-footer">

  <!-- Cookie-Hintergrundbild -->
  <img 
    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Footer.JPG" 
    alt="Cookie Hintergrund" 
    class="footer-bg-img"
  >

  <!-- Roter Bereich mit Logo + Navigation -->
  <div class="footer-main">
    
    <!-- Logo -->
    <a href="<?php echo esc_url( home_url('/') ); ?>" class="footer-logo">
      <img
        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Logo Footer.png"
        alt="Bake &amp; Swap"
      >
    </a>

    <!-- Navigation -->
    <nav class="footer-nav" aria-label="Footer Navigation">
      <a href="<?php echo esc_url( home_url('/') ); ?>">Startseite</a>
      <a href="<?php echo esc_url( site_url('/rezepte/') ); ?>">Rezepte</a>
      <a href="<?php echo esc_url( site_url('/impressum/') ); ?>">Impressum</a>
      <a href="<?php echo esc_url( site_url('/datenschutz/') ); ?>">Datenschutz</a>
    </nav>
    
  </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>