<?php get_header(); ?>

<main class="main <?php nph_pagetype(); ?>" role="main">
  <article class="article gradient type-<?php echo get_post_type(); ?>">
    <div class="article__inner">
      <div class="prose">
        <p>Sorry, there&rsquo;s nothing to see here. Please search or browse keywords below. Get in touch if you can&rsquo;t find what you&rsquo;re looking&nbsp;for.</p>
      </div>
      <div class="container browse-search">
        <?php get_search_form(); ?>
      </div>

      <div class="container container--full">
        <div class="termindex">
          <?php get_template_part('termindex'); ?>
        </div>
      </div>
    </div>
    <footer class="post__footer">
    </footer>
  </article>
</main>

<?php get_footer(); ?>