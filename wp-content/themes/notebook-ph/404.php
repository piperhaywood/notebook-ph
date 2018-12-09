<?php get_header(); ?>

<main class="main <?php nph_pagetype(); ?>">
  <article class="article gradient type-<?php echo get_post_type(); ?>">
    <div class="article__inner">
      <div class="prose">
        <p>Sorry, there&rsquo;s nothing to see here. Please use the search, or get in touch if you can&rsquo;t find what you&rsquo;re looking for.</p>
      </div>
      <div class="container">
        <?php get_search_form(); ?>
      </div>
    </div>
  </article>
</main>

<?php get_footer(); ?>