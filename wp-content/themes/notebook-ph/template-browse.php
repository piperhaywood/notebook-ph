<?php

/*
* Template Name: Browse
*/

?>

<?php get_header(); ?>

<main class="content">
  <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class('post'); ?>>
      <div class="post__content">
        <?php the_content(); ?>
        <?php get_template_part('content', 'browse'); ?>
      </div>
    </article>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>