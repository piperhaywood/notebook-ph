<?php get_search_form(); ?>

<form>
  <select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
    <option value="">Dates</option> 
    <?php wp_get_archives( array( 'type' => 'monthly', 'format' => 'option' ) ); ?>
  </select>
</form>

<?php $default = get_option( 'default_category' ); ?>
<?php 
  $args = array(
    'orderby' => 'count',
    'exclude' => $default,
    'order' => 'DESC'
  );
?>
<?php $cats = get_categories( $args ); ?>
<?php if( $cats ) : ?>
  <form>
    <select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
      <option value="">Categories</option> 
      
      <?php foreach( $cats as $cat ) :?>
        <option value="<?php echo get_category_link( $cat->term_id ); ?>"><?php echo $cat->name; ?></option>
      <?php endforeach; ?>
    </select>
  </form>
<?php endif; ?>

<?php $tags = get_tags(); ?>
<?php if( !empty( $tags ) ) : ?>
  <ul class="post-tags">
    <?php foreach( $tags as $tag ) : ?>
      <li class="tag_<?php echo $tag->slug; ?>">
        <a href="<?php echo get_tag_link( $tag->term_id ); ?>"><?php echo $tag->name; ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>