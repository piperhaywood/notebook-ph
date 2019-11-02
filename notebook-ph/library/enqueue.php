<?php

// If GA Google Analytics Pro is enabled, print scripts earlier in footer
if (class_exists('GA_Google_Analytics_Pro')) {
  remove_action('wp_footer', 'wp_print_footer_scripts', 20);
  add_action('wp_footer', 'wp_print_footer_scripts', 9);
}

add_action('wp_enqueue_scripts', 'nph_assets', 10);
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

}