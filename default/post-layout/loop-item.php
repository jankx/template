<div <?php post_class('loop-item'); ?>>
    <div class="post-thumbnail">
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php jankx_the_post_thumbnail($thumbnail_size); ?>
        </a>
    </div>
    <div class="post-infos">
        <?php if ($show_title): ?>
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        </h2>
        <?php endif; ?>
    </div>
</div>
