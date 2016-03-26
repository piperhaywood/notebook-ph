<?php

add_action( 'customize_register', 'nph_customize_register' );
function nph_customize_register( $wp_customize ) {

  // COLORS
  $wp_customize->add_setting(
    'nph_header_color',
    array(
      'default'     => '#FFFFFF',
      'transport'   => 'postMessage'
    )
  );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'header_color',
      array(
        'label'      => __( 'Header Color', 'notebook-ph' ),
        'section'    => 'colors',
        'settings'   => 'nph_header_color'
      )
    )
  );

  // DISPLAY OPTIONS
  $wp_customize->add_section(
    'nph_display_options',
    array(
      'title'     => __( 'Display Options', 'notebook-ph' ),
      'priority'  => 200
    )
  );

  $wp_customize->add_setting(
    'nph_display_name',
    array(
      'default'   =>  get_bloginfo( 'name' ),
      'type'      =>  'option',
      'transport' =>  'refresh',
      'sanitize_callback' => 'sanitize_text_field'
    )
  );
  
  $wp_customize->add_control(
    'nph_display_name',
    array(
      'section'   => 'nph_display_options',
      'label'     => __( 'Display name', 'notebook-ph' ),
      'type'      => 'text'
    )
  );

  $wp_customize->add_setting(
    'nph_display_credit',
    array(
      'default'    =>  'true',
      'transport'  =>  'postMessage'
    )
  );

  $wp_customize->add_control(
    'nph_display_credit',
    array(
      'section'   => 'nph_display_options',
      'label'     => __( 'Display Credit?', 'notebook-ph'),
      'type'      => 'checkbox'
    )
  );

  $wp_customize->add_setting(
    'nph_display_authors',
    array(
      'default'    =>  'true',
      'transport'  =>  'postMessage'
    )
  );

  $wp_customize->add_control(
    'nph_display_authors',
    array(
      'section'   => 'nph_display_options',
      'label'     => __( 'Display Authors?', 'notebook-ph'),
      'type'      => 'checkbox'
    )
  );

  $wp_customize->add_setting(
    'nph_display_categories',
    array(
      'default'    =>  'true',
      'transport'  =>  'postMessage'
    )
  );

  $wp_customize->add_control(
    'nph_display_categories',
    array(
      'section'   => 'nph_display_options',
      'label'     => __( 'Display Categories?', 'notebook-ph'),
      'type'      => 'checkbox'
    )
  );
}

add_action( 'wp_head', 'nph_customizer_css' );
function nph_customizer_css() {
  ?>
  <style type="text/css">
    .drawer { background: rgba(<?php echo hex2rgb( get_theme_mod( 'nph_header_color' ) ); ?>, 0.8); }
    <?php if( false === get_theme_mod( 'nph_display_authors' ) ) { ?>
        span.author { display: none; }
    <?php } ?>
    <?php if( false === get_theme_mod( 'nph_display_categories' ) ) { ?>
        span.categories { display: none; }
    <?php } ?>
    <?php if( false === get_theme_mod( 'nph_display_credit' ) ) { ?>
        p.credit { display: none; }
    <?php } ?>
  </style>
  <?php
}

add_action( 'customize_preview_init', 'nph_customizer_live_preview' );
function nph_customizer_live_preview() {
  $version = nph_get_theme_version();

  wp_enqueue_script(
    'nph-theme-customizer',
    get_template_directory_uri() . '/customizer.js',
    array( 'jquery', 'customize-preview' ),
    $version,
    true
  );
}
