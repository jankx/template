<?php
namespace Jankx\Template;

use Jankx\Template\Engine\EngineManager;

class Template
{
    protected static $instances = [];
    protected static $templateLoaded;
    protected static $defautLoader;

    public static function getInstance($templateFileLoader = null, $directoryInTheme = '', $engineName = 'wordpress')
    {
        if (is_null($templateFileLoader) && static::$defautLoader) {
            $templateFileLoader = static::$defautLoader;
        }
        if (empty(static::$instances[$templateFileLoader])) {
            $applyTemplateEngine = apply_filters(
                'jankx_template_engine',
                $engineName,
                $templateFileLoader,
                $directoryInTheme
            );
            $engine = EngineManager::createEngine(
                $templateFileLoader,
                $applyTemplateEngine,
                array(
                    'template_directory' => $directoryInTheme,
                    'template_location' => $templateFileLoader,
                )
            );
            $loader = new Loader();
            $loader->setTemplateEngine($engine);

            static::$instances[$templateFileLoader] = $loader;
        }
        return static::$instances[$templateFileLoader];
    }

    public function load()
    {
        if (!static::$templateLoaded) {
            /**
             * Create a flag to check Jankx template library is loaded
             */
            static::$templateLoaded = true;

            static::loadTemplateHelpers();

            $pageTemplate = Page::getInstance();
            add_filter('template_include', array($pageTemplate, 'callTemplate'), 99);
        }

        if (defined('JANKX_THEME_DEFAULT_ENGINE')) {
            static::$defautLoader = apply_filters(
                'jankx_default_template_loader',
                JANKX_THEME_DEFAULT_ENGINE
            );
        }
    }

    public static function loadTemplateHelpers()
    {
        $helpersDir = realpath(dirname(__FILE__) . '/../helpers');

        /**
         * Load Jankx template helpers
         */
        require_once $helpersDir . '/template.php';
    }
}
