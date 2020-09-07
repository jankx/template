  <?php do_action( 'jankx_template_before_footer' ); ?>
    <footer id="jankx-site-footer" class="jankx-site-header">
      <?php do_action('jankx_template_before_footer_content'); ?>

        <?php jankx_component( 'footer' ); ?>

      <?php do_action('jankx_template_after_footer_content'); ?>
    </footer>
  <?php do_action( 'jankx_template_after_footer' ); ?>

  <?php wp_footer(); ?>
  </body>
</html>