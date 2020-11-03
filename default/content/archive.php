<?php
/**
 * Content page index
 */
use Jankx\PostLayout\PostLayoutManager;

/**
 * The index page content will be render via action hook
 *
 * Hooked:
 *  - N/A
 */
$template_hook = 'jankx_template_archive_content';
if (is_post_type_archive()) {
    $template_hook = 'jankx_template_page_post_type_archive_content';
} elseif (is_tax()) {
    $template_hook = 'jankx_template_page_taxonomy_content';
}

if (has_action($template_hook)) {
    do_action($template_hook, get_queried_object());
} else {
    $layoutManager = PostLayoutManager::getInstance();
    $postLayoutCls = $layoutManager->getLayoutClass(PostLayoutManager::CARD);
    $postLayout = new $postLayoutCls($GLOBALS['wp_query']);
    $postLayout->setOptions(array(
        'columns' => 4,
        'show_excerpt' => true,
        'post_meta_features' => array(
            'post_date' => true,
        ),
    ));
    echo $postLayout->render();

    // Create pagination
    jankx_paginate();
}
