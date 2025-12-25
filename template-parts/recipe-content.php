<?php
/**
 * Einzelnes Rezept – Inhalt (Figma Design)
 * Wird von single-recipe.php eingebunden.
 * MIT Support für vegane Zubereitung
 */

// ACF-Felder holen
$hero_bild = get_field('hero_bild');
$kategorie = get_field('kategorie') ?: 'Divers';
$zeit = get_field('zeit') ?: '30 min';
$schwierigkeit = get_field('schwierigkeit') ?: 'Mittel';
$portionen = get_field('portionen') ?: '4 Stk.';

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

$zubereitung_normal = get_field('zubereitung');
$zubereitung_vegan = get_field('zubereitung_vegan');

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

  <!-- ===== HERO SECTION ===== -->
  <section class="recipe-hero">
    <div class="recipe-hero-inner">
      
      <!-- Hero Bild Links -->
      <div class="recipe-hero-image">
        <?php if ($hero_bild) : ?>
          <img 
            src="<?php echo esc_url($hero_bild['url']); ?>" 
            alt="<?php echo esc_attr($hero_bild['alt'] ?: get_the_title()); ?>"
          >
        <?php elseif (has_post_thumbnail()) : ?>
          <?php the_post_thumbnail('large'); ?>
        <?php endif; ?>
      </div>

      <!-- Meta-Infos Rechts -->
      <div class="recipe-hero-meta">
        
        <!-- Kategorie Badge -->
        <span class="recipe-category"><?php echo esc_html($kategorie); ?></span>

        <!-- Titel -->
        <h1 class="recipe-title"><?php the_title(); ?></h1>

        <!-- Beschreibung (optional) -->
        <?php if (has_excerpt()) : ?>
          <p class="recipe-description"><?php the_excerpt(); ?></p>
        <?php endif; ?>

        <!-- Meta Badges -->
        <div class="recipe-meta-badges">
          <span class="meta-badge"><?php echo esc_html($zeit); ?></span>
          <span class="meta-badge"><?php echo esc_html($schwierigkeit); ?></span>
          <span class="meta-badge"><?php echo esc_html($portionen); ?></span>
        </div>

        <!-- Basic/Vegan Toggle -->
        <div class="ingredients-toggle">
          <button class="toggle-btn is-active" data-target="normal">Basic</button>
          <button class="toggle-btn" data-target="vegan">Vegan</button>
        </div>

      </div>

    </div>
  </section>

  <!-- ===== ZUTATEN + ZUBEREITUNG (2-Spalten) ===== -->
  <section class="recipe-content">
    <div class="recipe-content-inner">

      <!-- LINKE SPALTE: Zutaten -->
      <div class="recipe-column recipe-ingredients">
        <h2 class="section-title">Zutaten</h2>

        <!-- Standard-Zutaten -->
        <?php if (!empty($zutaten_normal_raw)) : ?>
          <ul class="ingredients-list ingredients-list--normal">
            <?php
            $last_bereich = null;

            foreach ($zutaten_normal_raw as $row) :
              $bereich = trim($row['bereich'] ?? '');

              // Neue Bereich-Überschrift
              if ($bereich !== '' && $bereich !== $last_bereich) : ?>
                <li class="ingredient-group">
                  <?php echo esc_html($bereich); ?>
                </li>
                <?php
                $last_bereich = $bereich;
              endif;

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

        <!-- Vegane Zutaten (gemerged) -->
        <?php if (!empty($zutaten_vegan_merged)) : ?>
          <ul class="ingredients-list ingredients-list--vegan" style="display:none;">
            <?php
            $last_bereich = null;

            foreach ($zutaten_vegan_merged as $row) :
              $bereich     = trim($row['bereich'] ?? '');
              $menge       = $row['menge']       ?? '';
              $einheit     = $row['einheit']     ?? '';
              $zutat       = $row['zutat']       ?? '';
              $ersatzinfo  = $row['ersatzinfo']  ?? '';

              // Bereich-Überschrift
              if ($bereich !== '' && $bereich !== $last_bereich) : ?>
                <li class="ingredient-group">
                  <?php echo esc_html($bereich); ?>
                </li>
                <?php
                $last_bereich = $bereich;
              endif;
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
                  <?php if ($ersatzinfo !== '') : ?>
                    <span class="ingredient-note">
                      <?php echo esc_html($ersatzinfo); ?>
                    </span>
                  <?php endif; ?>
                </span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>

      <!-- RECHTE SPALTE: Zubereitung -->
      <div class="recipe-column recipe-steps">
        <h2 class="section-title">Zubereitung</h2>

        <!-- STANDARD-Zubereitung -->
        <?php if (have_rows('zubereitung')) : ?>
          <ol class="steps-list steps-list--normal">
            <?php 
            $step_counter = 1;
            while (have_rows('zubereitung')) : the_row();
              $nr  = get_sub_field('nr') ?: $step_counter;
              $txt = get_sub_field('beschreibung');
              ?>
              <li class="step-item">
                <span class="step-number"><?php echo sprintf('%02d', $nr); ?></span>
                <p class="step-text"><?php echo nl2br(esc_html($txt)); ?></p>
              </li>
              <?php 
              $step_counter++;
            endwhile; ?>
          </ol>
        <?php endif; ?>

        <!-- VEGANE Zubereitung -->
        <?php if (have_rows('zubereitung_vegan')) : ?>
          <ol class="steps-list steps-list--vegan" style="display:none;">
            <?php 
            $step_counter = 1;
            while (have_rows('zubereitung_vegan')) : the_row();
              $nr  = get_sub_field('nr') ?: $step_counter;
              $txt = get_sub_field('beschreibung');
              ?>
              <li class="step-item">
                <span class="step-number"><?php echo sprintf('%02d', $nr); ?></span>
                <p class="step-text"><?php echo nl2br(esc_html($txt)); ?></p>
              </li>
              <?php 
              $step_counter++;
            endwhile; ?>
          </ol>
        <?php endif; ?>
      </div>

    </div>
  </section>

  <!-- ===== TIPPS SECTION ===== -->
  <?php
  $has_tips_normal = !empty($tipps_normal);
  $has_tips_vegan  = !empty($tipps_vegan);
  ?>

  <?php if ($has_tips_normal || $has_tips_vegan) : ?>
  <section class="recipe-tips">
    <div class="recipe-tips-inner">
      
      <!-- Tipps-Kachel mit Titel INNEN -->
      <div class="recipe-column recipe-tips-column">
        
        <h2 class="section-title">Tipps</h2>

        <!-- Standard-Tipps -->
        <?php if ($has_tips_normal) : ?>
          <div class="tips-variant tips-variant--normal">
            <div class="tips-grid">
              <?php foreach ($tipps_normal as $tip) :
                $titel = $tip['title'] ?? '';
                $text  = $tip['beschreibung'] ?? '';
                ?>
                <article class="tip-card">
                  <?php if ($titel) : ?>
                    <h3 class="tip-title"><?php echo esc_html($titel); ?></h3>
                  <?php endif; ?>
                  <?php if ($text) : ?>
                    <p class="tip-text"><?php echo nl2br(esc_html($text)); ?></p>
                  <?php endif; ?>
                </article>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Vegane Tipps -->
        <?php if ($has_tips_vegan) : ?>
          <div class="tips-variant tips-variant--vegan" style="display:none;">
            <div class="tips-grid">
              <?php foreach ($tipps_vegan as $tip) :
                $titel = $tip['title'] ?? '';
                $text  = $tip['beschreibung'] ?? '';
                ?>
                <article class="tip-card">
                  <?php if ($titel) : ?>
                    <h3 class="tip-title"><?php echo esc_html($titel); ?></h3>
                  <?php endif; ?>
                  <?php if ($text) : ?>
                    <p class="tip-text"><?php echo nl2br(esc_html($text)); ?></p>
                  <?php endif; ?>
                </article>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

      </div>

    </div>
  </section>
  <?php endif; ?>

</article>