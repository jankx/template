<?php
namespace Jankx\Template;

use Jankx\Template\Engine\Engine;

class Loader
{
    protected $templateEngine;
    protected $defaultTemplateDirectory;
    protected $directoryInTheme;

    public function __construct($defaultTemplateDirectory, $directoryInTheme = '', $engine = null)
    {
        $this->directoryInTheme = $directoryInTheme;
        if (!is_null($engine)) {
            $this->setTemplateEngine($engine);
        }
        $this->defaultTemplateDirectory = apply_filters(
            "jankx_template_{$defaultTemplateDirectory}_default_directory",
            $defaultTemplateDirectory
        );
    }

    public function setTemplateEngine($engine)
    {
        if (!($engine instanceof Engine)) {
            throw new \Error(
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
                $this->defaultTemplateDirectory,
                $this->directoryInTheme,
                $this->templateEngine
            );
        }
        $this->templateEngine->render($templates, $data, $echo);
    }
}
