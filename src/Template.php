<?php
namespace Jankx\Template;

use Jankx\Template\Engine\EngineManager;

class Template
{
    protected static $instances = [];
    protected static $templateLoaded;
    protected static $defautLoader;

    public static function getInstance($templateFileLoader = null, $themePrefix = '', $engineName = 'wordpress')
    {
        if (is_null($templateFileLoader) && self::$defautLoader) {
            $templateFileLoader = self::$defautLoader;
        }
        if (empty(self::$instances[$templateFileLoader])) {
            $loader = new Loader(
                $templateFileLoader,
                $themePrefix
            );
            $applyTemplateEngine = apply_filters(
                'jankx_template_engine',
                $engineName,
                $templateFileLoader,
                $themePrefix,
                $loader
            );
            $engine = EngineManager::createEngine(
                $templateFileLoader,
                $applyTemplateEngine,
                array(
                    'template_location' => $templateFileLoader,
                )
            );
            $loader->setTemplateEngine($engine);

            self::$instances[$templateFileLoader] = $loader;
        }
        return self::$instances[$templateFileLoader];
    }

    public function load()
    {
        if (!self::$templateLoaded) {
            $this->loadTemplateHelpers();
            /**
             * Create a flag to check Jankx template library is loaded
             */
            self::$templateLoaded = true;
        }

        if (defined('JANKX_THEME_DEFAULT_ENGINE')) {
            self::$defautLoader = apply_filters(
                'jankx_default_template_loader',
                JANKX_THEME_DEFAULT_ENGINE
            );
        }
    }

    public function loadTemplateHelpers()
    {
        $helpersDir = realpath(dirname(__FILE__) . '/../helpers');

        /**
         * Load Jankx template helpers
         */
        require_once $helpersDir . '/template.php';
    }
}
