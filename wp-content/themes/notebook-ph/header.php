<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
  <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php wp_title( ' | ', 'false', 'right' ); ?></title>

    <?php wp_head(); ?>

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-21148761-2', 'auto');
      ga('send', 'pageview');

    </script>

  </head>

  <body <?php body_class(); ?>>

    <div class="site-wrapper">
      <header class="header-wrapper animate">
        <button type="button" data-text-swap="<?php _e( 'Close', 'notebook-ph' ); ?>" class="nav-button"><?php _e( 'Menu', 'notebook-ph' ); ?></button>
        <div class="site-logo-wrapper">
          <h1 class="site-logo"><a href="<?php echo get_site_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
        </div>
        <div class="drawer">
          <div class="drawer-inner">
            <h1 class="site-logo-on-small" aria-hidden="true"><a href="<?php echo get_site_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
            <?php nph_menu(); ?>
            <p class="credit">Notebook <?php _e( 'theme by', 'notebook-ph' ); ?> <a href="http://piperhaywood.com">Piper Haywood</a></p>
          </div>
        </div>
      </header>

      <?php $subtitle = nph_subtitle(false, '', ''); ?>
      <?php if( $subtitle ) : ?>
        <div class="archive-wrapper">
          <div class="archive-info">
            <div class="archive-title">
              <h2><?php echo $subtitle; ?></h2>
            </div>
            <?php $desc = nph_archivedesc( false ); ?>
            <?php if( $desc ) : ?>
              <div class="archive-description">
                <?php echo $desc; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
