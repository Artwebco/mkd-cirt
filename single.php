<?php get_header(); ?>

<main class="container margin-top-bottom-80">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <p class="post-date">Објавено: <?php echo get_the_date(); ?></p>
                <div class="content">
                    <?php the_content(); ?>
                </div>
            </article>
    <?php endwhile;
    endif;
    ?>
</main>

<?php get_footer(); ?>