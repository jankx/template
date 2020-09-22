<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <link rel="profile" href="https://gmpg.org/xfn/11">
        <title><?php wp_title(); ?></title>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>

        <?php do_action('jankx_template_before_header'); ?>
        <header id="jankx-site-header" class="jankx-site-header">
            <?php do_action('jankx_template_before_header_content'); ?>

            <?php jankx_open_container(); ?>

                <?php jankx_component(
                    'header',
                    apply_filters('jankx_component_header_props', array(
                        'preset' => 'default'
                    )),
                    apply_filters('jankx_component_header_options', array(
                        'echo' => true,
                    ))
                ); ?>

            <?php jankx_close_container(); ?>

            <?php do_action('jankx_template_after_header_content'); ?>
        </header>
        <?php do_action('jankx_template_after_header'); ?>
