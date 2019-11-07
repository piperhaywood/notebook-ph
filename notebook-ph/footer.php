<footer class="site-footer" role="contentinfo">
  <?php if (is_home() || is_archive() || is_search()) : ?>
    <?php $prev = get_previous_posts_link(__('Previous page', 'notebook-ph')); ?>
    <?php $next = get_next_posts_link(__('Next page', 'notebook-ph')); ?>
    <?php if ($prev || $next) : ?>
      <div class="container">
        <nav class="pagination pagination--archive js-pagination">
          <?php if ($prev) : ?>
            <p class="pagination__link pagination__link--previous js-previous"><?php echo $prev; ?></p>
          <?php endif; ?>
          <?php if ($next) : ?>
            <p class="pagination__link pagination__link--next js-next"><?php echo $next; ?></p>
          <?php endif; ?>
        </nav>
      </div>
    <?php endif; ?>
  <?php elseif (is_singular('post')) : ?>
    <?php $prev = get_previous_post(); ?>
    <?php $next = get_next_post(); ?>
    <?php $p = array($prev, $next); ?>
    <?php $p = array_filter($p); ?>
    <?php if ($p) : ?>
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
        <?php echo nph_get_list($p); ?>
      </nav>
    <?php endif; ?>
  <?php endif; ?>

  <div class="js-infinite-loading infinite-loading">
    <div class="container">
      <p><em><?php esc_html_e('Loading more&hellip;', 'notebook-ph'); ?></em></p>
    </div>
  </div>

  <?php $end = get_theme_mod('nph_infinite_scroll_end'); ?>
  <?php $end = $end ? $end : ''; ?>
  <div class="js-infinite-end infinite-end">
    <div class="container">
      <p><?php echo strip_tags($end, '<em><a><img><br>'); ?></p>
    </div>
  </div>

  <?php wp_footer(); ?>

  <div class="container">
    <a href="#top" class="visuallyhidden button"><?php _e('Back to top', 'notebook-ph'); ?></a>
  </div>

</footer>

</body>
</html>