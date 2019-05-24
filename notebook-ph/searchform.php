<form role="search" method="get" id="searchform" class="searchform browse__search" action="<?php echo esc_url(home_url('/')); ?>">
  <label class="screen-reader-text" for="s"><?php echo esc_attr_x('Search for:', 'label', 'notebook-ph'); ?></label>
  <div class="searchform__group">
    <input type="text" autocomplete="off" value="" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="<?php echo esc_attr_x('Search', 'submit button', 'notebook-ph'); ?>" />
  </div>
</form>