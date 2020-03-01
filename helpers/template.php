<?php
use Jankx\Template\Template;

function jankx_template($templates, $data = [], $templateLoader = null, $context = '', $echo = true) {
    if(is_null($templateLoader)) {
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
