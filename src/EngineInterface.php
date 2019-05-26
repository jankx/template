<?php
namespace Jankx\Template;

interface EngineInterface
{
    public function templateExtension();

    public function getDefaultTemplateDirectory($fileInRoot);

    public function getHeader($name = null);

    public function getSidebar($name = null);

    public function getFooter($name = null);

    public function loadTemplates($templates);
}
