<?php
namespace Jankx\Template\Interfaces;

interface TemplateEngine
{
    public function templateExtension();

    public function getDefaultTemplateDirectory();

    public function getHeader($name = null);

    public function getSidebar($name = null);

    public function getFooter($name = null);

    public function loadTemplates($templates);
}
