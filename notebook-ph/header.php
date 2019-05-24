<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="referrer" content="origin-when-cross-origin" />
    <title><?php wp_title(' | ', 'false', 'right'); ?></title>

    <?php wp_head(); ?>

  </head>

  <?php $rainbow = get_theme_mod('nph_rainbow') ? 'rainbow' : ''; ?>
  <body <?php body_class($rainbow); ?>>

    <input type="checkbox" id="menu-toggle">
    <label
      class="open-menu"
      for="menu-toggle"
      data-close="<?php esc_html_e('Close', 'notebook-ph'); ?>"
      role="button">
      <span class="open-menu__button open-menu__button--open"
        aria-controls="main-menu"
        aria-label="<?php esc_html_e('Open menu', 'notebook-ph'); ?>"><?php esc_html_e('Menu', 'notebook-ph'); ?></span>
      <span class="open-menu__button open-menu__button--close"
        aria-controls="main-menu"
        aria-label="<?php esc_html_e('Close menu', 'notebook-ph'); ?>"><?php esc_html_e('Close', 'notebook-ph'); ?></span>
    </label>

    <header class="header" role="banner">
      <div class="header__inner">
        <a class="skip-link" href="#main"><?php esc_html_e('Skip to main content', 'notebook-ph'); ?></a>
        <a class="skip-link" href="#searchform"><?php esc_html_e('Skip to search form', 'notebook-ph'); ?></a>
        <div class="container">
          <h1 class="header__title">
            <?php if (!is_front_page()) : ?>
              <a class="header__link" href="<?php echo site_url(); ?>" data-title="<?php bloginfo('name'); ?>" aria-label="<?php esc_html_e('Go to homepage', 'notebook-ph'); ?>">PH</a> / <?php echo nph_archive_str(); ?>
            <?php else : ?>
              <a class="header__link" href="<?php echo site_url(); ?>" data-title="<?php bloginfo('name'); ?>" aria-label="<?php esc_html_e('Go to homepage', 'notebook-ph'); ?>"><?php bloginfo('name'); ?></a>
            <?php endif; ?>
            
          </h1>
        </div>

        <?php wp_nav_menu( array(
          'theme_location' => 'nph-menu',
          'container' => 'nav',
          'menu_class' => 'menu container'
        ) ); ?>

        <div class="container">
          <?php get_search_form(); ?>
        </div>

        <div class="container smallprint">
          <?php $copyright = get_theme_mod('nph_copyright'); ?>
          <?php if ($copyright) : ?>
            <p class="copyright"><?php echo strip_tags($copyright, '<em><a><img><br>'); ?></p>
          <?php endif; ?>
          <p class="credit">
            <?php
              printf(
                wp_kses(
                  __('This site uses the %1$s theme by <a href="%2$s">%3$s</a>.', 'notebook-ph'),
                  array('a' => array('href' => array()))
                ),
                'Notebook',
                esc_url('https://piperhaywood.com'),
                'Piper Haywood'
              );
            ?>
          </p>
        </div>

      </div>
    </header>
    <div class="wrapper js-wrapper">
