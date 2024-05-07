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
            $engine->setupEnvironment();

            do_action_ref_array("jankx/template/engine/{$engine->getName()}/init", array(
                &$engine
            ));

            static::$engines[$id] = &$engine;

            return $engine;
        }
    }

    public static function getEngine($id)
    {
        if (isset(static::$engines[$id])) {
            return static::$engines[$id];
        }
    }
}
