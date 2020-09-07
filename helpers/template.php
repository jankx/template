<?php
use Jankx\Template\Template;
use Jankx\Template\Loader;
use Jankx\Template\Page;

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
            $templateLoader = Template::getInstance();
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
