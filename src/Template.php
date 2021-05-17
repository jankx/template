<?php
namespace Jankx\Template;

use Jankx\TemplateEngine\EngineManager;
use Jankx\TemplateEngine\Engine;
use Jankx\TemplateEngine\Engines\Plates;

class Template
{
    protected static $engines = array();

    public static function createEngine($id, $templateDirectory, $defaultDirectory, $engineName = null)
    {
        if (!isset(static::$engines[$id])) {
            $engine = Engine::create($id, $engineName);
            if (is_null($engine)) {
                return;
            }

            $engine->setDefaultTemplateDir($defaultDirectory);
            $engine->setDirectoryInTheme($templateDirectory);

            add_action('init', array($engine, 'setupEnvironment'), 20);
            do_action_ref_array("jankx_template_engine_{$engine->getName()}_init", array(
                &$engine
            ));

            static::$engines[$id] = &$engine;
        }
    }

    public static function getEngine($id)
    {
        if (isset(static::$engines[$id])) {
            return static::$engines[$id];
        }
    }
}
