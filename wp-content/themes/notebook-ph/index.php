<?php get_header(); ?>

<main class="content">
  <?php if (have_posts()) : ?>
    <?php $i = 0; ?>
    <?php $total = $wp_query->post_count; ?>
    <?php while (have_posts()) : the_post(); ?>
      <?php $current_hsl = nph_get_hsl($post); ?>
      <?php $prev = $i + 1 < $total ? $wp_query->posts[$i + 1] : false; ?>
      <?php $prev_hsl = $prev ? nph_get_hsl($prev) : $current_hsl; ?>
      <article <?php post_class(array('post', 'gradient')); ?> style="--first-color:<?php echo $current_hsl; ?>;--second-color:<?php echo $prev_hsl; ?>;">
        <div class="wrapper wrapper--post">
          <div class="container">
            <?php $format = get_post_format(); ?>
            <?php if (!is_singular() && !$format) : ?>
              <header>
                <h1 class="p-name post__title">
                  <?php nph_title(); ?>
                </h1>
              </header>
            <?php endif; ?>
            
            <div class="e-content post__content">
              <?php the_content('Read more'); ?>
            </div>


            <?php if (!is_page()) : ?>
              <footer>
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
                    <?php $args = array('orderby' => 'count', 'order' => 'DESC'); ?>
                    <?php $tags = wp_get_post_tags($post->ID, $args); ?>
                    <?php if (!empty($tags)) : ?>
                      <?php foreach($tags as $tag) : ?>
                        <li class="post__tag">
                          <a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a>
                        </li>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </ul>
                </div>

                <?php wp_link_pages(); ?>
              </footer>
            <?php endif; ?>
          </div>
        </div>
      </article>
      <?php $i++; ?>
    <?php endwhile; ?>

  <?php else : ?>
    <?php // TODO apply today’s date to this for color ?>
    <article class="post gradient type-<?php echo get_post_type(); ?>" style="--first-color:<?php echo nph_get_hsl(); ?>;--second-color: var(--first-color);">
      <div class="container">
        <div class="post__content">
          <p>Try searching again, or browse content below. </p>
          <?php get_template_part('content', 'browse'); ?>
        </div>
      </div>
    </article>

  <?php endif; ?>
</main>

<?php get_footer(); ?>