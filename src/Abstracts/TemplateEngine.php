<?php
namespace Jankx\Template\Abstracts;

use Jankx\Template\Interfaces\TemplateEngine as IntefaceTemplateEngine;
use Jankx\Template\Boilerplate\HTML5Boilerplate;
use Jankx\Template\Exceptions\TemplateException;
use Jankx\Template\Traits\PageTemplate;

abstract class TemplateEngine implements IntefaceTemplateEngine
{
    use PageTemplate;

    public $templateFile;
    public $rootDirectory;
    public $baseTemplate;
    public $pageTemplate;
    public $pageType;
    protected $boilerplate;

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

            $boilerplate_class = apply_filters('boilerplate_adapter_class', HTML5Boilerplate::class);
            if (class_exists($boilerplate_class)) {
                $boilerplate = new $boilerplate_class();

                if ($boilerplate instanceof BoilerPlate) {
                    $this->boilerplate = $boilerplate;
                } else {
                    throw new TemplateException(
                        sprintf('%s class must is an instance of %s', $boilerplate_class, 'ad'),
                        TemplateException::TEMPLATE_EXCEPTION_INVALID_BOILERPLATE
                    );
                }
            } else {
                throw new TemplateException(
                    sprintf('Jankx template engine must be have define boilerplate'),
                    TemplateException::TEMPLATE_EXCEPTION_NOT_FOUND_BOILERPLATE
                );
            }
        }
    }

    public function getHeader($name = null)
    {
        do_action('jankx_before_header', $name);

        /**
         * Call to WordPress native function to get site header
         * Use WordPress native to integrated with other library and plugins.
         */
        get_header($name);

        do_action('jankx_after_header', $name);
    }

    public function getContent($name)
    {
        do_action('jankx_before_content');
        jankx_template($name);
        do_action('jankx_after_content');
    }

    public function getSidebar($name = null)
    {
        do_action('jankx_before_sidebar', $name);

        /**
         * Call to WordPress native function to get site sidebar
         * Use WordPress native to integrated with other library and plugins.
         */
        get_sidebar($name);

        do_action('jankx_after_sidebar', $name);
    }

    public function getFooter($name = null)
    {
        do_action('jankx_before_footer', $name);

        /**
         * Call to WordPress native function to get site footer
         * Use WordPress native to integrated with other library and plugins.
         */
        get_footer($name);

        do_action('jankx_after_footer', $name);
    }

    public function defaultHandler()
    {
        echo 'defaultHandler';
    }

    public function render()
    {
        $this->boilerplate->doctype();
        $this->boilerplate->head();

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
            $this->defaultHandler();
        }

        $this->boilerplate->footer();
    }
}