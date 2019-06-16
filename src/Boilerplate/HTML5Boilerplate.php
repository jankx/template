<?php
namespace Jankx\Template\Boilerplate;

use Jankx\Template\Abstracts\Boilerplate;

class HTML5Boilerplate extends Boilerplate
{
    public function doctype()
    {
        echo '<!doctype html>';
    }

    public function head()
    {
        ?>
        <html class="no-js" <?php language_attributes(); ?>>
            <head>
                <title><?php wp_title(); ?></title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <?php wp_head(); ?>
            </head>
            <body <?php body_class(); ?>>
            <!--[if IE]>
                <p class="browserupgrade">
                    You are using an <strong>outdated</strong> browser.
                    Please <a href="https://browsehappy.com/">upgrade your browser</a
                    to improve your experience and security.
                </p>
            <![endif]-->
        <?php
    }

    public function footer()
    {
        wp_footer();
        ?>
        </body>
        </html>
        <?php
    }
}
