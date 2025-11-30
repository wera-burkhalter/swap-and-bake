<?php
/**
 * Footer – Bake & Swap
 */
?>

<footer class="site-footer">

  <!-- Roter Bereich mit Logo + Navigation -->
  <div class="footer-main">
    <a href="<?php echo esc_url( home_url('/') ); ?>" class="footer-logo">
      <img
        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/bake-swap-footer-logo-white.png"
        alt="Bake &amp; Swap"
      >
    </a>

    <nav class="footer-nav" aria-label="Footer Navigation">
      <a href="<?php echo esc_url( site_url('/rezepte/') ); ?>">Rezepte</a>
      <a href="<?php echo esc_url( home_url('/') ); ?>">Startseite</a>
      <a href="<?php echo esc_url( site_url('/impressum/') ); ?>">Impressum</a>
      <a href="<?php echo esc_url( site_url('/datenschutz/') ); ?>">Datenschutz</a>
    </nav>
  </div>

  <!-- Gestreifter Rand unten -->
  <div class="footer-stripes"></div>

</footer>

<?php wp_footer(); ?>
</body>
</html>