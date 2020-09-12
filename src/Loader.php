<?php
namespace Jankx\Template;

use Jankx\Template\Engine\Engine;

class Loader
{
    protected static $templateLoaded;

    protected $templateEngine;

    public function __construct($engine = null)
    {
        if (!is_null($engine)) {
            $this->setTemplateEngine($engine);
        }
    }

    public function setTemplateEngine($engine)
    {
        if (!($engine instanceof Engine)) {
            throw new \Exception(
                sprintf('The template engine must is an instance of %s', Engine::class)
            );
        }
        $this->templateEngine = $engine;
    }

    public function load()
    {
        if (!static::$templateLoaded) {
            /**
             * Create a flag to check Jankx template library is loaded
             */
            static::$templateLoaded = true;

            Template::loadTemplateHelpers();

            $pageTemplate = Page::getInstance();

            // Call the Jankx Page
            add_filter('template_include', array($pageTemplate, 'callTemplate'), 99);
        }
        Template::setDefautLoader();
    }

    public function searchTemplate($templates, $context = null)
    {
        if ($context) {
            $templates = apply_filters(
                "jankx_load_template_{$context}",
                $templates,
                $this->templateEngine
            );
        }
        return $this->templateEngine->searchTemplate($templates);
    }

    public function render($templates, $data = [], $context = null, $echo = true)
    {
        if ($context) {
            $templates = apply_filters(
                "jankx_load_template_{$context}",
                $templates,
                $this->templateEngine
            );
        }
        return $this->templateEngine->render($templates, $data, $echo);
    }
}
