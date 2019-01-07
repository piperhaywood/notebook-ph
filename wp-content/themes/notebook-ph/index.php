<?php get_header(); ?>

<main class="main" role="main">
  <section class="articles <?php echo !is_singular() ? 'js-infinite-container' : false; ?>">
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <?php $current_hsl = nph_get_hsl($post); ?>
      <?php $prev = get_previous_post(); ?>
      <?php $prev_hsl = $prev ? nph_get_hsl($prev) : $current_hsl; ?>
      <article <?php post_class(array('post', 'article', 'js-article')); ?> style="--first-color:<?php echo $current_hsl; ?>;--second-color:<?php echo $prev_hsl; ?>;">
        <div class="article__inner prose">
          <?php $format = get_post_format(); ?>
          <?php if (!$format) : ?>
            <header class="post__header">
              <h1 class="p-name post__title">
                <?php nph_title(); ?>
              </h1>
            </header>
          <?php endif; ?>

          <?php the_content('Read more'); ?>

          <?php if (!is_page()) : ?>
            <footer class="post__footer">
              <div class="post__meta">
                <ul class="post__tags">
                  <li class="post__tag post__date">
                    <time class="dt-published" datetime="<?php echo nph_date(true, false); ?>"><a class="u-url" href="<?php the_permalink(); ?>"><?php echo get_the_date() . ' at ' . get_the_time(); ?></a></time>
                  </li>
                  <?php $format = get_post_format(); ?>
                  <?php if ($format != false) : ?>
                    <li class="post__tag">
                      <a href="<?php echo get_post_format_link($format); ?>"><?php echo $format; ?></a>
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
                        <a href="<?php echo get_tag_link($term->term_id); ?>"><?php echo $term->name; ?></a>
                      </li>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </ul>
              </div>

              <?php wp_link_pages(); ?>

            </footer>
          <?php endif; ?>
        </div>
      </article>
    <?php endwhile; ?>

  <?php else : ?>
    <?php // TODO apply today’s date to this for color ?>
    <article class="post article type-<?php echo get_post_type(); ?>" style="--first-color:<?php echo nph_get_hsl(); ?>;--second-color: var(--first-color);">
      <div class="article__inner">
        <p>Try searching again, or browse content below. </p>
        <?php get_template_part('content', 'browse'); ?>
      </div>
    </article>

  <?php endif; ?>
  </section>
</main>

<?php get_footer(); ?>