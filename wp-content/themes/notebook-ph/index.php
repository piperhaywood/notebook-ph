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
              <?php $meta = nph_postmeta(false); ?>
              <p class="thepermalink"><?php echo $meta; ?></p>
              <?php $tags = get_the_tags(); ?>
              <?php if (!empty($tags)) : ?>
                <ul class="post__tags">
                  <?php foreach($tags as $tag) : ?>
                    <li class="post__tag post__tag--<?php echo $tag->slug; ?>">
                      <a class="post__tag__btn" href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>

            <?php wp_link_pages(); ?>
          </footer>
        <?php endif; ?>
      </article>
    <?php endwhile; ?>

      <nav class="pagination">
        <p>
          <?php if (is_home() || is_archive()) : ?>
            <?php previous_posts_link(__('Previous page', 'notebook-ph')); ?>
          <?php elseif (is_singular('post')) : ?>
            <?php previous_post_link('%link', __('Previous ', 'notebook-ph') . get_posts_label()); ?>
          <?php endif; ?>
        </p>
        <p>
          <?php if (is_home() || is_archive()) : ?>
            <?php next_posts_link(__('Next page', 'notebook-ph')); ?>
          <?php elseif (is_singular('post')) : ?>
            <?php next_post_link('%link', __('Next ', 'notebook-ph') . get_posts_label()); ?>
          <?php endif; ?>
        </p>
      </nav>
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