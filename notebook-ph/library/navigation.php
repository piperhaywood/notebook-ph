<?php

register_nav_menus(array(
  'nph-menu' => 'Header Menu'
));

function nph_menu() {
  wp_nav_menu(array(
    'container'       => false,
    'container_class' => '',
    'menu'            => '',
    'menu_class'      => 'header__nav',
    'theme_location'  => 'nph-menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '',
    'depth'           => 5,
  ));
}