<?php get_header(); ?>

<div class="article-wrapper permalink">
  <article class="post type-<?php echo get_post_type(); ?>">
    <h1 class="title">404 error: page not found</h1>
    <div class="content">
      <p>Sorry, there's nothing to see here. Please browse the content using the tools below, or <a href="mailto:contact@piperhaywood.com">email me</a> if you can't find what you're looking for.</p>
      <?php get_template_part( 'content', 'browse' ); ?>
    </div>
  </article>
</div>

<?php get_footer(); ?>