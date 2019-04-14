<?php

add_action('customize_register', 'nph_customize_register');
function nph_customize_register($wp_customize) {

  $wp_customize->add_section(
    'nph_texts',
    array(
      'title'     => __('Texts', 'notebook-ph'),
      'priority'  => 200
    )
  );

  $wp_customize->add_setting(
    'nph_copyright',
    array(
      'default'    =>  '',
      'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control(
    'nph_copyright',
    array(
      'section'   => 'nph_texts',
      'label'     => __('Copyright', 'notebook-ph'),
      'type'      => 'textarea'
    )
  );

  $wp_customize->add_setting(
    'nph_infinite_scroll_end',
    array(
      'default'    =>  '',
      'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control(
    'nph_infinite_scroll_end',
    array(
      'section'   => 'nph_texts',
      'label'     => __('Infinite scroll end', 'notebook-ph'),
      'type'      => 'textarea'
    )
  );

  $wp_customize->add_setting(
    'nph_blog_intro',
    array(
      'default'    =>  '',
      'sanitize_callback' => 'wp_kses_post'
    )
  );

  $wp_customize->add_control(
    'nph_blog_intro',
    array(
      'section'   => 'nph_texts',
      'label'     => __('Blog introduction', 'notebook-ph'),
      'type'      => 'textarea'
    )
  );

  $wp_customize->add_section(
    'nph_display_options',
    array(
      'title'     => __('Display Options', 'notebook-ph'),
      'priority'  => 200
    )
  );

  $wp_customize->add_setting(
    'nph_rainbow',
    array(
      'default'    =>  'false',
      'transport'  =>  'postMessage'
    )
  );

  $wp_customize->add_control(
    'nph_rainbow',
    array(
      'section'   => 'nph_display_options',
      'label'     => __('Rainbow?', 'notebook-ph'),
      'type'      => 'checkbox'
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
      'label'     => __('Display Credit?', 'notebook-ph'),
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
      'label'     => __('Display Author?', 'notebook-ph'),
      'type'      => 'checkbox'
    )
  );

}

add_action('wp_head', 'nph_customizer_css');
function nph_customizer_css() {
  ?>
  <style type="text/css">
    <?php if (false === get_theme_mod('nph_display_authors')) { ?>
        .post__author { display: none; }
    <?php } ?>
    <?php if (false === get_theme_mod('nph_display_credit')) { ?>
        .credit { display: none; }
    <?php } ?>
  </style>
  <?php
}

add_action('customize_preview_init', 'nph_customizer_live_preview');
function nph_customizer_live_preview() {
  $version = nph_get_theme_version();

  wp_enqueue_script(
    'nph-theme-customizer',
    get_template_directory_uri() . '/customizer.js',
    array('jquery', 'customize-preview'),
    $version,
    true
  );
}
