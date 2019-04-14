<?php /* Template Name: Browse */ ?>

<?php get_header(); ?>

<main class="main" role="main">
  <section class="articles <?php echo !is_singular() ? 'js-infinite-container' : false; ?>">
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <?php $hsl = nph_get_hsl(); ?>
      <article <?php post_class(array('post', 'article', 'js-article')); ?> style="--color:<?php echo $hsl; ?>;">
        <div class="article__inner">
          <header class="post__header">
            <h1 class="p-name post__title">
              <?php nph_title(); ?>
            </h1>
          </header>
          
          <div class="prose">
            <?php the_content(); ?>
          </div>

          <div class="container browse-search">
            <?php get_search_form(); ?>
          </div>

          <div class="container container--full">
            <div class="termindex">
              <?php get_template_part('termindex'); ?>
            </div>
          </div>

          <footer class="post__footer">
            <?php wp_link_pages(); ?>
          </footer>
        </div>
      </article>
    <?php endwhile; ?>

  <?php endif; ?>
  </section>
</main>

<?php get_footer(); ?>