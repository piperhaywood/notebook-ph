<?php $years = nph_group_posts_by_year(); ?>
<?php foreach ($years as $year => $posts) : ?>
  <details class="year">
    <summary class="year-summary">
      <?php echo $year; ?>
    </summary>
    <p class="year-posts">
      <?php foreach ($posts as $p) : ?>
        <a class="has-bg year-post" style="--color: <?php echo $p['hsl']; ?>" href="<?php echo $p['permalink']; ?>">
          <?php echo get_the_date('d M Y', $p['id']); ?> &mdash; <?php echo $p['title']; ?>
        </a>
      <?php endforeach; ?>
    </p>
  </details>
<?php endforeach; ?>