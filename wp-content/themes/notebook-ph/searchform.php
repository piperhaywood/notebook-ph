<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url(home_url('/')); ?>">
  <fieldset>
    <label class="screen-reader-text" for="s"><?php _x('Search for:', 'label'); ?></label>
    <input type="text" autocomplete="off" value="" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="<?php echo esc_attr_x('Search', 'submit button'); ?>" />
  </fieldset>
</form>