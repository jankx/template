<div class="jankx-posts left-post right-list">
    <?php
        jankx_template('common/header-text', array(
            'text' => $header_text,
        ));
    ?>
    <div class="posts-list-wrapper">
            <div class="jankx-inner">
                <?php
                // Create first post
                $wp_query->the_post();
                $data = array(
                    'post' => $wp_query->post,
                );
                jankx_template('post/loop/large-image', $data);


                // Create post list
                jankx_post_loop_start();

                while($wp_query->have_posts()) {
                    $wp_query->the_post();
                    jankx_template('post/loop/list-item', $data);
                }

                jankx_post_loop_end();
                wp_reset_postdata();
                ?>
            </div>
    </div>
</div>
