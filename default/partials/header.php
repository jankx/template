<?php
/**
 * Header template for Polido
 *
 * @package UI
 */

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
	<?php
		$args = array();
		Jankx::menu(
			'primary',
			$args
		);
	?>
	</div>
</nav>
