<?php get_header(); ?>

<main class="content <?php nph_pagetype(); ?>">
  <article class="post type-<?php echo get_post_type(); ?>">
    <div class="post__content">
      <p>Sorry, there&rsquo;s nothing to see here. Please browse the content using the tools below, or <a href="mailto:contact@piperhaywood.com">email me</a> if you can&rsquo;t find what you're looking for.</p>
      <?php get_template_part('content', 'browse'); ?>
    </div>
  </article>
</main>

<?php get_footer(); ?>