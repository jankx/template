<div class="<?php post_class(); ?>">
    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
        <?php jankx_the_post_thumbnail('thumbnail'); ?>
    </a>
    <div class="post-infos">
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        </h2>
    </div>
</div>
