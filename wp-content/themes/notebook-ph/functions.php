<?php

/*
Author: Piper Haywood
URL: http://piperhaywood.com
*/

require_once('library/cleanup.php');
require_once('library/navigation.php');
require_once('library/enqueue.php');
require_once('library/theme-support.php');
require_once('library/customizer.php');
require_once('library/search-functions.php');

function hex2rgb($hex) {
  $hex = str_replace("#", "", $hex);
  if (strlen($hex) == 3) {
    $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
    $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
    $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
  } else {
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
  }
  $rgb = array($r, $g, $b);
  return implode(",", $rgb);
}

function nph_pagetype($echo = true) {
  $class = is_singular() ? 'permalink' : '';
  if ($echo === true) {
    echo $class;
  } else {
    return $class;
  }
}

function nph_permalink($echo = true, $prefix = '', $link_text = '', $suffix = '') {
  $return = '';

  if (!is_singular()) {
    $return = $prefix . '<a href="' . get_the_permalink() . '">' . $link_text . '</a>' . $suffix;
  }

  if ($echo === true) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_editlink($echo = true, $prefix = '', $link_text = '', $suffix = '') {
  $return = '';

  if (is_user_logged_in() && current_user_can('edit_posts')) {
    $return = $prefix . '<a href="' . get_edit_post_link() . '">' . $link_text . '</a>' . $suffix;
  }

  if ($echo === true) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_format_plural($echo = true) {
  $return = '';

  $format = get_post_format();
  if ($format == 'image') :
    $return = 'Images';
  elseif ($format == 'quote') :
    $return = 'Quotes';
  elseif ($format == 'aside') :
    $return = 'Asides';
  elseif ($format == 'gallery') :
    $return = 'Galleries';
  elseif ($format == 'audio') :
    $return = 'Audio';
  elseif ($format == 'video') :
    $return = 'Videos';
  elseif ($format == 'chat') :
    $return = 'Chat threads';
  elseif ($format == 'link') :
    $return = 'Links';
  else :
    $return = get_posts_label(true);
  endif;

  if ($echo === true) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_date($format = false, $echo = true) {
  if (!$format) {
    $date = get_the_date();
  } else {
    $str = 'Y-m-d H:i:s';
    $date = get_the_date($str);
    $date = DateTime::createFromFormat($str, $date);
    $date = $date->format(DateTime::RFC3339);
  }

  if ($echo === true) {
    echo $date;
  } else {
    return $date;
  }
}

function nph_title($echo = true) {
  $title = get_the_title();
  if (empty($title)) {
    return;
  }

  if (!is_singular()) {
    $title = '<a href="' . get_the_permalink() . '">' . $title . '</a>';
  }

  if ($echo === true) {
    echo $title;
  } else {
    return $title;
  }
}

function nph_categories($echo = true) {
  $return = '';
  $cat_arr = array();

  $cats = get_the_category();
  if (empty($cats)) {
    return;
  }

  foreach($cats as $cat) {
    $cat_arr[$cat->term_id] = '<a href="' . get_category_link($cat->term_id) . '">' . strtolower($cat->name) . '</a>';
  }

  $default = get_option('default_category');
  unset($cat_arr[$default]);

  if (!empty($cat_arr)) {
    $last = array_pop($cat_arr);
    $return .= !empty($cat_arr) ? implode($cat_arr, ', ') . ' ' . __('and', 'notebook-ph') . ' ' : '';
    $return .= $last;
  }

  if ($echo === true) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_author($echo = true) {
  $return = '';

  $id = get_the_author_meta('ID');
  $name = get_the_author_meta('display_name');

  if ($id && $name) {
    $return .= '<a href="' . get_author_posts_url($id) . '">' . $name . '</a>';
  }

  if ($echo === true) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_postformat($echo = true) {
  $return = '';

  $format = get_post_format();
  if ($format != false) {
    $return = '<a href="' . get_post_format_link($format) . '">' . ucfirst($format) . '</a>';
  }

  if ($echo === true) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_postmeta($echo = true) {
  $return = '';

  $cats = nph_categories(false);
  $format = nph_postformat(false);

  $return .= !empty($format) ? $format . ' ' . __('posted', 'notebook-ph') : __('Posted', 'notebook-ph');

  $return .=  ' ';
  $return .= '<span class="date"><time datetime="' . nph_date(true, false) . '">' . nph_permalink(false, '', nph_date(false, false)) . '</time></span>';
  $return .= '<span class="author"> ' . __('by', 'notebook-ph') . ' ' . nph_author(false) . '</span>';
  $return .= !empty($cats) ? '<span class="categories"> ' . __('in', 'notebook-ph') . ' ' . $cats . '</span>': '';
  // $return .= '. ';
  // $return .= nph_permalink(false, '', __('Visit permalink', 'notebook-ph'), '&nbsp;&rarr; ');
  $return .= nph_editlink(false, ' (', __('edit', 'notebook-ph'), ')');

  if ($echo === true) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_subtitle($echo = true, $prefix = '', $suffix = '') {
  $return = '';
  if (is_tag()) {
    $term = get_term_by('id', get_query_var('tag_id'), 'post_tag');
    $return .= '<ul class="post__tags">';
    $return .= '<li class="post__tag post__tag--' . $term->slug . '">';
    $return .= '<a class="post__tag__btn" href="' . get_tag_link($term) . '">' . $term->name . '</a>';
    $return .= '</li>';
    $return .= '</ul>';
  } elseif (is_category()) {
    $return = single_cat_title('', false);
  } elseif (is_search()) {
    $return = '&ldquo;' . get_query_var('s') . '&rdquo;';
  } elseif (is_tax('post_format')) {
    $return = nph_format_plural(false);
  } elseif (is_author()) {
    $return = 'By ' . get_the_author_meta('display_name', get_query_var('author'));
  } elseif (is_month()) {
    $return = get_the_date('F Y');
  } elseif (is_year()) {
    $return = get_the_date('Y');
  }

  $return = !empty($return) ? $prefix . $return . $suffix : '';

  if ($echo === true) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_archivedesc($echo = true, $prefix = '', $suffix = '') {
  $return = '';
  if (is_tag()) {
    $return = tag_description();
  } elseif (is_category()) {
    $return = category_description();
  } elseif (is_author()) {
    $return = '<p>' . get_the_author_meta('description') . '</p>';
  }

  $return = !empty($return) ? $prefix . $return . $suffix : '';

  if ($echo === true) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_get_theme_version() {
  $version = '1';
  $theme = wp_get_theme();
  if (! $theme->exists()) {
    return;
  }
  $version = $theme->get('Version');
  return $version;
}

function nph_archive_str() {
  if (is_singular()) {
    return get_the_title();
  }
  if (is_404()) {
    return 'Page not found <code>404 error</code>';
  }
  global $wp_query;

  $return = '';

  $ppp = get_option('posts_per_page');
  $total = $wp_query->found_posts;
  $paged = get_query_var('paged');
  $plural = true;
  if ($ppp >= $total && $paged == 0) {
    $return .= $total . ' ';
    $plural = $total > 1 ? true : false;
  } else {
    $min = 1;
    $max = $ppp;
    if ($paged > 0) {
      $min = $ppp * $paged + $min;
      $max = $min + $ppp - 1;
      if ($max > $total) {
        $max = $total;
      }
    }
    if ($total != $max) {
      $return .= $min . '&ndash;' . $max;
    } else {
      $return .= 'last';
    }
    $return .= ' of ' . $total . ' ';
  }

  if (is_search()) {
    if ($total <= 0) {
      return 'No search results for query &ldquo;' . get_query_var('s') . '&rdquo;';
    }
    $return .= 'search ';
    $return .= $plural ? 'results' : 'result';
    $return .= ' for query &ldquo;' . get_query_var('s') . '&rdquo;';
  } else {
    if (is_tax('post_format')) {
      $return .= '[' . get_post_format() . '] type ' . get_posts_label($plural);
    } else {
      $return .= get_posts_label($plural);
      if (is_tag()) {
        $term = get_term_by('id', get_query_var('tag_id'), 'post_tag');
        $return .= ' tagged #' . $term->slug;
      } elseif (is_category()) {
        $return .= ' in category &ldquo;' . single_cat_title('', false) . '&rdquo;';
      } elseif (is_search()) {
        $return .= ' for query &ldquo;' . get_query_var('s') . '&rdquo;';
      } elseif (is_author()) {
        $return .= ' by ' . get_the_author_meta('display_name', get_query_var('author'));
      } elseif (is_month()) {
        $return .= ' published in ' . get_the_date('F Y');
      } elseif (is_year()) {
        $return .= ' published in ' . get_the_date('Y');
      }
    }
  }
  $return = !empty($return) ? 'Showing ' . $return . '. ' : '';
  return $return;
}

function nph_get_copyright() {
  $copy = '';
  $args = array(
    'order' => 'ASC',
    'posts_per_page' => 1,
    'post_type' => 'any',
    'post_status' => 'publish,private,draft'
  );
  $posts_array = get_posts($args);
  if (!empty($posts_array)) {
    $copy .= get_the_date('Y', $posts_array[0]->ID) . '&ndash;';
  }
  $copy .= date('Y');
  $copy = '&copy; ' . $copy;
  return $copy;
}

function get_posts_label($plural = false) {
  if ($plural) {
    return __('notes', 'notebook-ph');
  } else {
    return __('note', 'notebook-ph');
  }
}

function nph_get_navigation($menu_name) {
  $menu_items = false;

  $menu = wp_get_nav_menu_object($menu_name);
  if ($menu) {
    $menu_items = wp_get_nav_menu_items($menu->term_id);
  }

  return $menu_items;
}

function nph_tag_opacity($tag, $max_opacity = .8, $min_opacity = .2) {
  $opacity = 1;
  $args = array('orderby' => 'count', 'number' => 1);
  $least = get_tags($args);
  $min_in = $least[0]->count;
  $args['order'] = 'DESC';
  $most = get_tags($args);
  $max_in = $most[0]->count;
  $max_in = 15;
  $count = $tag->count > $max_in ? $max_in : $tag->count;

  $percentage = ($count - $min_in) / ($max_in - $min_in);

  $opacity = $percentage * ($max_opacity - $min_opacity) + $min_opacity;
  return round($opacity, 4);
}

function nph_map_hue($timezone, $lat, $unix) {
  $tz = new DateTimeZone($timezone);
  $datetime = DateTime::createFromFormat('U', $unix);
  $datetime->setTimezone($tz);
  $dayofyear = $datetime->format('z');
  $june_dt = DateTime::createFromFormat('Y-m-d', $datetime->format('Y') . '-06-22');
  $june_dt->setTimezone($tz);
  $june_doy = $june_dt->format('z');
  $last_dt = DateTime::createFromFormat('Y-m-d', $datetime->format('Y') . '-12-31');
  $last_dt->setTimezone($tz);
  $last_doy = $last_dt->format('z');
  $offset = $lat > 0 ? 52 : 200;
  if ($dayofyear < $june_doy) {
    $diff = $dayofyear + ($last_doy - $june_doy);
  } else {
    $diff = $dayofyear - $june_doy;
  }

  $return = 0 - $diff;
  $return = $return + $offset;
  $return = $return < 0 ? $return + 360 : $return;
  return $return;
}

// function nph_get_bg_hsl($hue) {
//   $hsl = sprintf('hsl(%1$s, 100%, %2$s)', $hue, )
//   return $hsl;
// }