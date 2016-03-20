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

function hex2rgb( $hex ) {
  $hex = str_replace( "#", "", $hex );
  if( strlen( $hex ) == 3 ) {
    $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
    $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
    $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
  } else {
    $r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );
  }
  $rgb = array( $r, $g, $b );
  return implode( ",", $rgb );
}

function nph_pagetype( $echo = true ) {
  $class = is_singular() ? 'permalink' : '';
  if( $echo === true ) {
    echo $class;
  } else {
    return $class;
  }
}

function nph_permalink( $echo = true, $prefix = '', $link_text = '', $suffix = '' ) {
  $return = '';

  if( !is_singular() ) {
    $return = $prefix . '<a href="' . get_the_permalink() . '">' . $link_text . '</a>' . $suffix;
  }

  if( $echo === true ) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_editlink( $echo = true, $prefix = '', $link_text = '', $suffix = '' ) {
  $return = '';

  if( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
    $return = $prefix . '<a href="' . get_edit_post_link() . '">' . $link_text . '</a>' . $suffix;
  }

  if( $echo === true ) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_format_plural( $echo = true ) {
  $return = '';

  $format = get_post_format();
  if( $format == 'image' ) :
    $return = 'Images';
  elseif( $format == 'quote' ) :
    $return = 'Quotes';
  elseif( $format == 'aside' ) :
    $return = 'Asides';
  elseif( $format == 'gallery' ) :
    $return = 'Galleries';
  elseif( $format == 'audio' ) :
    $return = 'Audio';
  elseif( $format == 'video' ) :
    $return = 'Videos';
  elseif( $format == 'chat' ) :
    $return = 'Chat threads';
  elseif( $format == 'link' ) :
    $return = 'Links';
  else :
    $return = 'Standard posts';
  endif;

  if( $echo === true ) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_date( $format = false, $echo = true ) {
  if ( !$format ) {
    $date = get_the_date();
  } else {
    $str = 'Y-m-d H:i:s';
    $date = get_the_date( $str );
    $date = DateTime::createFromFormat( $str, $date );
    $date = $date->format( DateTime::RFC3339 );
  }

  if( $echo === true ) {
    echo $date;
  } else {
    return $date;
  }
}

function nph_title( $echo = true ) {
  $title = get_the_title();
  if( empty( $title ) ) {
    return;
  }

  if( !is_singular() ) {
    $title = '<a href="' . get_the_permalink() . '">' . $title . '</a>';
  }

  $title = '<h1 class="title">' . $title . '</h1>';

  if( $echo === true ) {
    echo $title;
  } else {
    return $title;
  }
}

function nph_categories( $echo = true ) {
  $return = '';
  $cat_arr = array();

  $cats = get_the_category();
  if( empty( $cats ) ) {
    return;
  }

  foreach( $cats as $cat ) {
    $cat_arr[$cat->term_id] = '<a href="' . get_category_link( $cat->term_id ) . '">' . strtolower( $cat->name ) . '</a>';
  }

  $default = get_option( 'default_category' );
  unset( $cat_arr[$default] );

  if( !empty( $cat_arr ) ) {
    $last = array_pop( $cat_arr );
    $return .= !empty( $cat_arr ) ? implode( $cat_arr, ', ' ) . ' ' . __( 'and', 'notebook-ph' ) . ' ' : '';
    $return .= $last;
  }

  if( $echo === true ) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_author( $echo = true ) {
  $return = '';

  $id = get_the_author_meta( 'ID' );
  $name = get_the_author_meta( 'display_name' );

  if( $id && $name ) {
    $return .= '<a href="' . get_author_posts_url( $id ) . '">' . $name . '</a>';
  }

  if( $echo === true ) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_postformat( $echo = true ) {
  $return = '';

  $format = get_post_format();
  if ( $format != false ) {
    $return = '<a href="' . get_post_format_link( $format ) . '">' . ucfirst( $format ) . '</a>';
  }

  if( $echo === true ) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_postmeta( $echo = true ) {
  $return = '';

  $cats = nph_categories( false );
  $format = nph_postformat( false );

  $return .= !empty($format) ? $format . ' ' . __( 'posted', 'notebook-ph' ) : __( 'Posted', 'notebook-ph' );

  $return .=  ' ';
  $return .= '<span class="date"><time datetime="' . nph_date( true, false ) . '">' . nph_date( false, false ) . '</time></span>';
  $return .= '<span class="author"> ' . __( 'by', 'notebook-ph' ) . ' ' . nph_author( false ) . '</span>';
  $return .= !empty( $cats ) ? '<span class="categories"> ' . __( 'in', 'notebook-ph' ) . ' ' . $cats . '</span>': '';
  $return .= '. ';
  $return .= nph_permalink( false, '', 'Visit permalink', '. ' );
  $return .= nph_editlink( false, '', 'Edit post', '. ' );

  if( $echo === true ) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_subtitle( $echo = true, $prefix = '', $suffix = '' ) {
  $return = '';
  if( is_tag() ) {
    $term = get_term_by( 'id', get_query_var('tag_id'), 'post_tag' );
    $return .= '<ul class="post-tags">';
    $return .= '<li class="tag_' . $term->slug . '">';
    $return .= '<a href="' . get_tag_link( $term ) . '">' . $term->name . '</a>';
    $return .= '</li>';
    $return .= '</ul>';
  } elseif( is_category() ) {
    $return = single_cat_title('', false);
  } elseif( is_search() ) {
    $return = '&ldquo;' . get_query_var('s') . '&rdquo;';
  } elseif( is_tax( 'post_format' ) ) {
    $return = nph_format_plural( false );
  } elseif( is_author() ) {
    $return = 'By ' . get_the_author_meta( 'display_name', get_query_var( 'author' ) );
  } elseif( is_month() ) {
    $return = get_the_date( 'F Y' );
  } elseif( is_year() ) {
    $return = get_the_date( 'Y' );
  }

  $return = !empty( $return ) ? $prefix . $return . $suffix : '';

  if( $echo === true ) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_archivedesc( $echo = true, $prefix = '', $suffix = '' ) {
  $return = '';
  if( is_tag() ) {
    $return = tag_description();
  } elseif( is_category() ) {
    $return = category_description();
  } elseif( is_author() ) {
    $return = '<p>' . get_the_author_meta( 'description' ) . '</p>';
  }

  $return = !empty( $return ) ? $prefix . $return . $suffix : '';

  if( $echo === true ) {
    echo $return;
  } else {
    return $return;
  }
}

function nph_get_theme_version() {
  $version = '1';
  $theme = wp_get_theme();
  if ( ! $theme->exists() ) {
    return;
  }
  $version = $theme->get( 'Version' );
  return $version;
}