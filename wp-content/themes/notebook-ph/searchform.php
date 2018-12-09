<form role="search" method="get" id="searchform" class="searchform browse__search" action="<?php echo esc_url(home_url('/')); ?>">
  <label class="screen-reader-text" for="s"><?php _e('Search for:', 'label'); ?></label>
  <input type="text" autocomplete="off" value="" name="s" id="s" />
  <input type="submit" id="searchsubmit" value="<?php echo esc_attr_x('Search', 'submit button'); ?>" />
</form>