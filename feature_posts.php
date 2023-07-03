<div class="feature-posts" id="feature-posts">
    <?php
    $args = array(
        'tag' => '2023-dev-feature',
        // Specify the tag slug here
        'post_type' => 'post',
        'posts_per_page' => -1, // Retrieve all posts
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <a class="feature-post" href="<?php the_permalink(); ?>">
                <div class="feature-post__img">
                    <?php
                    if (has_post_thumbnail()) {
                        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        echo '<img src="' . esc_url($image_url) . '" alt="' . get_the_title() . '">';
                    }
                    ?>
                </div>
                <div class="feature-post__title">
                    <h2>
                        <?php the_title(); ?>
                    </h2>
                </div>
            </a>
            <?php
        }
    }

    // Reset the post data
    wp_reset_postdata();
    ?>
</div>