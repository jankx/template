<div class="<?php post_class(); ?>">
    <div class="post-thumbnail"><?php jankx_the_post_thumbnail('thumbnail'); ?></div>
    <div class="post-infos">
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        </h2>
    </div>
</div>
