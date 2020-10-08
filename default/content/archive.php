<?php
/**
 * Content page index
 */

/**
 * The index page content will be render via action hook
 *
 * Hooked:
 *  - N/A
 */

if (is_post_type_archive()) {
    do_action('jankx_template_page_post_type_archive_content', get_post_type());
} elseif(is_tax()) {
    $queried_object = get_queried_object();
    do_action('jankx_template_page_taxonomy_content', $queried_object);
}
