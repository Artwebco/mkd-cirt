<?php get_header(); ?>

<main class="search-results container margin-top-bottom-80">
    <h1 class="search-title">Резултати од пребарувањето за: "<?php echo get_search_query(); ?>"</h1>

    <?php
    // Set custom posts per page
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = [
        's' => get_search_query(),
        'posts_per_page' => 20,
        'paged' => $paged
    ];
    $search_query = new WP_Query($args);
    ?>

    <?php if ($search_query->have_posts()) : ?>
        <div class="results-grid">
            <?php while ($search_query->have_posts()) : $search_query->the_post(); ?>
                <article class="search-item">
                    <a href="<?php the_permalink(); ?>">
                        <h2 class="title"><?php the_title(); ?></h2>
                        <p class="excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="pagination">
            <?php
            echo paginate_links([
                'total' => $search_query->max_num_pages,
                'current' => $paged
            ]);
            ?>
        </div>

        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p class="no-results">No results found. Try another search.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>