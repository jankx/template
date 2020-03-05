<?php
use Jankx\Template\Template;
use Jankx\Template\Loader;
use Jankx\Template\Page;

/**
 * The Jankx render helper
 *
 * @return void
 */
function jankx($context = '') {
    $page = Page::getInstance();
    $page->render($context);
}

function jankx_template($templates, $data = [], $context = '', $echo = true,  $templateLoader = null) {
    if (is_null($templateLoader)) {
        $templateLoader = Template::getInstance();
    }
    if (!($templateLoader instanceof Loader)) {
        throw new \Error(
            sprintf('The template loader must be is instance of %s', Loader::class)
        );
    }

    return $templateLoader->render(
        $templates,
        $data,
        $echo
    );
}