<?php
use Jankx\Template\Loader;
use Jankx\Template\Page;
use Jankx\Template\Template;

if (function_exists('jankx_template')) {
    return;
}

/**
 * The Jankx render helper
 *
 * @return void
 */
if (! function_exists('jankx')) {
    function jankx($context = '')
    {
        $page = Page::getInstance();
        $page->render($context);
    }
}

if (! function_exists('jankx_template')) {
    function jankx_template($templates, $data = array(), $context = '', $echo = true, $templateLoader = null)
    {
        if (is_null($templateLoader)) {
            $templateLoader = Template::getLoader();
        }
        if (! ( $templateLoader instanceof Loader )) {
            throw new \Exception(
                sprintf('The template loader must be is instance of %s', Loader::class)
            );
        }

        return $templateLoader->render(
            $templates,
            $data,
            $context,
            $echo
        );
    }
}

function jankx_container_css_class($custom_classes) {
    $css_class = array(
        'jankx-container',
        'container',
    );

    if (empty($custom_classes)) {
        $custom_classes = array();
    }

    $css_class = apply_filters(
        'jankx_template_the_container_classes',
        array_merge($css_class, (array)$custom_classes)
    );

    return array_unique($css_class, SORT_STRING);
}

if (!function_exists('jankx_open_container')) {
    function jankx_open_container($custom_classes = '', $context = null) {
        do_action('jankx_template_before_open_container');

        $open_html = apply_filters('jankx_template_pre_open_container', null);
        if (!$open_html) {
            $open_html = apply_filters(
                'jankx_template_open_container',
                jankx_template('common/container-open', array(
                    'css_classes' => implode(' ', jankx_container_css_class($custom_classes))
                ), null, false)
            );
        }
        echo $open_html;

        if ($context) {
            do_action("jankx_template_opened_{$context}_container");
        }
    }
}

if (!function_exists('jankx_close_container')) {
    function jankx_close_container($context = null) {
        if ($context) {
            do_action("jankx_template_closing_{$context}_container");
        }

        $close_html = apply_filters('jankx_template_pre_close_container', null);
        if (!$close_html) {
            $close_html = apply_filters(
                'jankx_template_close_container',
                jankx_template('common/container-close', array(), null, false)
            );
        }
        echo $close_html;
        do_action('jankx_template_after_close_container');
    }
}