<?php

use Jankx\Template\Exceptions\TemplateException;

use Jankx\Template\Engine\WordPress;
use Jankx\Template\Abstracts\TemplateEngine;

/**
 * This function use to load page template via Template Engine
 *
 * @param   [type]  $originTemplate  [$originTemplate description]
 *
 * @return  [type]                   [return description]
 */
function jankx_page($originTemplate)
{
    $template = apply_filters('jankx_template_engine', WordPress::class);
    if (!class_exists($template)) {
        throw new TemplateException(
            sprintf('The engine with class "%s " is not exists to load', $template),
            TemplateException::TEMPLATE_EXCEPTION_ENGINE_NOT_FOUND
        );
    }
    $GLOBALS['template_engine'] = new $template($originTemplate);
    if (!$GLOBALS['template_engine'] instanceof TemplateEngine) {
        throw new TemplateException(
            sprintf('The template engine must be an instance of %s class', TemplateEngine::class),
            TemplateException::TEMPLATE_EXCEPTION_INVALID_ENGINE
        );
    }

    do_action('jankx_page_setup', $GLOBALS['template_engine']);

    $GLOBALS['template_engine']->render();
}

function jankx_get_template_engine()
{
    return $GLOBALS['template_engine'];
}

function jankx_template($templateFiles)
{
    /**
     * Get current template engine is used in Jankx framework
     */
    $engine = jankx_get_template_engine();
    $templateFiles = (array)$templateFiles;

    foreach ($templateFiles as $index => $templateFile) {
        $templateFiles[$index] = sprintf(
            '%s/%s%s',
            Jankx::templateDirectory(),
            $templateFile,
            $engine->templateExtension()
        );
        $templateFiles[] = sprintf(
            '%s/%s%s',
            $engine->getDefaultTemplateDirectory(),
            $templateFile,
            $engine->templateExtension()
        );
    }

    return $engine->loadTemplates(
        apply_filters('jankx_search_templates', $templateFiles)
    );
}
