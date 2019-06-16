<?php
namespace Jankx\Template\Abstracts;

use Jankx\Template\Interfaces\TemplateEngine as IntefaceTemplateEngine;

abstract class TemplateEngine implements IntefaceTemplateEngine
{
    public $templateFile;
    public $rootDirectory;
    public $baseTemplate;
    public $pageTemplate;
    public $pageType;

    public function __construct($templateFile)
    {
        if (preg_match('/(.+)\/([^\/]*)\.php$/', trim($templateFile), $matches)) {
            list($this->templateFile, $this->rootDirectory, $this->baseTemplate) = $matches;
            $pos = strpos($this->baseTemplate, '-');
            if (is_numeric($pos)) {
                $this->pageTemplate = substr($this->baseTemplate, 0, $pos);
                $this->pageType = substr($this->baseTemplate, $pos + 1);
            } else {
                $this->pageTemplate = $this->baseTemplate;
            }
        }
    }

    public function getHeader($name = null)
    {
        /**
         * Call to WordPress native function to get site header
         * Use WordPress native to integrated with other library and plugins.
         */
        get_header($name);
    }

    public function getSidebar($name = null)
    {
    }

    public function getFooter($name = null)
    {
        /**
         * Call to WordPress native function to get site footer
         * Use WordPress native to integrated with other library and plugins.
         */
        get_footer($name);
    }

    public function render()
    {
        $this->getHeader();
        $contentHandler = apply_filters(
            'jankx_page_handler',
            array($this, $this->pageTemplate),
            $this->pageTemplate,
            $this->pageType,
            $this->templateFile
        );
        if (is_callable($contentHandler)) {
            call_user_func($contentHandler);
        } else {
        }
        $this->getFooter();
    }
}
