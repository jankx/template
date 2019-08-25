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
			<div id="header-menu" class="collapse navbar-collapse">
				<ul id="menu-top-menu" class="navbar-nav ml-auto">
					<li id="store" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2008 nav-item">
						<div class="icon">
							<img src="<?php echo site_url( 'wp-content/uploads/2019/07/map-marker-solid.svg' ); ?>" class="_mi _before _svg" aria-hidden="true"><span></span>
						</div>
						<div class="content">
							<a title="Hệ thống" href="<?php echo site_url( 'he-thong-cua-hang' ); ?>">
								<span>Hệ thống</span>
								<span>cửa hàng</span>
							</a>
						</div>
					</li>
					<li id="user-actions" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2010 nav-item">
						<div class="icon">
							<img src="<?php echo site_url( 'wp-content/uploads/2019/07/user-alt-solid.svg' ); ?>" class="_mi _before _svg" aria-hidden="true">
						</div>
						<div class="content">
							<?php if ( ! is_user_logged_in() ) : ?>
							<div>
								<a href="#" data-toggle="modal" data-target="#signup-model">Đăng ký</a>
							</div>
							<div>
							<a href="#" data-toggle="modal" data-target="#login-modal">Đăng nhập</a>
							</div>
							<?php else : ?>
							<div>
								<a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">Tài khoản</a>
							</div>
							<div>
							<a href="<?php echo wp_logout_url( home_url() ); ?>">Đăng xuất</a>
							</div>
							<?php endif; ?>
						</div>
					</li>
					<li id="cart" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2013 nav-item">
						<div class="icon">
						<img src="<?php echo site_url( 'wp-content/uploads/2019/07/shopping-basket-solid.svg' ); ?>" class="_mi _before _svg" aria-hidden="true">
						</div>
						<div class="content">
							<a title="Giỏ hàng" href="<?php echo wc_get_cart_url(); ?>">
								<span>
									<div>Giỏ hàng</div>
									<div style="font-size: 12px;">
										<?php echo WC()->cart->get_cart_contents_count(); ?> sản phẩm
									</div>
								</span>
							</a>
						</div>
					</li>
				</ul>
			</div>
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
