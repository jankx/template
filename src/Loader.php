<?php
namespace Jankx\Template;

use Jankx\Template\Engine\Engine;

class Loader
{
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
