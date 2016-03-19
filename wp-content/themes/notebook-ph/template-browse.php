<?php

/*
* Template Name: Browse
*/

?>

<?php get_header(); ?>

<div class="article-wrapper permalink">
  <?php while( have_posts() ) : the_post(); ?>
    <article class="post type-<?php echo get_post_type(); ?>">
      <h1 class="title"><?php the_title(); ?></h1>
      <div class="content">
        <?php the_content(); ?>
        <?php get_template_part( 'content', 'browse' ); ?>
      </div>
    </article>
  <?php endwhile; ?>
</div>

<?php get_footer(); ?>