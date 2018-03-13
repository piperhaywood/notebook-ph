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

    <?php $first_hsl = nph_get_hsl($post); ?>
    <?php $second_hsl = nph_get_hsl($post); ?>
    <header class="header gradient"<?php if ($first_hsl && $second_hsl) : ?> style="--first-color:<?php echo $first_hsl; ?>;--second-color: <?php echo $second_hsl; ?>;"<?php endif; ?>>
      <div class="wrapper">
        <div class="container">
          <div class="header__meta">
            <?php $nav = false; ?>
            <nav class="header__nav">
              <ul>
              <?php if (!is_front_page() || is_paged()) : ?>
                <li><a href="<?php echo site_url(); ?>"><?php _e('Home', 'notebook-ph'); ?></a></li>
              <?php endif; ?>
              <?php $nav = is_front_page() ? nph_get_navigation('header') : nph_get_navigation(get_the_title()); ?>
              <?php $nav = $nav ? $nav : nph_get_navigation('header'); ?>
              <?php if ($nav) : ?>
                <?php foreach ($nav as $item) : ?>
                  <li><a href="<?php echo esc_url($item->url); ?>"><?php echo $item->title; ?></a></li>
                <?php endforeach; ?>
              <?php endif; ?>
              </ul>
            </nav>

            <?php $return = nph_archive_str(); ?>
            <?php $desc = nph_archivedesc(false); ?>
            <?php if ($desc) : ?>
              <?php $return .= strip_tags($desc, '<a><i><b><strong><em>'); ?>
            <?php endif; ?>
            <?php if (is_front_page() && !is_paged()) : ?>
              <?php $return = 'Hello, my name is Piper Haywood. ' . $return; ?>
            <?php endif; ?>

            <?php if (!is_singular()) : ?>
              <p class="header__description"><?php echo $return; ?></p>
            <?php else : ?>
              <h1 class="p-name header__description"><?php echo $return; ?></h1>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </header>
