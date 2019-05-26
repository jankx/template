<?php
use \Jankx\Template\Exception;

function jankx_page($originTemplate)
{
    $template = apply_filters('jankx_template_engine', '\Jankx\Template\Engine\WordPress');
    if (!class_exists($template)) {
        throw new Exception(
            sprintf('The engine with class "%s " is not exists to load', $template),
            Exception::TEMPLATE_EXCEPTION_ENGINE_NOT_FOUND
        );
    }
    $GLOBALS['template_engine'] = new $template($originTemplate);
    if (!$GLOBALS['template_engine'] instanceof \Jankx\Template\EngineAbstract) {
        throw new Exception(
            'The template engine must be an instance of Jankx\Template\EngineAbstract class',
            Exception::TEMPLATE_EXCEPTION_INVALID_ENGINE
        );
    }

    $GLOBALS['template_engine']->render();
}

function jankx_get_template_engine()
{
    return $GLOBALS['template_engine'];
}

function jankx_template($templateFile)
{
    /**
     * Get current template engine is used in Jankx framework
     */
    $engine = jankx_get_template_engine();

    $search_template = sprintf(
        '%s/%s%s',
        Jankx::templateDirectory(),
        $templateFile,
        $engine->templateExtension()
    );
    $default_template = sprintf(
        '%s/%s%s',
        $engine->getDefaultTemplateDirectory(__FILE__),
        $templateFile,
        $engine->templateExtension()
    );

    return $engine->loadTemplates(
        apply_filters('jankx_search_templates', array(
            $search_template,
            $default_template
        ))
    );
}
