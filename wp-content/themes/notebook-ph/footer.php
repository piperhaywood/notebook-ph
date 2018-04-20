<?php
$first_hsl = false;
$second_hsl = false;
$total = $wp_query->post_count;
if ($total) {
  $last = $wp_query->posts[$total - 1];
  $start_unix = get_the_date('U');
  $end_unix = $total > 1 ? get_the_date('U', $last->ID) : $start_unix;
  $first_hue = nph_map_hue('Europe/London', 51.567592, $start_unix);
  $second_hue = nph_map_hue('Europe/London', 51.567592, $end_unix);
  $first_hsl = sprintf('--first-color: hsl(%s, 55%%, 95%%);', $first_hue);
  $second_hsl = sprintf('--second-color: hsl(%s, 55%%, 95%%);', $second_hue);
}

?>

<?php $hsl = nph_get_hsl($post); ?>

<footer class="footer gradient"<?php if ($hsl) : ?> style="--first-color:<?php echo $hsl; ?>;--second-color: var(--first-color);"<?php endif; ?>>
  <div class="wrapper">
    <div class="container">
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
      <?php if (is_home() || is_archive()) : ?>
        <?php $prev = get_previous_posts_link(__('Previous page', 'notebook-ph')); ?>
        <?php $next = get_next_posts_link(__('Next page', 'notebook-ph')); ?>
      <?php elseif (is_singular('post')) : ?>
        <?php $prev = get_previous_post_link('%link', __('Previous', 'notebook-ph')); ?>
        <?php $next = get_next_post_link('%link', __('Next', 'notebook-ph')); ?>
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

      <div class="footer__content">
        <?php nph_menu_footer(); ?>
        <p class="footer__copyright copyright"><span class="copyright__year"><?php echo nph_get_copyright(); ?></span> <a class="h-card copyright__credit" rel="me" href="<?php echo site_url(); ?>"><?php bloginfo('name'); ?></a></p>
        <p class="credit"><?php _e('This site uses the', 'notebook-ph'); ?> Notebook <?php _e('theme by', 'notebook-ph'); ?> <a href="http://piperhaywood.com">Piper Haywood</a>. </p>
      </div>
    </div>
  </div>

</footer>

<?php wp_footer(); ?>

</body>
</html>