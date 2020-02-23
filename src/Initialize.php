<?php
namespace Jankx\Template;

use Jankx;
use Jankx\Template\UI\FooterWidget;

if (!class_exists(Initialize::class)) {
    class Initialize
    {
        public static function loadTemplateFunctions($jankx)
        {
            self::loadHelpers();

            /**
             * Customize the 404 template
             */
            add_filter('jankx_404_custom_content', array(__CLASS__, 'custom_404_page'));

            /**
             * Detect template include to ensure Jankx framework is loaded
             */
            add_filter('template_include', array(__CLASS__, 'supportNotJankxTemplate'), 88);

            $jankx->hasActiveFooterWidgets = function () {
                return FooterWidget::isActive();
            };

            $jankx->footerWidgets = function () {
                return FooterWidget::render();
            };
        }

        public static function loadHelpers()
        {
            require_once realpath(dirname(__FILE__) . '/../frontend-helpers.php');
        }

        public static function supportNotJankxTemplate($templateFile)
        {
            if (empty($templateFile)) {
                return $templateFile;
            }

            $relativePath = str_replace(WP_CONTENT_DIR, '', $templateFile);
            if (!preg_match('/^\/themes/', $relativePath)) {
                self::addJankxHookViaWordPressNativeFunctions();
                jankx_page($templateFile, true);
            } else {
                return $templateFile;
            }
        }

        public static function addJankxHookViaWordPressNativeFunctions()
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

        public static function custom_404_page()
        {
            ob_start();
            jankx_template(array('error/404', '404'));
            return ob_get_clean();
        }
    }
}
