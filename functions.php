<?php
// Theme-Setup: Bilder erlauben
add_action('after_setup_theme', function () {
  add_theme_support('post-thumbnails');
});

// Styles & Scripts laden
add_action('wp_enqueue_scripts', function () {
  // Basis-CSS (style.css im Theme)
  wp_enqueue_style(
    'swapbake-style',
    get_stylesheet_uri(),
    [],
    '1.0'
  );

  // Haupt-CSS (css/main.css im Theme)
  wp_enqueue_style(
    'swapbake-main',
    get_stylesheet_directory_uri() . '/css/main.css',
    ['swapbake-style'],
    '1.0'
  );

  // Haupt-JS (js/main.js im Theme)
  wp_enqueue_script(
    'swapbake-main-js',
    get_stylesheet_directory_uri() . '/js/main.js',
    [],
    '1.0',
    true
  );
});


// Custom Post Type: Rezepte
add_action('init', function () {
  register_post_type('recipe', [
    'label'        => 'Rezepte',
    'public'       => true,
    'has_archive'  => true,
    'rewrite'      => ['slug' => 'rezepte'],
    'menu_icon'    => 'dashicons-carrot',
    'supports'     => ['title','editor','thumbnail'],
    'show_in_rest' => true,
  ]);
});
