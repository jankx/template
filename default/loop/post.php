<div class="col-md-4">
	<div class="image-wrap">
		<?php Jankx::post()->thumbnail(); ?>
	</div>
	<h2 class="post-title">
		<?php Jankx::post()->title(); ?>
	</h2>

	<div class="description">
		<?php the_excerpt(); ?>
	</div>
</div>
