<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php wp_title(' | ', 'false', 'right'); ?></title>

    <?php wp_head(); ?>

    <script>
      if( window.location.host == 'piperhaywood.com' ) {
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-21148761-1', 'auto');
        ga('send', 'pageview');
      }
    </script>

  </head>

  <body <?php body_class(); ?>>

    <input type="checkbox" id="menu-toggle">
    <label class="open-menu" for="menu-toggle">Menu</label>

    <div class="wrapper">
      <header class="header">
        <div class="header__inner">

          <div class="container">
            <a class="header__link" href="<?php echo site_url(); ?>" data-title="<?php bloginfo('name'); ?>" aria-label="Go to homepage">
              <h1 class="header__description"><?php echo nph_archive_str(); ?></h1>
            </a>
          </div>

          <?php $desc = nph_archivedesc(false); ?>
          <?php if ($desc) : ?>
            <div class="prose container">
              <?php echo $desc; ?>
            </div>
          <?php endif; ?>

          <div class="container">
            <?php get_search_form(); ?>
          </div>

          <?php wp_nav_menu( array(
            'theme_location' => 'header',
            'container' => 'nav',
            'menu_class' => 'menu container'
          ) ); ?>

          <div class="container">
            <p class="copyright"><span class="copyright__year"><?php echo nph_get_copyright(); ?></span> <a class="h-card copyright__credit" rel="me" href="<?php echo site_url(); ?>"><?php bloginfo('name'); ?></a></p>
            <p class="credit"><?php _e('This site uses the', 'notebook-ph'); ?> Notebook <?php _e('theme by', 'notebook-ph'); ?> <a href="http://piperhaywood.com">Piper Haywood</a>. </p>
          </div>

        </div>
      </header>
