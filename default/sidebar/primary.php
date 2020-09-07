<aside id="jankx-primary-sidebar" class="sidebar primary">
    <?php
    if (is_active_sidebar('primary')) {
        dynamic_sidebar('primary');
    } elseif(current_user_can('edit_theme_options')) {
        printf(
            __('Please add the widgets to this sidebar at <a href="%s">Widget Dashboard</a>', 'jankx'),
            admin_url('widgets.php')
        );
    }
    ?>
</aside>