<div class="browse__methods">

  <div class="browse__method">
    <?php get_search_form(); ?>
  </div>

  <form class="browse__method">
    <select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
      <option value="">Dates</option> 
      <?php wp_get_archives(array('type' => 'monthly', 'format' => 'option')); ?>
    </select>
  </form>

  <?php $default = get_option('default_category'); ?>
  <?php 
    $args = array(
      'orderby' => 'count',
      'exclude' => $default,
      'order' => 'DESC'
    );
  ?>
  <?php $cats = get_categories($args); ?>
  <?php if ($cats) : ?>
    <form class="browse__method">
      <select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
        <option value="">Categories</option> 
        
        <?php foreach($cats as $cat) :?>
          <option value="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->name; ?></option>
        <?php endforeach; ?>
      </select>
    </form>
  <?php endif; ?>
</div>

<?php $tags = get_tags(); ?>
<?php if (!empty($tags)) : ?>
  <ul class="post__tags">
    <?php foreach($tags as $tag) : // TODO dry this out ?>
      <?php if ($tag->count > 1) : ?>
        <?php $opacity = nph_tag_opacity($tag); ?>
        <li class="post__tag" style="--tag-color: rgba(34,34,34,<?php echo $opacity; ?>);">
          <a href="<?php echo get_tag_link($tag->term_id); ?>">
            <?php echo $tag->slug; ?>
          </a>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>