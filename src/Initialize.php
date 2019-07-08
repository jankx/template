<?php
namespace Jankx\Template;

class Initialize
{
    public static function loadTemplateFunctions()
    {
        self::loadHelpers();
        add_filter('template_include', array(__CLASS__, 'supportNotJankxTemplate'));
    }

    public static function loadHelpers()
    {
        if (\Jankx::isRequest('frontend')) {
            require_once realpath(dirname(__FILE__) . '/../frontend-helpers.php');
        }
    }

    public static function supportNotJankxTemplate($templateFile)
    {
        $relativePath = str_replace(WP_CONTENT_DIR, '', $templateFile);
        if (!preg_match('/^\/themes/', $relativePath)) {
            jankx_page($templateFile, true);
        } else {
            return $templateFile;
        }
    }
}
