<?php
namespace Jankx\Template;

use Jankx\Template\Engine\EngineManager;

class Template
{
    protected static $instances = [];
    protected static $templateLoaded;

    public static function getInstance($templateFileLoader = null, $themePrefix = '', $engineName = 'wordpress')
    {
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
        if (self::$templateLoaded) {
            return;
        }
        $this->loadTemplateHelpers();

        /**
         * Create a flag to check Jankx template library is loaded
         */
        self::$templateLoaded = true;
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
