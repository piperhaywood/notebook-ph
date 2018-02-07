<?php get_header(); ?>

<main class="content <?php nph_pagetype(); ?>">
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class('post'); ?>>
        <?php $format = get_post_format(); ?>
        <?php if (!is_singular() && !$format) : ?>
          <header>
            <h1 class="post__title">
              <?php nph_title(); ?>
            </h1>
          </header>
        <?php endif; ?>
        
        <div class="post__content">
          <?php the_content('Read more'); ?>
        </div>
        <?php if (!is_page()) : ?>
          <footer>
            <div class="post__meta">
              <?php $args = array('orderby' => 'count', 'order' => 'DESC'); ?>
              <?php $tags = wp_get_post_tags($post->ID, $args); ?>
              <?php if (!empty($tags)) : ?>
                <ul class="post__tags">
                  <li class="post__tag post__date">
                    <time datetime="<?php echo nph_date(true, false); ?>"><a href="<?php the_permalink(); ?>"><?php echo get_the_date('Y.m.d'); ?></a></time>
                  </li>
                  <?php $format = get_post_format(); ?>
                  <?php if ($format != false) : ?>
                    <li class="post__tag">
                      <a href="<?php echo get_post_format_link($format); ?>">
                        <?php echo $format; ?>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php foreach($tags as $tag) : ?>
                    <li class="post__tag">
                      <a href="<?php echo get_tag_link($tag->term_id); ?>">
                        <?php echo $tag->name; ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
              <?php $meta = nph_postmeta(false); ?>
              <p class="thepermalink" style="display: none;"><?php echo $meta; ?></p>
            </div>

            <?php wp_link_pages(); ?>
          </footer>
        <?php endif; ?>
      </article>
    <?php endwhile; ?>

      <?php $prev = false; ?>
      <?php $next = false; ?>
      <?php if (is_home() || is_archive()) : ?>
        <?php $prev = get_previous_posts_link(__('Previous page', 'notebook-ph')); ?>
        <?php $next = get_next_posts_link(__('Next page', 'notebook-ph')); ?>
      <?php elseif (is_singular('post')) : ?>
        <?php $prev = get_previous_post_link('%link', __('Previous ', 'notebook-ph') . get_posts_label(false)); ?>
        <?php $next = get_next_post_link('%link', __('Next ', 'notebook-ph') . get_posts_label(false)); ?>
      <?php endif; ?>
      <?php if ($prev || $next) : ?>
        <nav class="pagination">
          <?php if ($prev) : ?>
            <p><?php echo $prev; ?></p>
          <?php endif; ?>
          <?php if ($next) : ?>
            <p><?php echo $next; ?></p>
          <?php endif; ?>
        </nav>
      <?php endif; ?>
  <?php else : ?>

    <article class="post type-<?php echo get_post_type(); ?>">
      <div class="post__content">
        <p>Try searching again, or browse content below. </p>
        <?php get_template_part('content', 'browse'); ?>
      </div>
    </article>

  <?php endif; ?>
</main>

<?php get_footer(); ?>