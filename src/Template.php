<?php
namespace Jankx\Template;

class Template
{
    protected static $instances = [];

    public static function getInstance($templateFileLoader = null, $themePrefix = '')
    {
        if (empty(self::$instances[$templateFileLoader])) {
            self::$instances[$templateFileLoader] = new Loader($templateFileLoader, $themePrefix);
        }
        return self::$instances[$templateFileLoader];
    }

    public static function getTemplateEngine()
    {
    }

    public function load()
    {
    }
}
