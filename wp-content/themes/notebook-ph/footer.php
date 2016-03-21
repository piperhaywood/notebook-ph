<footer class="footer footer--flex">
  
  <div class="footer--flex__1">
    <div class="footer__copyright">
      <p><?php echo nph_get_copyright(); ?></p>
    </div>
  </div>
  <div class="footer--flex__2">
    <div class="footer__text">
      <p>My name is <a href="http://piperhaywood.com">Piper Haywood</a>, and this is where I keep my notes. </p>
      <?php nph_menu_footer(); ?>
      <p class="credit"> Notebook <?php _e( 'theme by', 'notebook-ph' ); ?> <a href="http://piperhaywood.com">Piper Haywood</a>. </p>
    </div>
  </div>
  <div class="footer--flex__3">
    <div class="footer__nav">
      <p>&nbsp;</p>
    </div>
  </div>
</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>