<?php

add_action('after_setup_theme','start_cleanup');
function start_cleanup() {
  add_action('init', 'cleanup_head');
  add_filter('the_generator', 'remove_rss_version');
  add_filter('gallery_style', 'gallery_style');
}

function addBackPostFeed() {
  echo '<link rel="alternate" type="application/rss+xml" title="' . get_bloginfo('name') . '" href="'.get_bloginfo('rss2_url').'" />'; 
}

function cleanup_head() {
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'feed_links', 2);
  add_action('wp_head', 'addBackPostFeed');
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

add_filter('wp_calculate_image_sizes', 'nph_sizes');
function nph_sizes() {
  return '(max-width: 638px) 100vw, 638px';
}

// Accounts for Wordpress incorrect srcset order
add_filter( 'wp_calculate_image_srcset', 'ph_adjust_srcset', 10, 5 );
function ph_adjust_srcset( $sources, $size_array, $image_src, $image_meta, $attachment_id ) {
  ksort($sources);
  return $sources;
}

// First, make sure Jetpack doesn't concatenate all its CSS
add_filter( 'jetpack_implode_frontend_css', '__return_false' );

// Then, remove each CSS file, one at a time
function jeherve_remove_all_jp_css() {
  wp_deregister_style( 'AtD_style' ); // After the Deadline
  wp_deregister_style( 'jetpack_likes' ); // Likes
  wp_deregister_style( 'jetpack_related-posts' ); //Related Posts
  wp_deregister_style( 'jetpack-carousel' ); // Carousel
  wp_deregister_style( 'grunion.css' ); // Grunion contact form
  wp_deregister_style( 'the-neverending-homepage' ); // Infinite Scroll
  wp_deregister_style( 'infinity-twentyten' ); // Infinite Scroll - Twentyten Theme
  wp_deregister_style( 'infinity-twentyeleven' ); // Infinite Scroll - Twentyeleven Theme
  wp_deregister_style( 'infinity-twentytwelve' ); // Infinite Scroll - Twentytwelve Theme
  wp_deregister_style( 'noticons' ); // Notes
  wp_deregister_style( 'post-by-email' ); // Post by Email
  wp_deregister_style( 'publicize' ); // Publicize
  wp_deregister_style( 'sharedaddy' ); // Sharedaddy
  wp_deregister_style( 'sharing' ); // Sharedaddy Sharing
  wp_deregister_style( 'stats_reports_css' ); // Stats
  wp_deregister_style( 'jetpack-widgets' ); // Widgets
  wp_deregister_style( 'jetpack-slideshow' ); // Slideshows
  wp_deregister_style( 'presentations' ); // Presentation shortcode
  wp_deregister_style( 'jetpack-subscriptions' ); // Subscriptions
  wp_deregister_style( 'tiled-gallery' ); // Tiled Galleries
  wp_deregister_style( 'widget-conditions' ); // Widget Visibility
  wp_deregister_style( 'jetpack_display_posts_widget' ); // Display Posts Widget
  wp_deregister_style( 'gravatar-profile-widget' ); // Gravatar Widget
  wp_deregister_style( 'widget-grid-and-list' ); // Top Posts widget
  wp_deregister_style( 'jetpack-widgets' ); // Widgets
}
add_action('wp_print_styles', 'jeherve_remove_all_jp_css' );

add_filter( 'wp', 'jetpackme_remove_rp', 20 );
function jetpackme_remove_rp() {
  if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
    $jprp = Jetpack_RelatedPosts::init();
    $callback = array( $jprp, 'filter_add_target_to_dom' );
    remove_filter( 'the_content', $callback, 40 );
  }
}