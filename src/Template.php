<?php
namespace Jankx\Template;

use Jankx\TemplateEngine\EngineManager;

class Template
{
    protected static $instances = [];
    protected static $defautLoader;

    public static function getLoader($templateFileLoader = null, $directoryInTheme = '', $engineName = 'wordpress')
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

    public static function setDefautLoader($loader = null)
    {
        if (is_null($loader)) {
            static::$defautLoader = static::getDefaultLoader();
        } else {
            static::$defautLoader = $loader;
        }
    }

    public static function getDefaultLoader()
    {
        return apply_filters(
            'jankx_default_template_loader',
            defined('JANKX_THEME_DEFAULT_ENGINE') ? JANKX_THEME_DEFAULT_ENGINE : null
        );
    }
}
