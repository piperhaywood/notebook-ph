<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php wp_title(' | ', 'false', 'right'); ?></title>

    <?php wp_head(); ?>

  </head>

  <?php $rainbow = get_theme_mod('nph_rainbow') ? 'rainbow' : ''; ?>
  <body <?php body_class($rainbow); ?>>

    <input type="checkbox" id="menu-toggle">
    <label
      class="open-menu"
      for="menu-toggle"
      data-close="Close"
      role="button">
      <span class="open-menu__button open-menu__button--open"
        aria-controls="main-menu"
        aria-label="Open menu">Menu</span>
      <span class="open-menu__button open-menu__button--close"
        aria-controls="main-menu"
        aria-label="Close menu">Close</span>
    </label>

    <header class="header" role="banner">
      <div class="header__inner">
        <a class="skip-link" href="#main">Skip to main content</a>
        <a class="skip-link" href="#searchform">Skip to search form</a>
        <div class="container">
          <h1 class="header__title">
            <?php if (!is_front_page()) : ?>
              <a class="header__link" href="<?php echo site_url(); ?>" data-title="<?php bloginfo('name'); ?>" aria-label="Go to homepage">PH</a> / <?php echo nph_archive_str(); ?>
            <?php else : ?>
              <a class="header__link" href="<?php echo site_url(); ?>" data-title="<?php bloginfo('name'); ?>" aria-label="Go to homepage"><?php bloginfo('name'); ?></a>
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
            <p class="copyright"><?php echo $copyright; ?></p>
          <?php endif; ?>
          <p class="credit"><?php _e('This site uses the', 'notebook-ph'); ?> Notebook <?php _e('theme by', 'notebook-ph'); ?> <a href="http://piperhaywood.com">Piper Haywood</a>. </p>
        </div>

      </div>
    </header>
    <div class="wrapper js-wrapper">
