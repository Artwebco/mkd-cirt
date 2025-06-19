<?php get_header(); ?>

<div class="container margin-top-bottom-80">
    <h1 class="category-title"><?php single_cat_title(); ?></h1>

    <div class="blog-grid">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="blog-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="blog-thumb">
                            <figure>
                                <a href="<?php the_permalink(); ?>">
                                    <?php
                                    $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium_large');
                                    if ($image) :
                                    ?>
                                        <img
                                            src="<?php echo esc_url($image[0]); ?>"
                                            width="<?php echo esc_attr($image[1]); ?>"
                                            height="<?php echo esc_attr($image[2]); ?>"
                                            alt="<?php the_title_attribute(); ?>" />
                                    <?php endif; ?>

                                </a>
                            </figure>
                        </div>
                    <?php endif; ?>

                    <div class="blog-meta">
                        <span class="post-date"><?php echo get_the_date(); ?></span>
                    </div>

                    <h2 class="blog-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="blog-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="read-more">Повеќе</a>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No posts found in this category.</p>
        <?php endif; ?>
    </div>

    <div class="pagination">
        <?php echo paginate_links(); ?>
    </div>
</div>

<?php get_footer(); ?>