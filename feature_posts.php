<!-- To show the code on all pages, remove the conditional statement if (is_home()) { ... }. This will cause the code to be displayed on all pages. However, if you want to include the code in a specific template or section of your theme, you can simply place it there without any conditional statement. -->
<?php if (is_home()): ?>
    <div class="feature-posts" id="feature-posts">
        <?php
        $args = array(
            'tag' => 'main-feature',
            // Specify the tag slug here
            'post_type' => 'post',
            'posts_per_page' => -1,
            // Retrieve all posts
            'no_found_rows' => true,
            // Optimize query performance
            'update_post_term_cache' => false,
            // Optimize query performance
            'update_post_meta_cache' => false, // Optimize query performance
        );

        $query = new WP_Query($args);

        if ($query->have_posts()):
            while ($query->have_posts()):
                $query->the_post();
                ?>
                <a class="feature-post" href="<?php the_permalink(); ?>">
                    <div class="feature-post__img">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('full', array('alt' => get_the_title())); ?>
                        <?php endif; ?>
                    </div>
                    <div class="feature-post__title">
                        <h2>
                            <?php the_title(); ?>
                        </h2>
                    </div>
                </a>
                <?php
            endwhile;
            wp_reset_postdata(); // Reset the post data
        endif;
        ?>
    </div>
<?php endif; ?>