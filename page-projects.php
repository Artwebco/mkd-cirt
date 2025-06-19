<?php
/* Template Name: Projects */
get_header(); ?>
<div class="container margin-top-bottom-80">
    <h1 class="page-title"><?php the_title(); ?></h1>
    <div class="page-description"><?php the_content(); ?></div>
    <div class="projects">
        <!-- Filters -->
        <div class="filters">
            <input type="text" id="search" placeholder="Пребарај...">

            <div id="status-filter">
                <span>Статус:</span>
                <select id="status-select">
                    <option value="">Сите</option>
                    <option value="1">Активни</option>
                    <option value="0">Завршени</option>
                </select>
            </div>

            <div id="category-filter">
                <span>Категорија:</span>
                <select id="category-select">
                    <option value="">Сите</option>
                    <?php
                    $terms = get_terms([
                        'taxonomy' => 'project-categories',
                        'hide_empty' => false,
                    ]);
                    if (!is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

        </div>

        <!-- Projects Cards (Initial Load with PHP) -->
        <div class="cards" id="projects-container">
            <?php
            $initial_query = new WP_Query([
                'post_type' => 'projects',
                'posts_per_page' => 10,
                'paged' => 1,
            ]);

            if ($initial_query->have_posts()) :
                while ($initial_query->have_posts()) : $initial_query->the_post();
                    $title = get_the_title();
                    $status_raw = SCF::get('status', get_the_ID());
                    $status = $status_raw == 1 ? 'Активен' : 'Завршен';
                    $donatori = SCF::get('donatori', get_the_ID());
                    $donor_names = [];

                    if (!empty($donatori)) {
                        foreach ($donatori as $d) {
                            if (!empty($d['donator'])) {
                                $donor_names[] = $d['donator'];
                            }
                        }
                    }

                    $terms = get_the_terms(get_the_ID(), 'project-categories');
                    $category_names = [];
                    if ($terms && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            $category_names[] = $term->name;
                        }
                    }
            ?>
                    <a href="<?php the_permalink(); ?>" class="card"
                        data-status="<?php echo esc_attr($status); ?>"
                        data-donors="<?php echo esc_attr(implode(',', $donor_names)); ?>">
                        <h2><?php echo esc_html($title); ?></h2>

                        <?php if (!empty($status)) :
                            $status_class = ($status === 'Активен') ? 'active' : 'inactive';
                        ?>
                            <div class="status <?php echo esc_attr($status_class); ?>">
                                <?php echo esc_html($status); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($category_names)) : ?>
                            <div class="project-categories">
                                <?php echo esc_html(implode(', ', $category_names)); ?>
                            </div>
                        <?php endif; ?>
                    </a>


            <?php endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="no-results">Нема проекти што одговараат на критериумите.</p>';
            endif;
            ?>
        </div>

    </div>
    <!-- Load More Button -->
    <div class="load-more-wrapper" style="text-align:center; margin-top:20px;">
        <button class="btn btn-red radius-40" id="load-more">Повеќе</button>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        let currentPage = 1;

        function fetchProjects(reset = false) {
            if (reset) currentPage = 1;

            const data = {
                action: 'filter_projects',
                status: $('#status-select').val() || '',
                category: $('#category-select').val() || '',
                search: $('#search').val() || '',
                paged: currentPage
            };

            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                method: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: function() {
                    if (reset) $('#projects-container').html('<div class="spinner"></div><p class="loading-text">Се вчитува...</p>');
                    else $('#load-more').html('<span class="loading-text">Се вчитува...</span><div class="spinner spinner-small"></div>');
                },
                success: function(res) {
                    if (res.success) {
                        if (reset) {
                            $('#projects-container').html(res.data.html);
                        } else {
                            $('#projects-container').append(res.data.html);
                        }
                        if (res.data.has_more) {
                            $('#load-more').show().text('Повеќе');
                        } else {
                            $('#load-more').hide();
                        }
                    } else {
                        $('#projects-container').html('<p>Нема резултати.</p>');
                        $('#load-more').hide();
                    }
                },

                error: function() {
                    $('#projects-container').html('<p>Грешка при вчитување на проекти.</p>');
                    $('#load-more').hide();
                }
            });
        }

        // Initial PHP-rendered load used, skip first fetchProjects()

        // Trigger AJAX filtering
        $('#search, #status-select, #category-select').on('input change', function() {

            fetchProjects(true);
        });

        $('#load-more').on('click', function() {
            currentPage++;
            fetchProjects(false);
        });
    });
</script>

<?php get_footer(); ?>