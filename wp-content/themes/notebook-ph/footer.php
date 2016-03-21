<footer class="footer footer--flex">
  
  <div class="footer--flex__1">
    <div class="footer__copyright">
      <?php
      
      $copy = '';
      $args = array(
        'order' => 'ASC',
        'posts_per_page' => 1,
        'post_type' => 'any',
      	'post_status' => 'publish,private,draft'
      );
      $posts_array = get_posts( $args );
      if ( !empty( $posts_array ) ) {
        $copy .= get_the_date( 'Y', $posts_array[0]->ID ) . '&ndash;';
      }
      
      $copy .= date( 'Y' );
  
  ?>

      <p>&copy; <?php echo $copy; ?></p>
    </div>
  </div>
  <div class="footer--flex__2">
    <div class="footer__text">
      <p>Notebook <?php _e( 'theme by', 'notebook-ph' ); ?> <a href="http://piperhaywood.com">Piper Haywood</a>. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Cras mattis consectetur purus sit amet fermentum. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Maecenas faucibus mollis interdum. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
    </div>
  </div>
  <div class="footer--flex__3">
    <div class="footer__nav">
      &nbsp;
    </div>
  </div>
</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>