<?php
/**
 * Einzelnes Rezept – Inhalt
 * Wird von single-recipe.php eingebunden.
 */

$hero_image = get_field('hero_bild');

// ACF-Repeater: Standard + Vegan
$zutaten_normal_raw = get_field('zutaten_normal');
$zutaten_vegan_raw  = get_field('zutaten_vegan');

if (!is_array($zutaten_normal_raw)) {
  $zutaten_normal_raw = [];
}
if (!is_array($zutaten_vegan_raw)) {
  $zutaten_vegan_raw = [];
}

// VEGAN-Liste mit Diff-Logik aufbauen
if (function_exists('merge_ingredients')) {
  $zutaten_vegan_merged = merge_ingredients($zutaten_normal_raw, $zutaten_vegan_raw);
} else {
  $zutaten_vegan_merged = $zutaten_vegan_raw;
}

// Tipps holen
$tipps_normal = get_field('tipps_normal');
if (!is_array($tipps_normal)) {
  $tipps_normal = [];
}
$tipps_vegan = get_field('tipps_vegan');
if (!is_array($tipps_vegan)) {
  $tipps_vegan = [];
}
?>

<article <?php post_class('recipe-single'); ?>>

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

      <!-- TITEL -->
      <header class="recipe-title-header">
        <h1 class="recipe-title"><?php the_title(); ?></h1>
      </header>

      <!-- ZUTATEN + ZUBEREITUNG -->
      <section class="recipe-main-block">
        <div class="recipe-columns">

          <!-- SPALTE 1: Zutaten + Toggle -->
          <div class="recipe-col recipe-col-ingredients">

            <?php if (!empty($zutaten_normal_raw) || !empty($zutaten_vegan_merged)) : ?>
              <div class="ingredients-toggle">
                <button class="toggle-btn is-active" data-target="normal">standard</button>
                <button class="toggle-btn" data-target="vegan">vegan</button>
              </div>
            <?php endif; ?>

            <!-- STANDARD: genau die normalen Zutaten -->
            <?php if (!empty($zutaten_normal_raw)) : ?>
              <ul class="ingredients-list ingredients-list--normal">
                <?php foreach ($zutaten_normal_raw as $row) :
                  $menge   = $row['menge']   ?? '';
                  $einheit = $row['einheit'] ?? '';
                  $zutat   = $row['zutat']   ?? '';
                  ?>
                  <li class="ingredient-item">
                    <span class="ingredient-amount">
                      <?php if ($menge !== '' && $menge !== null) : ?>
                        <?php echo esc_html($menge); ?>
                      <?php endif; ?>
                      <?php if ($einheit !== '') : ?>
                        <span class="ingredient-unit"><?php echo esc_html($einheit); ?></span>
                      <?php endif; ?>
                    </span>
                    <span class="ingredient-name">
                      <?php echo esc_html($zutat); ?>
                    </span>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>

            <!-- VEGAN: aus Standard + Overrides + Extras gemergt -->
            <?php if (!empty($zutaten_vegan_merged)) : ?>
              <ul class="ingredients-list ingredients-list--vegan" style="display:none;">
                <?php foreach ($zutaten_vegan_merged as $row) :
                  $menge   = $row['menge']   ?? '';
                  $einheit = $row['einheit'] ?? '';
                  $zutat   = $row['zutat']   ?? '';

                  $replaced_name = $row['_replaced_name'] ?? '';
                  ?>
                  <li class="ingredient-item">
                    <span class="ingredient-amount">
                      <?php if ($menge !== '' && $menge !== null) : ?>
                        <?php echo esc_html($menge); ?>
                      <?php endif; ?>
                      <?php if ($einheit !== '') : ?>
                        <span class="ingredient-unit"><?php echo esc_html($einheit); ?></span>
                      <?php endif; ?>
                    </span>
                    <span class="ingredient-name">
                      <?php echo esc_html($zutat); ?>

                      <?php if ($replaced_name !== '') : ?>
                        <span class="ingredient-note">
                          (statt <?php echo esc_html($replaced_name); ?>)
                        </span>
                      <?php endif; ?>
                    </span>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>

          </div><!-- /recipe-col-ingredients -->


          <!-- SPALTE 2: Zubereitung -->
          <div class="recipe-col recipe-col-steps">
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
          </div><!-- /recipe-col-steps -->

        </div><!-- /recipe-columns -->
      </section>

      <!-- TIPPS & HINWEISE -->
      <?php
      $has_tips_normal = !empty($tipps_normal);
      $has_tips_vegan  = !empty($tipps_vegan);
      ?>

      <?php if ($has_tips_normal || $has_tips_vegan) : ?>
        <section class="recipe-tips">
          <h2 class="recipe-section-title tips-title">tipps &amp; hinweise</h2>

          <?php if ($has_tips_normal) : ?>
            <div class="tips-grid tips-variant tips-variant--normal">
              <?php foreach ($tipps_normal as $tip) :
                $titel = $tip['title'] ?? '';
                $text  = $tip['beschreibung'] ?? '';
                ?>
                <article class="tip-item">
                  <?php if ($titel) : ?>
                    <h3 class="tip-title"><?php echo esc_html($titel); ?></h3>
                  <?php endif; ?>
                  <?php if ($text) : ?>
                    <p class="tip-text"><?php echo nl2br(esc_html($text)); ?></p>
                  <?php endif; ?>
                </article>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <?php if ($has_tips_vegan) : ?>
            <div class="tips-grid tips-variant tips-variant--vegan" style="display:none;">
              <?php foreach ($tipps_vegan as $tip) :
                $titel = $tip['title'] ?? '';
                $text  = $tip['beschreibung'] ?? '';
                ?>
                <article class="tip-item">
                  <?php if ($titel) : ?>
                    <h3 class="tip-title"><?php echo esc_html($titel); ?></h3>
                  <?php endif; ?>
                  <?php if ($text) : ?>
                    <p class="tip-text"><?php echo nl2br(esc_html($text)); ?></p>
                  <?php endif; ?>
                </article>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </section>
      <?php endif; ?>

    </div><!-- /recipe-main-inner -->
  </main>

</article>