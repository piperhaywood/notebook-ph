<?php

// Set up the index groups
$groups = array(); 

// Add the terms to the index
$terms = get_terms(array(
  'taxonomy' => array('post_tag', 'category', 'post_format')
));
if ($terms && is_array($terms)) {
  foreach ($terms as $term) {
    if ($term->count > 1) {
      // NOTE strip "post-format-" from slug, for some reason this gets included
      $slug = str_replace('post-format-', '', $term->slug);
      $tax = get_taxonomy($term->taxonomy);
      $groups = nph_add_to_index($groups, array(
        'name' => $term->name,
        'url' => get_tag_link($term->term_id),
        'count' => $term->count,
        'slug' => $slug,
        'type' => $term->taxonomy,
        'aria' => sprintf(__('%s: %s, %s posts', 'notebook-ph'), $tax->labels->singular_name, $term->name, $term->count)
      ));
    }
  }
}

// Add the year archives to the index
$years = nph_get_years_array();
if ($years) {
  $args = array(
    'posts_per_page' => -1,
    'post_type' => 'post',
    'fields' => 'ids'
  );
  foreach ($years as $year) {
    $args['date_query'] = array(
      array('year' => $year)
    );
    $posts = get_posts($args);
    $count = count($posts);
    $groups = nph_add_to_index($groups, array(
      'name' => $year,
      'url' => get_year_link($year),
      'count' => $count,
      'slug' => $year,
      'type' => 'year',
      'aria' => sprintf(__('Year: %s, %s posts', 'notebook-ph'), $year, $count)
    ));
  }
}

?>

<?php if (!empty($groups)) : ?>
  <?php foreach ($groups as $char => $terms) : ?>
    <?php ksort($terms); ?>
    <h2><?php echo apply_filters( 'the_title', $char ); ?></h2>
    <ol>
    <?php foreach ($terms as $slug => $term) : ?>
      <li>
        <a aria-label="<?php echo $term['aria']; ?>" href="<?php echo $term['url']; ?>"><span class="term term--<?php echo $term['type']; ?>"><?php echo $term['name']; ?></span>&nbsp;<span class="term__count"><?php echo $term['count']; ?></span></a>
      </li>
    <?php endforeach; ?>
</ol>
  <?php endforeach; ?>
<?php endif; ?>
