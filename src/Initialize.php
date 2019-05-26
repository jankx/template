<?php
namespace Jankx\Template;

class Initialize
{
    public static function loadTemplateFunctions()
    {
        self::loadHelpers();
    }

    public static function loadHelpers()
    {
        if (\Jankx::isRequest('frontend')) {
            require_once realpath(dirname(__FILE__) . '/../frontend-helpers.php');
        }
    }
}
