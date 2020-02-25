<?php
namespace Jankx\Template;

class Loader
{
    protected $defaultTemplateDirectory;
    protected $searchedTemplate;

    public function __construct($defaultTemplateDirectory, $themePrefix = '')
    {
        $this->defaultTemplateDirectory = $defaultTemplateDirectory;
    }

    public function search($templates, $context = null)
    {
    }

    public function load($data = [], $echo = true)
    {
    }

    public function searchInDefautDirectory($templates, $context = null)
    {
    }
}
