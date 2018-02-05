<footer class="footer">
  
  <div class="footer__content">
    <?php nph_menu_footer(); ?>
    <p class="footer__copyright copyright"><span class="copyright__year"><?php echo nph_get_copyright(); ?></span> <a class="copyright__credit" href="<?php echo site_url(); ?>"><?php bloginfo('name'); ?></a></p>
    <p class="credit"><?php _e('This site uses the', 'notebook-ph'); ?> Notebook <?php _e('theme by', 'notebook-ph'); ?> <a href="http://piperhaywood.com">Piper Haywood</a>. </p>
  </div>

</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>