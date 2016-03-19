<?php get_header(); ?>

<main class="article-wrapper permalink">
  <?php while( have_posts() ) : the_post(); ?>
    <article class="post type-<?php echo get_post_type(); ?>">
      <h1 class="title"><?php the_title(); ?></h1>
      <div class="content">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>