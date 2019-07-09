<?php
namespace Jankx\Template;

class Initialize
{
    public static function loadTemplateFunctions()
    {
        self::loadHelpers();

        /**
         * Detect template include to ensure Jankx framework is loaded
         */
        add_filter('template_include', array(__CLASS__, 'supportNotJankxTemplate'), 35);
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
            self::addJankxHookViaWordPressNative();
            jankx_page($templateFile, true);
        } else {
            return $templateFile;
        }
    }


    public function addJankxHookViaWordPressNative()
    {
        add_action('get_header', function () {
            do_action('jankx_before_get_header');
        }, 5);
        add_action('jankx_template_header', function () {
            do_action('jankx_after_get_header');
        }, 15);

        add_action('jankx_template_header', function () {
            do_action('jankx_before_main_content');
        }, 35);
        add_action('get_footer', function () {
            do_action('jankx_after_main_content');
        }, 5);

        add_action('get_footer', function () {
            do_action('jankx_before_get_footer');
        }, 35);
        add_action('jankx_template_footer', function () {
            do_action('jankx_after_get_footer');
        });
    }
}
