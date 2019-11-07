<?php

add_action('after_setup_theme', 'nph_start_cleanup');
function nph_start_cleanup() {
  add_action('init', 'nph_cleanup_head');
  add_filter('the_generator', 'nph_remove_rss_version');
  add_filter('gallery_style', 'nph_gallery_style');
}

function nph_cleanup_head() {
  remove_action ('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
  add_filter('style_loader_src', 'nph_alter_wp_ver_css_js', 9999);
  add_filter('script_loader_src', 'nph_alter_wp_ver_css_js', 9999);
}

function nph_remove_rss_version() { return ''; }

function nph_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

// Add the theme version to the css and js, not the WP version
function nph_alter_wp_ver_css_js($src) {
  if (strpos($src, 'ver=')) {
    $version = nph_get_theme_version();
    $src = remove_query_arg('ver', $src);
    $src = add_query_arg('ver', $version, $src);
  }
  return $src;
}

// Add loading attribute to images
add_filter( 'the_content', 'nph_lazyload_content_images' );
function nph_lazyload_content_images( $content ) {
  if ( ! preg_match_all( '/<img [^>]+>/', $content, $matches ) ) {
    return $content;
  }
  foreach ( $matches[0] as $image ) {
    if ( false === strpos( $image, ' loading=' ) ) {
      $content = str_replace( $image, preg_replace( '/>/', 'loading="lazy">', $image ), $content);
    }
  }
  return $content;
}