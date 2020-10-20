<div <?php post_class($post_class); ?>>
    <?php if (!empty($show_thumbnail)) : ?>
    <div class="post-thumbnail">
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php jankx_the_post_thumbnail($thumbnail_size); ?>
        </a>
    </div>
    <?php endif; ?>
    <div class="post-infos">
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        </h2>
    </div>
</div>
