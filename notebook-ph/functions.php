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

add_shortcode('notebooksearch', 'get_search_form');

add_shortcode('notebookindex', 'notebook_index');
function notebook_index($attr) {
  $a = shortcode_atts(array(
    'taxonomy' => 'post_tag, category, post_format',
    'years' => 'true',
    'count' => '1',
  ), $attr);
  $taxonomy = explode(',', str_replace(', ', ',', $a['taxonomy']));
  $showYears = ($a['years'] === 'true');
  $count = intval($a['count']);
  return get_notebook_index($taxonomy, $showYears, $count);
}

function get_notebook_index($taxonomy, $showYears, $count) {
  // Set up the index groups
  $groups = array(); 

  // Add the terms to the index
  $terms = get_terms(array(
    'taxonomy' => $taxonomy
  ));
  if ($terms && is_array($terms)) {
    foreach ($terms as $term) {
      if ($term->count >= $count) {
        // NOTE strip "post-format-" from slug, for some reason this gets included
        $slug = str_replace('post-format-', '', $term->slug);
        $tax = get_taxonomy($term->taxonomy);
        $groups = nph_add_to_index($groups, array(
          'name' => $term->name,
          'url' => get_tag_link($term->term_id),
          'count' => $term->count,
          'slug' => $slug,
          'type' => $term->taxonomy,
          'aria' => sprintf(esc_html__('%s: %s, %s posts', 'notebook-ph'), $tax->labels->singular_name, $term->name, $term->count)
        ));
      }
    }
  }

  // Add the year archives to the index
  if ($showYears) {
    $years = nph_get_years_array();
    if ($years) {
      $args = array(
        'posts_per_page' => -1,
        'post_type' => 'post',
        'fields' => 'ids'
      );
      foreach ($years as $year) {
        $args['date_query'] = array(
          array('year' => $year)
        );
        $posts = get_posts($args);
        $yearCount = count($posts);
        if ($yearCount >= $count ) {
          $groups = nph_add_to_index($groups, array(
            'name' => $year,
            'url' => get_year_link($year),
            'count' => $yearCount,
            'slug' => $year,
            'type' => 'year',
            'aria' => sprintf(esc_html__('Year: %s, %s posts', 'notebook-ph'), $year, $yearCount)
          ));
        }
      }
    }
  }

  ob_start(); ?>
    <?php if (!empty($groups)) : ?>
    <div class="container container--full">
      <div class="termindex">
        <?php foreach ($groups as $char => $terms) : ?>
          <?php ksort($terms); ?>
          <h2><?php echo apply_filters( 'the_title', $char ); ?></h2>
          <ol>
          <?php foreach ($terms as $slug => $term) : ?>
            <li>
              <a aria-label="<?php echo $term['aria']; ?>" href="<?php echo $term['url']; ?>"><span class="term term--<?php echo $term['type']; ?>"><?php echo $term['name']; ?></span>&nbsp;<span class="term__count"><?php echo $term['count']; ?></span></a>
            </li>
          <?php endforeach; ?>
          </ol>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  <?php return ob_get_clean();
}

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

function nph_archivedesc($echo = true, $prefix = '', $suffix = '') {
  global $wp_query;
  $total = $wp_query->found_posts;
  $return = '';
  if (is_tag()) {
    $return .= tag_description();
  } elseif (is_category()) {
    $return .= category_description();
  } elseif (is_author()) {
    $return .= '<p>' . get_the_author_meta('description') . '</p>';
  } elseif (is_home()) {
    $intro = get_theme_mod('nph_blog_intro');
    if ($intro) {
      $return .= '<p class="copyright">' . strip_tags($intro, '<em><a><img><br>') . '</p>';
    }
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
  global $wp_query;
  if (is_singular()) {
    return get_the_title();
  }
  if (is_404()) {
    return __('Page not found [404 error]', 'notebook-ph');
  }
  $paged = get_query_var('paged');
  $page = $paged > 0 ? ' ' . _x('p.', 'paged', 'notebook-ph') . $paged : null;
  if (is_front_page()) {
    $title = get_bloginfo('name');
    $total = null;
  } elseif (is_tax('post_format')) {
    $title = '<span class="term term--post_format">' . get_post_format() . '</span>';
  } elseif (is_tag()) {
    $title = '<span class="term term--post_tag">' . single_tag_title('', false ) . '</span>';
  } elseif (is_category()) {
    $title = '<span class="term term--category">' . single_cat_title('', false) . '</span>';
  } elseif (is_search()) {
    $title = sprintf(__('&ldquo;%s&rdquo;', 'notebook-ph'), get_query_var('s'));
  } elseif (is_author()) {
    $title = 'by ' . get_the_author_meta('display_name', get_query_var('author'));
  } elseif (is_month()) {
    $title = get_the_date('F Y');
  } elseif (is_year()) {
    $title = get_the_date('Y');
  }
  $title = $title . '  <span class="term__count">' . $wp_query->found_posts . '</span>';
  return $title . $page;
}

function nph_get_copyright() {
  $copy = '';
  if (is_single()) {
    $copy .= get_the_date('Y');
  } else {
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
  }
  $copy = '&copy; ' . $copy;
  return $copy;
}

function nph_tag_opacity($tag, $max_opacity = 1, $min_opacity = .1) {
  $opacity = 1;
  $args = array('orderby' => 'count', 'number' => 1);
  $tags = get_tags($args);
  $min_in = $tags[0]->count;
  $tags = array_reverse($tags);
  $max_in = $tags[0]->count;
  $max_in = 8;
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

function nph_get_hsl($hsl_post = false) {
  if (!$hsl_post) {
    return 'hsl(1, 100, 0)';
  }
  $unix = get_the_date('U', $hsl_post->ID);
  $hue = nph_map_hue('Europe/London', 51.567592, $unix);
  $hsl = sprintf('hsl(%s, 70%%, 50%%)', $hue);
  return $hsl;
}

function nph_group_posts_by_year() {
  global $post;
  $years = array();
  $posts = get_posts(array(
    'posts_per_page' => -1
  ));
  foreach ($posts as $post) {
    setup_postdata($post);
    $year = get_the_date('Y');
    if (!isset($years[$year])) {
      $years[$year] = array();
    }
    $years[$year][] = array(
      'title' => get_the_title(),
      'permalink' => get_the_permalink(),
      'hsl' => nph_get_hsl($post),
      'id' => get_the_id($post)
    );
  }
  wp_reset_postdata();
  return $years;
}

function nph_get_years_array() {
  global $wpdb;
  $result = array();
  $years = $wpdb->get_results(
    $wpdb->prepare(
      "SELECT YEAR(post_date) FROM {$wpdb->posts} WHERE post_status = %s GROUP BY YEAR(post_date) DESC",
      array('publish')
    ),
    ARRAY_N
  );
  if (is_array($years) && count($years) > 0) {
    foreach ($years as $year) {
      $result[] = $year[0];
    }
  }
  return $result;
}

function nph_add_to_index($groups, $args) {
  $first_char = strtoupper($args['name'][0]);
  if (is_numeric($first_char)) {
    $first_char = '#';
  } elseif (mb_detect_encoding($first_char) == 'UTF-8') {
    $first_char = '?';
  }
  $groups[$first_char][$args['slug']] = $args;
  return $groups;
}
