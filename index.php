<?php get_header(); ?>

<main id="site-main">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article>
                <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                <div><?php the_excerpt(); ?></div>
            </article>
    <?php endwhile;

        // Optional: Pagination
        the_posts_navigation();

    else :
        echo '<p>No content found.</p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>