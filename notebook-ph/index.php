<?php get_header(); ?>

<main class="main" role="main">
  <?php $desc = nph_archivedesc(false); ?>
  <?php if ($desc) : ?>
    <div class="archive-description prose">
      <?php echo $desc; ?>
    </div>
  <?php endif; ?>
  <section class="articles <?php echo !is_singular() ? 'js-infinite-container' : false; ?>">
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <?php if (is_page()) : ?>
        <?php $hsl = 'hsl(1, 100, 0)'; ?>
      <?php else : ?>
        <?php $hsl = nph_get_hsl($post); ?>
      <?php endif; ?>
      <article <?php post_class(array('post', 'article', 'js-article')); ?> style="--color:<?php echo $hsl; ?>;">
        <div class="article__inner">
          <?php $format = get_post_format(); ?>
          <header class="post__header">
            <?php if (get_post_type() == 'post') : ?>
              <time class="dt-published post__time" datetime="<?php echo nph_date(true, false); ?>">
                <a class="u-url has-bg" href="<?php the_permalink(); ?>">
                  <?php echo get_the_date('l, j F Y'); ?>
                </a>
              </time>
              <span class="post__author">by <?php the_author_posts_link(); ?></span>
            <?php endif; ?>
            <?php if (!$format) : ?>
              <h1 class="p-name post__title">
                <?php nph_title(); ?>
              </h1>
            <?php endif; ?>
          </header>
          
          <div class="prose">
            <?php the_content('Read more'); ?>
          </div>

          <footer class="post__footer">
            <?php if (!is_page()) : ?>
              <div class="post__meta">
                <ul class="post__tags">
                  <?php $format = get_post_format(); ?>
                  <?php if ($format != false) : ?>
                    <li class="post__tag">
                      <a href="<?php echo get_post_format_link($format); ?>"><?php echo $format; ?></a><span class="separator">, </span>
                    </li>
                  <?php endif; ?>
                  <?php $cats = wp_get_post_categories($post->ID, array(
                    'fields' => 'all',
                    'orderby' => 'count',
                    'order' => 'DESC'
                  )); ?>
                  <?php $tags = wp_get_post_tags($post->ID, array(
                    'orderby' => 'count',
                    'order' => 'DESC'
                  )); ?>
                  <?php $terms = array_merge($cats, $tags); ?>
                  <?php if (!empty($terms)) : ?>
                    <?php foreach($terms as $term) : ?>
                      <li class="post__tag">
                        <a href="<?php echo get_tag_link($term->term_id); ?>"><?php echo $term->name; ?></a><span class="separator">, </span>
                      </li>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </ul>
              </div>
            <?php endif; ?>
            <?php if (is_singular()) : ?>
              <?php if (comments_open() || get_comments_number()) : ?>
                <?php comments_template(); ?>
              <?php endif; ?>
            <?php endif; ?>
            <?php wp_link_pages(); ?>

          </footer>
        </div>
      </article>
    <?php endwhile; ?>

  <?php else : ?>
    <article class="post article type-<?php echo get_post_type(); ?>" style="--color:<?php echo nph_get_hsl(); ?>;">
      <div class="article__inner">

        <div class="prose">
          <p>Nothing found! </p>
        </div>

        <div class="container browse-search">
          <?php get_search_form(); ?>
        </div>

        <div class="container years">
          <?php get_template_part('years'); ?>
        </div>

        <div class="container tagcloud">
          <?php get_template_part('tagcloud'); ?>
        </div>
      </div>
      <footer class="post__footer">
      </footer>
    </article>

  <?php endif; ?>
  </section>
</main>

<?php get_footer(); ?>