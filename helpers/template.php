<?php
use Jankx\Template\Template;

function jankx_template($templates, $data = [], $templateLoader = null, $context = '', $echo = true) {
    if(is_null($templateLoader)) {
        $templateLoader = Template::getInstance();
    }
    $templateLoader->search($templates, $context);
    return $templateLoader->render($data, $echo);
}
