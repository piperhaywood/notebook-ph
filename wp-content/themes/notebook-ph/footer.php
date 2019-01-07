<footer class="site-footer" role="contentinfo">
  <?php if (is_singular()) : ?>
    <?php if (class_exists( 'Jetpack_RelatedPosts' )) : ?>
      <?php echo do_shortcode('[jetpack-related-posts]'); ?>
    <?php endif; ?>
    <?php if (comments_open() || get_comments_number()) : ?>
      <?php comments_template(); ?>
    <?php endif; ?>
  <?php endif; ?>
  <?php $prev = nph_get_previous_link(); ?>
  <?php $next = nph_get_next_link(); ?>
  <?php if ($prev || $next) : ?>
    <nav class="pagination js-pagination">
      <?php if ($prev) : ?>
        <p class="pagination__link pagination__link--previous js-previous"><?php echo $prev; ?></p>
      <?php endif; ?>
      <?php if ($next) : ?>
        <p class="pagination__link pagination__link--next js-next"><?php echo $next; ?></p>
      <?php endif; ?>
    </nav>
  <?php endif; ?>

</footer>

<?php wp_footer(); ?>

</div>

</body>
</html>