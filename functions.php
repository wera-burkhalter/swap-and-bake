<?php
// -----------------------------------------------------------
// Theme-Setup: Bilder erlauben
// -----------------------------------------------------------
add_action('after_setup_theme', function () {
  add_theme_support('post-thumbnails');
});


// -----------------------------------------------------------
// Styles & Scripts laden
// -----------------------------------------------------------
add_action('wp_enqueue_scripts', function () {

  // Basis-CSS (style.css)
  wp_enqueue_style(
    'swapbake-style',
    get_stylesheet_uri(),
    [],
    '1.0'
  );

  // Haupt-CSS (css/main.css)
  wp_enqueue_style(
    'swapbake-main',
    get_stylesheet_directory_uri() . '/css/main.css',
    ['swapbake-style'],
    '1.0'
  );

  // Haupt-JS (js/main.js)
  wp_enqueue_script(
    'swapbake-main-js',
    get_stylesheet_directory_uri() . '/js/main.js',
    [],
    '1.0',
    true
  );
});


// -----------------------------------------------------------
// Custom Post Type: Rezepte
// -----------------------------------------------------------
add_action('init', function () {
  register_post_type('recipe', [
    'label'        => 'Rezepte',
    'public'       => true,
    'has_archive'  => true,
    'rewrite'      => ['slug' => 'rezepte'],
    'menu_icon'    => 'dashicons-carrot',
    'supports'     => ['title', 'editor', 'thumbnail'],
    'show_in_rest' => true,
  ]);
});


// =====================================================================
// VEGAN-ZUTATEN MERGEN (Standard → Überschrieben durch Vegan)
// Diese Version ist exakt die funktionierende Version in deinem Projekt.
// =====================================================================
function merge_ingredients($normal_rows, $vegan_rows) {

  // Sicherheit: immer Arrays
  if (!is_array($normal_rows)) {
    $normal_rows = [];
  }
  if (!is_array($vegan_rows)) {
    $vegan_rows = [];
  }

  $merged = [];

  // -----------------------------------------------------------
  // 1) Vegane Overrides nach Ziel-Zutat indexieren
  //    key = name der Standard-Zutat (klein geschrieben)
  // -----------------------------------------------------------
  $override_map = [];

  foreach ($vegan_rows as $v_row) {
    $aktion = $v_row['aktion'] ?? 'ersetzen';
    $target = strtolower(trim($v_row['bezieht_sich_auf'] ?? ''));

    if ($aktion === 'ersetzen' && $target !== '') {
      $override_map[$target] = $v_row;
    }
  }

  // -----------------------------------------------------------
  // 2) Standard-Zutaten durchgehen & ggf. überschreiben
  // -----------------------------------------------------------
  foreach ($normal_rows as $std_row) {

    $std_name_raw = $std_row['zutat'] ?? '';
    $std_name_key = strtolower(trim($std_name_raw));

    $current = $std_row;

    // vegane Variante vorhanden?
    if ($std_name_key !== '' && isset($override_map[$std_name_key])) {

      $v_row = $override_map[$std_name_key];

      $veg_name    = $v_row['zutat_vegan']   ?? '';
      $veg_menge   = $v_row['menge_vegan']   ?? '';
      $veg_einheit = $v_row['einheit_vegan'] ?? '';

      if ($veg_name !== '') {
        $current['zutat'] = $veg_name;
      }
      if ($veg_menge !== '' && $veg_menge !== null) {
        $current['menge'] = $veg_menge;
      }
      if ($veg_einheit !== '') {
        $current['einheit'] = $veg_einheit;
      }

      // Zusatzinfos
      $current['_replaced_name']     = $std_name_raw;
      $current['_is_vegan_override'] = true;
    }

    $merged[] = $current;
  }

  // -----------------------------------------------------------
  // 3) Zusatz-Zutaten der veganen Liste (Aktion = "hinzufügen")
  // -----------------------------------------------------------
  foreach ($vegan_rows as $v_row) {

    $aktion = $v_row['aktion'] ?? '';

    if ($aktion === 'hinzufügen') {

      $merged[] = [
        'menge'           => $v_row['menge_vegan']   ?? '',
        'einheit'         => $v_row['einheit_vegan'] ?? '',
        'zutat'           => $v_row['zutat_vegan']   ?? '',
        '_is_extra_vegan' => true,
      ];
    }
  }

  return $merged;
}


// =====================================================================
// ACF: Dropdown "bezieht_sich_auf" dynamisch mit Standardzutaten füllen
// =====================================================================
add_filter('acf/load_field/name=bezieht_sich_auf', function ($field) {

  $field['choices'] = [];

  if (!function_exists('get_field')) {
    return $field;
  }

  $normal = get_field('zutaten_normal');

  if (is_array($normal)) {
    foreach ($normal as $row) {
      if (!empty($row['zutat'])) {
        $name = trim($row['zutat']);
        $field['choices'][$name] = $name;
      }
    }
  }

  return $field;
});

