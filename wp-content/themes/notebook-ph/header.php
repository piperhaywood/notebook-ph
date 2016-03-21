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

    <div class="wrapper">
      <header class="header header--flex">
        <div class="header--flex__1">
          <div class="header__title">
            <h1><a href="<?php echo get_site_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
          </div>
        </div>
        <div class="header--flex__3">
          <?php nph_menu(); ?>
        </div>

        <div class="header--flex__2">
          <div class="header__meta">
            <?php $return = nph_archive_str(); ?>
            <?php $desc = nph_archivedesc( false ); ?>
            <?php if( $desc ) : ?>
              <?php $return .= strip_tags( $desc, '<a><i><b><strong><em>' ); ?>
            <?php endif; ?>

            <div>
              <p><?php echo $return; ?></p>
            </div>
            
            <?php //$desc = false; ?>
          </div>
        </div>
      </header>
