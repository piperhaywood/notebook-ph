<?php

/*
* Template Name: Browse
*/

?>

<?php get_header(); ?>

<?php $hsl = nph_get_hsl($post); ?>

<main class="content">
  <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class(array('post', 'gradient')); ?><?php if ($hsl) : ?> style="--first-color:<?php echo $hsl; ?>;--second-color: var(--first-color);"<?php endif; ?>>
      <div class="container">
        <div class="post__content">
          <?php the_content(); ?>
          <?php get_template_part('content', 'browse'); ?>
        </div>
      </div>
    </article>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>