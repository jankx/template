<header <?php echo $attributes; ?>>
    <?php do_action('jankx_template_before_header_content'); ?>
    <?php jankx_open_container(); ?>

        <?php do_action('jankx_component_before_header'); ?>
        <?php echo $content; ?>
        <?php do_action('jankx_component_after_header'); ?>

    <?php jankx_close_container(); ?>
    <?php do_action('jankx_template_after_header_content'); ?>
</header>
