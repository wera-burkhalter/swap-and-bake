<?php
/**
 * Einzelnes Rezept – Inhalt
 * Wird von single-recipe.php eingebunden.
 */

$hero_image = get_field('hero_bild');
?>

<article <?php post_class('recipe-single'); ?>>

  <!-- HERO: Bild über volle Breite, Titel ausgeblendet -->
  <?php if ($hero_image) : ?>
    <section class="recipe-hero">
      <div class="recipe-hero-inner">
        <img 
          src="<?php echo esc_url($hero_image['url']); ?>" 
          alt="<?php echo esc_attr($hero_image['alt'] ?: get_the_title()); ?>"
          class="recipe-hero-img"
        >
      </div>
    </section>
  <?php endif; ?>

  <main class="recipe-main">
    <div class="recipe-main-inner">

      <!-- Zutaten & Zubereitung in 2 Spalten -->
      <section class="recipe-main-block">

        <div class="recipe-columns">

          <!-- SPALTE 1: Zutaten (ohne Überschrift "Zutaten") -->
          <div class="recipe-col recipe-col-ingredients">
            <?php if (have_rows('zutaten_normal')) : ?>
              <ul class="ingredients-list">
                <?php while (have_rows('zutaten_normal')) : the_row(); 
                  $menge  = get_sub_field('menge');
                  $einheit = get_sub_field('einheit');
                  $zutat   = get_sub_field('zutat');
                ?>
                  <li class="ingredient-item">
                    <span class="ingredient-amount">
                      <?php if ($menge !== '' && $menge !== null) : ?>
                        <?php echo esc_html($menge); ?>
                      <?php endif; ?>
                      <?php if ($einheit) : ?>
                        <span class="ingredient-unit"><?php echo esc_html($einheit); ?></span>
                      <?php endif; ?>
                    </span>
                    <span class="ingredient-name"><?php echo esc_html($zutat); ?></span>
                  </li>
                <?php endwhile; ?>
              </ul>
            <?php endif; ?>
          </div>

          <!-- SPALTE 2: Zubereitung -->
          <div class="recipe-col recipe-col-steps">
            <h2 class="recipe-section-title">zubereitung</h2>

            <?php if (have_rows('zubereitung')) : ?>
              <ol class="steps-list">
                <?php while (have_rows('zubereitung')) : the_row(); 
                  $nr  = get_sub_field('nr');
                  $txt = get_sub_field('beschreibung');
                ?>
                  <li class="step-item">
                    <?php if ($nr) : ?>
                      <span class="step-number"><?php echo esc_html($nr); ?></span>
                    <?php endif; ?>
                    <p class="step-text"><?php echo nl2br(esc_html($txt)); ?></p>
                  </li>
                <?php endwhile; ?>
              </ol>
            <?php endif; ?>
          </div>

        </div><!-- .recipe-columns -->

      </section>

      <!-- TIPPS & HINWEISE -->
      <?php if (have_rows('tipps')) : ?>
        <section class="recipe-tips">
          <h2 class="recipe-section-title tips-title">tipps &amp; hinweise</h2>

          <div class="tips-grid">
            <?php while (have_rows('tipps')) : the_row(); 
              $titel = get_sub_field('title');
              $text  = get_sub_field('beschreibung');
            ?>
              <article class="tip-item">
                <?php if ($titel) : ?>
                  <h3 class="tip-title"><?php echo esc_html($titel); ?></h3>
                <?php endif; ?>
                <?php if ($text) : ?>
                  <p class="tip-text"><?php echo nl2br(esc_html($text)); ?></p>
                <?php endif; ?>
              </article>
            <?php endwhile; ?>
          </div>
        </section>
      <?php endif; ?>

    </div>
  </main>

</article>
 