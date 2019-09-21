<?php if ( Jankx::hasActiveFooterWidgets() ) : ?>
	<div class="footer-widget-area">
		<?php Jankx::container(); ?>
			<?php Jankx::footerWidgets(); ?>
		</div>
	</div>
<?php endif; ?>

<div class="site-footer">
	<?php Jankx::container(); ?>
		<div class="footer-copyright"><?php Jankx::copyright(); ?></div>
	</div>
</div>
