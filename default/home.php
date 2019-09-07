<h1 class="page-title">
	<span>Blog/Thông tin</span>
</h1>
<div class="divider">
	<span></span>
</div>

<?php
if ( have_posts() ) {
	echo '<div class="row">';
	while ( have_posts() ) {
		the_post();
		jankx_template( 'loop/post' );
	}
	echo '</div>';
}
