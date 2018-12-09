<footer class="footer">
  <?php if (is_singular()) : ?>
    <?php if (class_exists( 'Jetpack_RelatedPosts' )) : ?>
      <?php echo do_shortcode('[jetpack-related-posts]'); ?>
    <?php endif; ?>
    <?php if (comments_open() || get_comments_number()) : ?>
      <?php comments_template(); ?>
    <?php endif; ?>
  <?php endif; ?>
  <?php $prev = false; ?>
  <?php $next = false; ?>
  <?php if (is_home() || is_archive() || is_search()) : ?>
    <?php $prev = get_previous_posts_link(__('Previous page', 'notebook-ph')); ?>
    <?php $next = get_next_posts_link(__('Next page', 'notebook-ph')); ?>
  <?php elseif (is_singular('post')) : ?>
    <?php $prev = get_previous_post_link('%link', __('Older', 'notebook-ph')); ?>
    <?php $next = get_next_post_link('%link', __('Newer', 'notebook-ph')); ?>
  <?php endif; ?>
  <?php if ($prev || $next) : ?>
    <nav class="pagination">
      <?php if ($prev) : ?>
        <p class="pagination__previous"><?php echo $prev; ?></p>
      <?php endif; ?>
      <?php if ($next) : ?>
        <p class="pagination__next"><?php echo $next; ?></p>
      <?php endif; ?>
    </nav>
  <?php endif; ?>

</footer>

<?php wp_footer(); ?>

</div>

</body>
</html>