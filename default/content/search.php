<?php
use Jankx\PostLayout\PostLayout;
use Jankx\PostLayout\PostLayoutManager;
?>
<div class="seach-results-main">
    <?php jankx_open_container(); ?>
    <h1 class="page-header">
        <?php echo sprintf(__('Search results for "%s"', 'jankx'), get_search_query()); ?>
    </h1>
    <?php
    global $wp_query;
    if ($wp_query->have_posts()):
        ?>
        <div class="search-resuls">
        <?php
            $layoutManager = PostLayoutManager::getInstance();
            $layoutStyle   = apply_filters(
                "jankx_search_results_layout_style",
                PostLayoutManager::CARD
            );
            $layoutCls     = $layoutManager->getLayoutClass($layoutStyle);

            // Create post layout style instance
            $postLayoutInstance = new $layoutCls($wp_query);

            // Render posts
            if (is_a($postLayoutInstance, PostLayout::class)) {
                echo $postLayoutInstance->render();
            }
        ?>
        </div>
    <?php else: ?>
    <div class="no-results"><?php _e('Not found', 'jankx'); ?></div>
    <?php endif; ?>

    <?php jankx_close_container(); ?>
</div>