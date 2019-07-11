<?php get_header(); ?>

<main class="main <?php nph_pagetype(); ?>" role="main">
  <article class="article gradient type-<?php echo get_post_type(); ?>">
    <div class="article__inner">
      <div class="prose">
        <p><?php _e('Sorry, there&rsquo;s nothing to see here. Please search or browse keywords below. Get in touch if you can&rsquo;t find what you&rsquo;re looking&nbsp;for.', 'notebook-ph'); ?></p>
      </div>
      <div class="container browse-search">
        <?php get_search_form(); ?>
      </div>

      <?php echo do_shortcode('[notebookindex count="2"]'); ?>

    </div>
    <footer class="post__footer">
    </footer>
  </article>
</main>

<?php get_footer(); ?>