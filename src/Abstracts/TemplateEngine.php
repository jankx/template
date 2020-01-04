<?php
namespace Jankx\Template\Abstracts;

use Jankx;
use Jankx\Template\Interfaces\TemplateEngine as IntefaceTemplateEngine;
use Jankx\Template\Boilerplate\HTML5Boilerplate;
use Jankx\Template\Exceptions\TemplateException;
use Jankx\Template\Traits\PageTemplate;

abstract class TemplateEngine implements IntefaceTemplateEngine
{
    use PageTemplate;

    protected $boilerplate;
    protected $autoloaded;
    protected $wpThemeRootDir;
    protected $templateDirInTheme;
    protected $defaultTemplateDirName;

    public $baseTemplate;
    public $pageTemplate;
    public $pageType;
    public $rootDirectory;
    public $templateFile;



    public function __construct()
    {
        if (is_string($roots = get_theme_roots())) {
            $this->wpThemeRootDir = sprintf('%s%s/', WP_CONTENT_DIR, $roots);
        }

        $defaultTemplateDirName = $this->getDefaultTemplateDirectory();
        if (($pos= strpos($defaultTemplateDirName, $this->wpThemeRootDir)) !== false) {
            $this->templateDirInTheme = true;
            $this->defaultTemplateDirName = substr($defaultTemplateDirName, $pos + strlen(get_template_directory()) + 1);
        }
    }


    public function setOriginTemplate($templateFile)
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

    public function setAutoloaded($autoloaded = false)
    {
        /**
         * This variable use as flag to specify the template render via Jankx or not
         */
        $this->autoloaded = $autoloaded;
    }

    public function getBoilerplate()
    {
        return $this->boilerplate;
    }

    public function getHeader($name = null)
    {
        /**
         * Do all actions before get site header
         */
        do_action('jankx_before_header', $name);

        /**
         * Call to WordPress native function to get site header
         * Use WordPress native to integrated with other library and plugins.
         */
        get_header($name);

        /**
         * Do all actions after get site header
         */
        do_action('jankx_after_header', $name);
    }

    public function getContent($name, $context = '')
    {
        do_action('jankx_before_main_content', $name);
        $pre = apply_filters("jankx_content_{$context}", null, $name);
        if (empty($pre)) {
            jankx_template($name);
        } else {
            echo wp_kses_post($pre);
        }

        do_action('jankx_after_main_content', $name);
    }

    public function getSidebar($name = null)
    {
        /**
         * Do all actions before get sidebar
         */
        do_action('jankx_before_sidebar', $name);

        /**
         * Call to WordPress native function to get site sidebar
         * Use WordPress native to integrated with other library and plugins.
         */
        get_sidebar($name);

        /**
         * Do all actions after get sidebar
         */
        do_action('jankx_after_sidebar', $name);
    }

    public function getFooter($name = null)
    {
        /**
         * Do all actions before get site footer
         */
        do_action('jankx_before_footer', $name);

        /**
         * Call to WordPress native function to get site footer
         * Use WordPress native to integrated with other library and plugins.
         */
        get_footer($name);

        /**
         * Do all actions after get site footer
         */
        do_action('jankx_after_footer', $name);
    }

    public function defaultHandler()
    {
        $pre_404 = apply_filters('jankx_404_custom_content', null);
        if ($pre_404) {
            echo $pre_404;
            return;
        }

        $this->getHeader();
        $this->getContent(array(
            '404'
        ));
        $this->getFooter();
    }

    public function render()
    {
        $this->boilerplate->doctype();
        $this->boilerplate->head();


        $handler = array($this, $this->pageTemplate);
        if ($this->autoloaded) {
            $handler = array($this, 'autoload');
        }

        $contentHandler = apply_filters(
            'jankx_page_handler',
            $handler,
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

    protected function searchTemplates($templateFiles)
    {
        $templateFiles = (array)$templateFiles;
        foreach ($templateFiles as $index => $templateFile) {
            $templateFiles[$index] = sprintf(
                '%s/%s%s',
                Jankx::templateDirectory(),
                $templateFile,
                $this->templateExtension()
            );

            if ($this->templateDirInTheme) {
                $templateFiles[] = sprintf(
                    '%s/%s%s',
                    $this->defaultTemplateDirName,
                    $templateFile,
                    $this->templateExtension()
                );
            }
        }

        return $templateFiles;
    }
}
