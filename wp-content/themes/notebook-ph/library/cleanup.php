<?php

add_action('after_setup_theme','start_cleanup');
function start_cleanup() {
  add_action('init', 'cleanup_head');
  add_filter('the_generator', 'remove_rss_version');
  add_filter('gallery_style', 'gallery_style');
  add_filter('the_content', 'img_unautop', 30);
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
  add_filter('login_errors', create_function('$a', "return null;"));
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

add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');
function fixed_img_caption_shortcode($attr, $content = null) {
  if (! isset($attr['caption'])) {
    if (preg_match('#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches)) {
      $content = $matches[1];
      $attr['caption'] = trim($matches[2]);
    }
  }
  $output = apply_filters('img_caption_shortcode', '', $attr, $content);
  if ($output != '')
    return $output;
  extract(shortcode_atts(array(
    'id'      => '',
    'align'   => 'alignnone',
    'width'   => '',
    'caption' => '',
    'class'   => ''
  ), $attr));
  if (1 > (int) $width || empty($caption))
    return $content;

  $markup = '<figure';
  if ($id) $markup .= ' id="' . esc_attr($id) . '"';
  if ($class) $markup .= ' class="' . esc_attr($class) . '"';
  $markup .= '>';
  $markup .= do_shortcode($content) . '<figcaption>' . $caption . '</figcaption></figure>';
  return $markup;
}

function img_unautop($pee) {
  $pee = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '$1', $pee);
  return $pee;
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