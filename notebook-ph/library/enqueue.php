<?php

add_action('wp_enqueue_scripts', 'nph_assets');
function nph_assets() {
  $version = nph_get_theme_version();

  wp_register_style(
    'nph-styles',
    get_template_directory_uri() . '/style.css',
    '',
    $version,
    'all'
  );
  wp_enqueue_style('nph-styles');

  wp_register_script(
    'nph-scripts',
    get_template_directory_uri() . '/scripts.js',
    array(),
    $version,
    true
  );
  wp_enqueue_script('nph-scripts');

  // If GA Google Analytics Pro is enabled, set a cookie to hide the message initially
  if (class_exists('GA_Google_Analytics_Pro')) {
    wp_register_script(
      'ga-pro',
      get_template_directory_uri() . '/ga-pro-cookie.js',
      array(),
      $version,
      false
    );
    wp_enqueue_script('ga-pro');
  }
}