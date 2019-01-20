<?php $tags = get_tags(); ?>
<?php if (!empty($tags)) : ?>
  <ul class="post__tags">
    <?php foreach($tags as $tag) : // TODO dry this out ?>
      <?php if ($tag->count > 1) : ?>
        <?php $opacity = nph_tag_opacity($tag); ?>
        <li class="post__tag" style="--tag-color: rgba(34,34,34,<?php echo $opacity; ?>);">
          <a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a><span class="separator">, </span>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>