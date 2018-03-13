<?php get_header(); ?>

<?php $hsl = nph_get_hsl($post); ?>

<main class="content <?php nph_pagetype(); ?>">
  <article class="post gradient type-<?php echo get_post_type(); ?>"<?php if ($hsl) : ?> style="--first-color:<?php echo $hsl; ?>;--second-color: var(--first-color);"<?php endif; ?>>
    <div class="wrapper">
      <div class="container">
        <div class="post__content">
          <p>Sorry, there&rsquo;s nothing to see here. Please browse the content using the tools below, or get in touch if you can&rsquo;t find what you&rsquo;re looking for.</p>
          <?php get_template_part('content', 'browse'); ?>
        </div>
      </div>
    </div>
  </article>
</main>

<?php get_footer(); ?>