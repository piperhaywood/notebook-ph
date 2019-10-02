<?php

add_action('after_setup_theme','start_cleanup');
function start_cleanup() {
  add_action('init', 'cleanup_head');
  add_filter('the_generator', 'remove_rss_version');
  add_filter('gallery_style', 'gallery_style');
}

function cleanup_head() {
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'rel_canonical', 10, 0);
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_generator');
  add_filter('style_loader_src', 'alter_wp_ver_css_js', 9999);
  add_filter('script_loader_src', 'alter_wp_ver_css_js', 9999);
}

add_filter('wp_title', 'nph_wp_title', 10, 2);
function nph_wp_title($title, $sep) {
  global $paged, $page;

  if (is_feed()) {
    return $title;
  }

  $title .= get_bloginfo('name');

  $site_description = get_bloginfo('description', 'display');
  if ($site_description && (is_home() || is_front_page())) {
    $title = "$title $sep $site_description";
  }

  if ($paged >= 2 || $page >= 2) {
    $title = sprintf(__('Page %s', 'notebook-ph'), max($paged, $page)) . " $sep $title";
  }

  return $title;

}

function remove_rss_version() { return ''; }

function gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

function alter_wp_ver_css_js($src) {
  if (strpos($src, 'ver=')) {
    $version = nph_get_theme_version();
    $src = remove_query_arg('ver', $src);
    $src = add_query_arg('ver', $version, $src);
  }
  return $src;
}

add_filter('the_content_more_link', 'nph_modify_read_more_link', 10, 2);
function nph_modify_read_more_link($more_link, $more_link_text) {
  return $more_link . ' &rarr;';
}

add_filter('the_content', 'ph_remove_arrows');
function ph_remove_arrows($content) {
  $content = str_replace('&rarr;', '', $content);
  $content = str_replace('→', '', $content);
  return $content;
}

add_filter('wp_calculate_image_sizes', 'nph_sizes', 10 , 5);
function nph_sizes($sizes, $size, $image_src, $image_meta, $attachment_id) {
  $width = $size[0];
  if ($width >= 1212) {
    $sizes = '(max-width: 638px) 95vw, 606px';
  } else {
    $half = $width / 2;
    $sizes = '(max-width: ' . $half . 'px) 95vw, ' . $half . 'px';
  }
  return $sizes;
}

add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );
function remove_width_attribute( $html ) {
  $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
  return $html;
}

// Accounts for Wordpress incorrect srcset order
add_filter( 'wp_calculate_image_srcset', 'ph_adjust_srcset', 10, 5 );
function ph_adjust_srcset( $sources, $size_array, $image_src, $image_meta, $attachment_id ) {
  ksort($sources);
  return $sources;
}
