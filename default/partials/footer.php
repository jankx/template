<div class="before-footer-widget">
<?php
	global $post;
	$post = get_post( 1960 );
	setup_postdata( $post );
	the_content();
	wp_reset_postdata();
?>
</div>
<div class="footer-widget-area">
	<div class="container">
		<?php Jankx::footerWidgets(); ?>
	</div>
</div>

<div class="site-footer">
	<div class="container">
		<div class="footer-copyright">Copyright &copy; 2019 POLIDO VIỆT NAM. All rights resersed.</div>
	</div>
</div>
