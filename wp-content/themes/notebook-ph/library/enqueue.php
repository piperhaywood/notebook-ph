<?php

add_action( 'wp_enqueue_scripts', 'nph_assets' );
function nph_assets() {
  $version = nph_get_theme_version();

  wp_register_style(
    'nph-styles',
    get_template_directory_uri() . '/style.css',
    '',
    $version,
    'all'
  );
  wp_enqueue_style( 'nph-styles' );

  if ( file_exists( get_template_directory() . '/fonts.css' ) ) {
    wp_register_style(
      'nph-fonts',
      get_template_directory_uri() . '/fonts.css',
      '',
      $version,
      'all'
    );
    wp_enqueue_style( 'nph-fonts');
  }

  // wp_register_script(
  //   'modernizr',
  //   get_template_directory_uri() . '/assets/js/vendor/modernizr.js',
  //   '2.8.3',
  //   false
  // );
  // wp_enqueue_script( 'modernizr' );

  wp_register_script(
    'nph-scripts',
    get_template_directory_uri() . '/scripts.js',
    '',
    $version,
    true
  );
  wp_enqueue_script( 'nph-scripts' );
}

add_action( 'wp_head', 'nph_tag_css' );
function nph_tag_css() {
  $css = '';
  $tags = get_tags();
  if( !empty( $tags ) )  {
    $args = array( 'orderby' => 'count', 'number' => 1 );
    $least = get_tags( $args );
    $min_in = $least[0]->count;

    $args['order'] = 'DESC';
    $most = get_tags( $args );
    $max_in = $most[0]->count;
    $max_in = 8;

    $max_out = 1;
    $min_out = 0.2;

    foreach( $tags as $tag ) {
      $opacity = ( ( ( $tag->count - $min_in ) / ( $max_in - $min_in ) ) * ( $max_out - $min_out ) ) + $min_out;
      $color = 'rgba(0,0,0,' . $opacity . ')';
      $css .= '.post__tag--' . $tag->slug . ' .post__tag__btn{background:' . $color . ';border:1.5px solid white;}';
      $css .= '.post__tag--' . $tag->slug . ' .post__tag__btn:hover{color:' . $color . ';background:white;border:1.5px solid ' . $color . ';}';
    }
  }
  echo '<style>' . $css . '</style>';
}
