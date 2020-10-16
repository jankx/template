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
    global $wp_query, $post;
    if ($wp_query->have_posts()):
    $grouped_posts = array();

    foreach($wp_query->posts as $post) {
        $grouped_posts[$post->post_type][] = $post;
    }
    asort($grouped_posts);
    ?>

    <?php foreach($grouped_posts as $post_type => $posts): ?>
        <?php
            $post_type_object = get_post_type_object($post_type);
        ?>
        <h2 class="search-subtitle"><?php echo $post_type_object->label; ?></h2>
        <div class="search-resuls-<?php echo $post_type; ?>">
        <?php
            $clone_wp_query = clone $wp_query;
            $clone_wp_query->posts = $posts;
            $clone_wp_query->post_count = count($posts);
            $customHook = "jankx_search_results_{$post_type}";
            if (has_action($customHook)) {
                do_action($customHook, $clone_wp_query);
            } else {
                $layoutManager = PostLayoutManager::getInstance();
                $layoutStyle   = apply_filters(
                    "jankx_search_{$post_type}_layout_style",
                    PostLayoutManager::PRESET_1
                );
                $layoutCls     = $layoutManager->getLayoutClass($layoutStyle);

                // Create post layout style instance
                $postLayoutInstance = new $layoutCls($clone_wp_query);

                // Render posts
                if (is_a($postLayoutInstance, PostLayout::class)) {
                    echo $postLayoutInstance->render();
                }
            }
        ?>
        </div>
    <?php endforeach; ?>

    <?php else: ?>
    <div class="no-results"><?php _e('Not found', 'jankx'); ?></div>
    <?php endif; ?>

    <?php jankx_close_container(); ?>
</div>