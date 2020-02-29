<?php
namespace Jankx\Template;

use Jankx\Template\Engine\Engine;

class Loader
{
    protected $templateEngine;
    protected $defaultTemplateDirectory;
    protected $directoryInTheme;
    protected $searchedTemplate;

    public function __construct($defaultTemplateDirectory, $directoryInTheme = '', $engine = null)
    {
        $this->defaultTemplateDirectory = $defaultTemplateDirectory;
        $this->directoryInTheme = $directoryInTheme;

        if (!is_null($engine)) {
            $this->setTemplateEngine($engine);
        }
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

    public function search($templates, $context = null)
    {
    }

    public function render($data = [], $echo = true)
    {
    }

    public function searchInDefautDirectory($templates, $context = null)
    {
    }
}
