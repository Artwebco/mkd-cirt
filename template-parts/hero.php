<section class="hero-section">

    <div class="video-background">
        <video class="video-background-video" width="1920" height="1080" autoplay muted loop playsinline
            aria-hidden="true">
            <source src="/wp-content/themes/mkd-cirt/assets/video/header-video.mp4" type="video/mp4">
        </video>
    </div>

    <div class="container">
        <div class="box1-wrapper">
            <div class="box1">

                <?php
                // THEN render full hero section
                $hero_query = new WP_Query([
                    'post_type' => 'hero-section',
                    'posts_per_page' => 1,
                ]);

                if ($hero_query->have_posts()):
                    while ($hero_query->have_posts()):
                        $hero_query->the_post();

                        $title = get_post_meta(get_the_ID(), 'title', true);
                        $title2 = get_post_meta(get_the_ID(), 'title_2', true);
                        $description = get_post_meta(get_the_ID(), 'description', true);
                        $button_label = SCF::get('button_label');
                        $button_url = SCF::get('button_url');
                        $subitem_title = get_post_meta(get_the_ID(), 'title_3', true);
                        $subitem_button_title = get_post_meta(get_the_ID(), 'subitem_button_title', true);
                        $subitem_file_id = get_post_meta(get_the_ID(), 'subitem_file', true);
                        $subitem_file_url = wp_get_attachment_url($subitem_file_id);
                        ?>

                        <div class="hero">




                            <?php if (!empty($button_label) && !empty($button_url)): ?>
                                <a href="<?php echo esc_url($button_url); ?>"
                                    class="btn btn-white radius-40"><?php echo esc_html($button_label); ?></a>
                            <?php endif; ?>

                            <div class="sub-item">
                                <div class="wrapper">


                                    <?php if (!empty($subitem_button_title) && !empty($subitem_file_url)): ?>
                                        <a href="<?php echo esc_url($subitem_file_url); ?>" class="btn btn-blue radius-20"
                                            target="_blank" rel="noopener">
                                            <?php echo esc_html($subitem_button_title); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>

                <?php
                wp_nav_menu([
                    'menu' => 'Second Menu',
                    'container' => 'nav',
                    'container_class' => 'second-menu wp-block-navigation is-layout-flex wp-block-navigation-is-layout-flex',
                    'menu_class' => 'wp-block-navigation__container second-menu wp-block-navigation',
                    'link_before' => '<span class="wp-block-navigation-item__label">',
                    'link_after' => '</span>',
                    'fallback_cb' => false,
                ]);
                ?>

            </div>
        </div>
    </div>
</section>