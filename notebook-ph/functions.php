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

add_shortcode('notebooklist', 'notebook_list');
function notebook_list() {
  return nph_get_list();
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
          <?php $label = $char == '#' ? esc_attr__('a number', 'notebook-ph') : $char; ?>
          <?php $label = sprintf(esc_attr__('Terms beginning with %s', 'notebook-ph'), $label); ?>
          <h2 aria-label="<?php echo $label; ?>"><?php echo apply_filters( 'the_title', $char ); ?></h2>
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
      $return .= '<p>' . strip_tags($intro, '<em><a><img><br>') . '</p>';
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
  $page = $paged > 0 ? ', ' . _x('p.', 'paged', 'notebook-ph') . $paged : '';
  $text = '';
  if (is_front_page()) {
    $text = get_bloginfo('name');
    $label = $text;
  } elseif (is_tax('post_format')) {
    $var = get_post_format();
    $text = '<span class="term term--post_format">' . $var . '</span>';
  } elseif (is_tag()) {
    $var = single_tag_title('', false );
    $text = '<span class="term term--post_tag">' . $var . '</span>';
  } elseif (is_category()) {
    $var = single_cat_title('', false);
    $text = '<span class="term term--category">' . $var . '</span>';
  } elseif (is_search()) {
    $query = get_query_var('s');
    $text = sprintf(__('&ldquo;%s&rdquo;', 'notebook-ph'), $query);
  } elseif (is_author()) {
    $var = get_the_author_meta('display_name', get_query_var('author'));
    $text = sprintf(__('by %s', 'notebook-ph'), $var);
  } elseif (is_month()) {
    $var = get_the_date('F Y');
    $text = $var;
  } elseif (is_year()) {
    $var = get_the_date('Y');
    $text = $var;
  }

  $title = $text . $page . '&nbsp;<span class="term__count">' . $wp_query->found_posts . '</span>';

  return $title;
}

function nph_archive_label() {
  global $wp_query;
  if (is_singular()) {
    return get_the_title();
  }
  if (is_404()) {
    return __('Page not found [404 error]', 'notebook-ph');
  }
  $paged = get_query_var('paged');
  $page = $paged > 0 ? ', ' . sprintf(__('page %s', 'notebook-ph'), $paged) : '';
  $label = false;
  if (is_front_page()) {
    $label = get_bloginfo('name');
  } elseif (is_tax('post_format')) {
    $var = get_post_format();
    $label = sprintf(__('Format: %s', 'notebook-ph'), $var);
  } elseif (is_tag()) {
    $var = single_tag_title('', false );
    $label = sprintf(__('Tag: %s', 'notebook-ph'), $var);
  } elseif (is_category()) {
    $var = single_cat_title('', false);
    $label = sprintf(__('Category: %s', 'notebook-ph'), $var);
  } elseif (is_search()) {
    $query = get_query_var('s');
    $label = sprintf(__('You searched for &ldquo;%s&rdquo;', 'notebook-ph'), $query);
  } elseif (is_author()) {
    $var = get_the_author_meta('display_name', get_query_var('author'));
    $label = sprintf(__('Author: %s', 'notebook-ph'), $var);
  } elseif (is_month()) {
    $var = get_the_date('F Y');
    $label = sprintf(__('Month: %s', 'notebook-ph'), $var);
  } elseif (is_year()) {
    $var = get_the_date('Y');
    $label = sprintf(__('Year: %s', 'notebook-ph'), $var);
  }

  $label = $label . $page . ' &mdash; ' . sprintf(_n('%s post', '%s posts', $wp_query->found_posts, 'notebook-ph'), $wp_query->found_posts);

  return $label;
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
    return 'hsl(1, 100%, 0%)';
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

function nph_get_list($posts = false) {
  global $post;
  if (!$posts) {
    $posts = get_posts(array(
      'posts_per_page' => -1
    ));
  }
  if ($posts) {
    ob_start(); ?>
    <div class="container container--large">
      <ul class="post-index">
        <?php foreach ($posts as $post) : ?>
          <?php setup_postdata($post); ?>
          <?php $format = get_post_format(); ?>
          <?php $hsl = nph_get_hsl($post); ?>
          <?php $images = get_attached_media( 'image' ); ?>
          <?php
          if (!$format) {
            $excerpt = get_the_title();
          } else {
            $excerpt = strip_tags(get_the_excerpt());
            $excerpt = $excerpt == '&nbsp;' ? false : $excerpt;
            $excerpt = $excerpt ? $excerpt : get_the_title();
          }
          ?>
          <li class="post-index__post-item post-item" style="--color:<?php echo $hsl; ?>;">
            <a class="post-item__link" href="<?php the_permalink(); ?>"
              aria-label="<?php printf(esc_attr__('Visit post published %s titled “%s”', 'notebook-ph'), get_the_date('d F Y'), get_the_title()); ?>">
              <time class="post-item__time" datetime="<?php echo nph_date(true, false); ?>"><?php echo get_the_date('d M Y'); ?></time>
              <span>&mdash;</span>
              <?php if (has_post_thumbnail($post)) : ?>
                <?php echo nph_list_thumb($post, 'thumbnail'); ?>
              <?php endif; ?>
              <div class="post-item__text"><?php echo $excerpt; ?></div>
            </a>
          </li>
          <?php wp_reset_postdata(); ?>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php return ob_get_clean();
  }
}

function nph_list_thumb($post, $size = 'thumbnail') {
  add_filter('wp_calculate_image_srcset_meta', '__return_null');
  $html = get_the_post_thumbnail($post, $size, array('loading' => 'lazy', 'class' => 'post-item__image'));
  remove_filter('wp_calculate_image_srcset_meta', '__return_null');
  return $html;
}

function nph_comment($comment, $args, $depth) {
  if ( 'div' === $args['style'] ) {
    $tag       = 'div';
    $add_below = 'comment';
  } else {
    $tag       = 'li';
    $add_below = 'div-comment';
  }?>
  <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>"><?php 
  if ( 'div' != $args['style'] ) { ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
  } ?>
    <div class="comment-avatar">
      <?php
        if ( $args['avatar_size'] != 0 ) {
          echo get_avatar( $comment, $args['avatar_size'] ); 
        }
      ?>
    </div>
    <div class="comment-author vcard">
        <?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>, 
      <span class="comment-meta commentmetadata">
        <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php
          /* translators: 1: date, 2: time */
          printf( 
            __('%1$s at %2$s'),
            get_comment_date(),
            get_comment_time()
          ); ?>
        </a>
      </span><?php edit_comment_link( __( 'Edit' ), ' / ', '' ); ?>
    </div>

    <div class="comment-content prose">
      <?php if ( $comment->comment_approved == '0' ) : ?>
        <p><em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em></p>
      <?php endif; ?>
      <?php comment_text(); ?>
    </div>

    <div class="reply"><?php
      comment_reply_link(
        array_merge(
          $args,
          array(
            'add_below' => $add_below,
            'depth'     => $depth,
            'max_depth' => $args['max_depth']
          )
        )
      ); ?>
    </div><?php
  if ( 'div' != $args['style'] ) : ?>
    </div><?php
  endif;
}