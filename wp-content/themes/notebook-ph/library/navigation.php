<?php

register_nav_menus(array(
  'nph-menu' => 'Notebook Menu'
));

if ( ! function_exists( 'nph_menu' ) ) {
  function nph_menu() {
    wp_nav_menu( array(
      'container'       => false,
      'container_class' => '',
      'menu'            => '',
      'menu_class'      => 'site-menu',
      'theme_location'  => 'nph-menu',
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'depth'           => 5,
    ));
  }
}
