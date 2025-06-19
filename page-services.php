<?php
/* Template Name: Services */
get_header();
?>

<div class="container margin-top-bottom-80">
    <h1 class="page-title"><?php the_title(); ?></h1>

    <div class="services-filter">
        <button class="filter-btn active" data-filter="all">Сите</button>
        <button class="filter-btn" data-filter="gragjani">Граѓани</button>
        <button class="filter-btn" data-filter="konstituenti">Конституенти</button>
        <button class="filter-btn" data-filter="sorabotnici">Соработници</button>
        <button class="filter-btn" data-filter="studenti">Студенти</button>
    </div>

    <div class="services-grid-page">
        <?php
        $services = new WP_Query([
            'post_type' => 'service',
            'posts_per_page' => -1,
        ]);

        if ($services->have_posts()):
            while ($services->have_posts()): $services->the_post();
                $terms        = get_the_terms(get_the_ID(), 'service_tag');
                $term_slugs   = [];
                $website      = SCF::get('website', get_the_ID());
                $website_url  = SCF::get('website_url', get_the_ID());

                if ($terms && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        if (is_object($term)) {
                            $term_slugs[] = $term->slug;
                        }
                    }
                }

                $term_classes = implode(' ', $term_slugs);
                $is_external = ($website_url && strpos(parse_url($website_url, PHP_URL_HOST), $_SERVER['HTTP_HOST']) === false);
        ?>

                <?php if ($website_url): ?>
                    <a href="<?php echo esc_url($website_url); ?>"
                        <?php echo $is_external ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
                        class="service-card <?php echo esc_attr($term_classes); ?>">
                    <?php else: ?>
                        <div class="service-card <?php echo esc_attr($term_classes); ?>">
                        <?php endif; ?>
                        <div class="content-item">
                            <h3><?php the_title(); ?></h3>

                            <?php if ($website): ?>
                                <div class="website">
                                    <?php echo esc_html($website); ?>
                                </div>
                            <?php endif; ?>

                            <p><?php the_excerpt(); ?></p>
                        </div>
                        <?php if ($terms): ?>
                            <div class="service-domain">
                                <?php foreach ($terms as $term): ?>
                                    <?php if (is_object($term)): ?>
                                        <span class="badge"><?php echo esc_html($term->name); ?></span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($website_url): ?>
                    </a>
                <?php else: ?>
    </div>
<?php endif; ?>

<?php
            endwhile;
            wp_reset_postdata();
        endif;
?>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const serviceCards = document.querySelectorAll('.service-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                const filter = button.getAttribute('data-filter');

                serviceCards.forEach(card => {
                    if (filter === 'all') {
                        card.style.display = 'block';
                    } else {
                        card.style.display = card.classList.contains(filter) ? 'block' : 'none';
                    }
                });
            });
        });
    });
</script>

<?php get_footer(); ?>