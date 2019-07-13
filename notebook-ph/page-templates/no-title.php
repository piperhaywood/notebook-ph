<?php /* Template Name: No Title */ ?>

<?php get_header(); ?>

<main id="main" class="main" role="main">
  <section class="articles<?php echo !is_singular() ? ' js-infinite-container' : false; ?>">
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <?php $hsl = nph_get_hsl(); ?>
      <article <?php post_class(array('post', 'article', 'js-article')); ?> style="--color:<?php echo $hsl; ?>;">
        <div class="article__inner">
          <header class="post__header">
            <h1 class="p-name post__title visuallyhidden">
              <?php nph_title(); ?>
            </h1>
          </header>

          <section class="prose">
            <?php the_content(esc_html__('Read more', 'notebook-ph')); ?>
          </section>

          <footer class="post__footer">

            <?php if (is_singular()) : ?>
              <?php if (comments_open() || get_comments_number()) : ?>
                <?php comments_template(); ?>
              <?php endif; ?>
            <?php endif; ?>
            <?php wp_link_pages(); ?>
            <a href="#top" class="visuallyhidden button" aria-role="button"><?php _e('Back to top', 'notebook-ph'); ?></a>

          </footer>
        </div>
      </article>
    <?php endwhile; ?>
  <?php endif; ?>
  </section>
</main>

<?php get_footer(); ?>