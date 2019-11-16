<?php get_header(); ?>

<main class="main <?php nph_pagetype(); ?>" role="main">
  <article class="article gradient type-<?php echo get_post_type(); ?>">
    <div class="article__inner">
      <header class="post__header">
        <h1 class="p-name post__title visuallyhidden">
          <?php nph_title(); ?>
        </h1>
      </header>

      <section class="prose e-content">
        <p><?php _e('Sorry, there&rsquo;s nothing to see here. Please search or browse keywords below. Get in touch if you can&rsquo;t find what you&rsquo;re looking&nbsp;for.', 'notebook-ph'); ?></p>
        <?php get_search_form(); ?>
        <?php echo do_shortcode('[notebookindex count="2"]'); ?>
      </section>

      <footer class="post__footer">
      </footer>

    </div>
  </article>
</main>

<?php get_footer(); ?>