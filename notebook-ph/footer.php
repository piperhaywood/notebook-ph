<footer class="site-footer" role="contentinfo">
  <?php if (is_home() || is_archive() || is_search()) : ?>
    <?php $prev = get_previous_posts_link(__('Previous page', 'notebook-ph')); ?>
    <?php $next = get_next_posts_link(__('Next page', 'notebook-ph')); ?>
    <?php if ($prev || $next) : ?>
      <nav class="pagination pagination--archive js-pagination">
        <?php if ($prev) : ?>
          <p class="pagination__link pagination__link--previous js-previous"><?php echo $prev; ?></p>
        <?php endif; ?>
        <?php if ($next) : ?>
          <p class="pagination__link pagination__link--next js-next"><?php echo $next; ?></p>
        <?php endif; ?>
      </nav>
    <?php endif; ?>
  <?php elseif (is_singular('post')) : ?>
    <?php $prev = get_previous_post(); ?>
    <?php $next = get_next_post(); ?>
    <?php if ($prev || $next) : ?>
      <nav class="pagination pagination--post js-pagination">
        <p class="pagination__label">
          <?php if ($prev && $next) : ?>
            <?php _e('Previous / Next', 'notebook-ph'); ?>
          <?php elseif ($prev) : ?>
            <?php _e('Previous', 'notebook-ph'); ?>
          <?php else : ?>
            <?php _e('Next', 'notebook-ph'); ?>
          <?php endif; ?>
        </p>
        <?php if ($prev) : ?>
          <?php $hsl = nph_get_hsl($prev); ?>
          <p class="pagination__link pagination__link--previous js-previous">
            <a class="has-bg" style="--color: <?php echo $hsl; ?>" href="<?php echo get_the_permalink($prev); ?>">
              <?php echo get_the_date('d M Y', $prev->ID); ?> &mdash; <?php echo get_the_title($prev); ?>
            </a>
          </p>
        <?php endif; ?>
        <?php if ($next) : ?>
          <?php $hsl = nph_get_hsl($next); ?>
          <p class="pagination__link pagination__link--next js-next">
            <a class="has-bg" style="--color: <?php echo $hsl; ?>" href="<?php echo get_the_permalink($next); ?>">
            <?php echo get_the_date('d M Y', $next->ID); ?> &mdash; <?php echo get_the_title($next); ?>
            </a>
          </p>
        <?php endif; ?>
      </nav>
    <?php endif; ?>
  <?php endif; ?>

  <div class="js-infinite-loading infinite-loading">
    <p><em>Loading more...</em></p>
  </div>

  <?php $end = get_theme_mod('nph_infinite_scroll_end'); ?>
  <?php $end = $end ? $end : '<em>The end.</em>'; ?>
  <div class="js-infinite-end infinite-end">
    <p><?php echo strip_tags($end, '<em><a><img><br>'); ?></p>
  </div>

  <?php wp_footer(); ?>

</footer>

</div>

</body>
</html>