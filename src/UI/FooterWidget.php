<?php
namespace Jankx\Template\UI;

use Jankx;

class FooterWidget
{
    public static function getFooterWigetColumns()
    {
        return apply_filters('jankx_footer_widget_columns', 4);
    }
    public static function getFooterWidgetPrefix()
    {
        return apply_filters('jankx_footer_widget_prefix', 'footer-');
    }

    public static function render()
    {
        $numOfFooterWidgets = self::getFooterWigetColumns();
        $footerWidgetPrefix = self::getFooterWidgetPrefix();

        do_action("jankx_before_footer_widget_area");

        for ($i = 1; $i <= $numOfFooterWidgets; $i++) {
            $sidebarId = sprintf('%s-%s', $footerWidgetPrefix, $i);

            do_action("jankx_before_sidebar_footer_widget", $sidebarId, $footerWidgetPrefix, $i);

            /**
             * Call footer sidebar
             */
            Jankx::sidebar($sidebarId);

            do_action("jankx_after_sidebar_footer_widget", $sidebarId, $footerWidgetPrefix, $i);
        }

        do_action("jankx_after_footer_widget_area");
    }

    public static function isActive()
    {
        $first_sidebar = sprintf('%s1', self::getFooterWidgetPrefix());
        return self::getFooterWigetColumns() > 0 && is_dynamic_sidebar($first_sidebar);
    }
}
