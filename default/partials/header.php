<?php
/**
 * Header template for Polido
 *
 * @package UI
 */

?>
<nav class="topheader navbar navbar-expand navbar-light bg-light rounded">
	<div class="container">
		<?php Jankx::logo(); ?>
		<div class="collapse navbar-collapse" id="top-header">
			<?php get_search_form(); ?>
		</div>
	</div>
</nav>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu"
			aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="main-menu">
			<?php
			$args = array();
			if ( wp_is_mobile() ) {
				$args = array(
					'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
					'container'       => 'div',
					'container_class' => 'collapse navbar-collapse',
					'container_id'    => 'main-menu',
					'menu_class'      => 'navbar-nav mr-auto',
					'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
					'walker'          => new WP_Bootstrap_Navwalker(),
				);
			}
			Jankx::menu(
				'primary',
				$args
			);
			?>
		</div>
	</div>
</nav>

<?php if ( ! is_user_logged_in() ) : ?>
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
	  <div class="modal-body">
	  <?php echo do_shortcode( '[wc_login_form_bbloomer]' ); ?>
	  </div>
	</div>
  </div>
</div>

<div class="modal fade" id="signup-model" tabindex="-1" role="dialog" aria-labelledby="signup-modelTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
	  <div class="modal-body">
	  <?php echo do_shortcode( '[wc_reg_form_bbloomer]' ); ?>

	  </div>
	</div>
  </div>
</div>
<?php endif; ?>
