<?php
defined('ABSPATH') || exit('');
?>
    <div class="comments" id="comments">
        <div class="comments-header section-inner small max-percentage">

            <h2 class="comment-reply-title">
                <?php echo $comment_reply_title; ?>
            </h2><!-- .comments-title -->

        </div><!-- .comments-header -->

        <div class="comments-inner section-inner thin max-percentage">
            <?php
            wp_list_comments($list_comments_args);

            if ($comment_pagination):
                $pagination_classes = '';

                // If we're only showing the "Next" link, add a class indicating so.
                if (false === strpos($comment_pagination, 'prev page-numbers')) {
                    $pagination_classes = ' only-next';
                }
            ?>

                <nav class="comments-pagination pagination<?php echo $pagination_classes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>" aria-label="<?php esc_attr_e('Comments', 'twentytwenty'); ?>">
                    <?php echo wp_kses_post($comment_pagination); ?>
                </nav>
            <?php endif; ?>

        </div><!-- .comments-inner -->

    </div><!-- comments -->
<?php

if (comments_open() || pings_open()) {
    if ($comments) {
        echo '<hr class="styled-separator is-style-wide" aria-hidden="true" />';
    }

    comment_form(
        array(
            'class_form'         => 'section-inner thin max-percentage',
            'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
            'title_reply_after'  => '</h2>',
        )
    );
} elseif (is_single()) {
    if ($comments) {
        echo '<hr class="styled-separator is-style-wide" aria-hidden="true" />';
    }

    ?>

    <div class="comment-respond" id="respond">

        <p class="comments-closed"><?php _e('Comments are closed.', 'twentytwenty'); ?></p>

    </div><!-- #respond -->

    <?php
}
