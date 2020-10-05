<article <?php post_class(); ?>>
    <?php if (apply_filters('jankx_template_page_single_page_header', true, $GLOBALS['post'])): ?>
    <h1 class="jankx-header page-header"><?php the_title(); ?></h1>
    <?php endif; ?>
    <div class="post-content">
        <?php the_content(); ?>
    </div>
</article>
