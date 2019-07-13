<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="referrer" content="origin-when-cross-origin" />
    <title><?php wp_title(' | ', 'false', 'right'); ?></title>

    <?php wp_head(); ?>

  </head>
  <?php $copyright = get_theme_mod('nph_copyright'); ?>
  <?php $short = get_theme_mod('nph_short_title'); ?>
  <?php $classes = get_theme_mod('nph_rainbow') ? array('rainbow') : array(); ?>
  <?php $classes[] = 'is-not-tabbing'; ?>
  <body <?php body_class(implode(' ', $classes)); ?>>

    <header id="top" class="header js-header">
      <div class="container">
        <a class="visuallyhidden button" href="#main" aria-role="button"><?php esc_html_e('Skip to main content', 'notebook-ph'); ?></a>
        <?php if (class_exists('GA_Google_Analytics_Pro')) : ?>
          <a class="visuallyhidden button" href="#ga-pro" aria-role="button"><?php esc_html_e('Skip to analytics settings', 'notebook-ph'); ?></a>
        <?php endif; ?>
      </div>
      <h1 id="title" aria-label="<?php echo nph_archive_label(); ?>">
        <?php echo is_front_page() ? get_bloginfo('name') : nph_archive_str() . ' &mdash; ' . get_bloginfo('name'); ?>
      </h1>
      <details id="menu" class="header__details container js-header-details">
        <summary class="header__summary js-header-summary" role="button" aria-expanded="false">
          <div class="header__title" aria-hidden="true">
            <div class="nav-icon">
              <div></div>
            </div>
            <div>
              <?php if (!is_front_page()) : ?>
                <?php echo $short ? $short : get_bloginfo('name'); ?> / <?php echo nph_archive_str(); ?>
              <?php else : ?>
                <?php bloginfo('name'); ?>
              <?php endif; ?>
            </div>
          </div>

          <span id="menutoggle" class="js-menu-toggle" aria-label="<?php esc_attr_e('Open menu for navigation and search', 'notebook-ph'); ?>"><?php _e('Open menu', 'notebook-ph'); ?></span>
        </summary>

        <div class="header__inner">
          <?php $desc = nph_archivedesc(false); ?>
          <?php if ($desc) : ?>
            <div class="header__desc prose" aria-hidden="true">
              <?php echo $desc; ?>
            </div>
          <?php endif; ?>

          <?php $items = wp_get_nav_menu_items('header'); ?>
          <?php $menu_class = count($items) > 3 ? ' col-2' : ''; ?>
          <?php $menu_class = 'menu' . $menu_class; ?>

          <?php wp_nav_menu( array(
            'theme_location' => 'nph-menu',
            'container' => 'nav',
            'menu_class' => $menu_class
          ) ); ?>

          <?php get_search_form(); ?>

          <div class="smallprint">
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
          <a href="#" class="visuallyhidden button js-close-menu" aria-role="button"><?php _e('Close menu', 'notebook-ph'); ?></a>
        </div>

      </details>
    </header>
