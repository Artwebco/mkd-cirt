<?php get_header(); ?>

<div class="container margin-top-bottom-80">
    <div class="project-single">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();

                //$kratok_opis = get_post_meta(get_the_ID(), 'kratok_opis', true);
                $kratok_opis = SCF::get('kratok_opis');
                $budzet = get_post_meta(get_the_ID(), 'budzet', true);
                $rakovoditel = get_post_meta(get_the_ID(), 'rakovoditel_na_proekt', true);
                $status = get_post_meta(get_the_ID(), 'status', true);
                $pocetok = get_post_meta(get_the_ID(), 'pocetok', true);
                $zavrsetok = get_post_meta(get_the_ID(), 'zavrsetok', true);
        ?>
                <h1><?php the_title(); ?></h1>

                <div class="project-content">
                    <?php if (!empty($kratok_opis)) : ?>
                        <div class="project-description">
                            <?php echo wp_kses_post($kratok_opis); ?>
                        </div>
                    <?php endif; ?>

                    <div class="project-info">
                        <div class="wrapper">
                            <?php if (!empty($rakovoditel)) : ?>
                                <div class="project-items">
                                    <div class="item-label">Проект менаџер</div>
                                    <div class="project-item"><?php echo esc_html($rakovoditel); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($budzet)) : ?>
                                <div class="project-items">
                                    <div class="item-label">Буџет</div>
                                    <div class="project-item"><?php echo esc_html(number_format((float)$budzet, 0, '', '.')) . ' ден'; ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($pocetok)) : ?>
                                <div class="project-items">
                                    <div class="item-label">Почеток</div>
                                    <div class="project-item"><?php echo esc_html($pocetok); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($zavrsetok)) : ?>
                                <div class="project-items">
                                    <div class="item-label">Крај</div>
                                    <div class="project-item"><?php echo esc_html($zavrsetok); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ($status !== '') : ?>
                                <div class="project-items">
                                    <div class="item-label">Статус</div>
                                    <div class="project-item">
                                        <?php
                                        if ($status == 1) {
                                            echo "<span class=\"active\">Активен</span>";
                                        } else {
                                            echo "<span class=\"inactive\">Неактивен</span>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Ensure SCF is available

                            // Retrieve repeater fields
                            $donatori = SCF::get('donatori');
                            $partneri = SCF::get('partneri');

                            // Display Donatori
                            // if (! empty($donatori) && is_array($donatori)) {
                            //     echo '<div class="project-items">';
                            //     echo '<div class="item-label">Донатори</div>';
                            //     echo '<ul class="project-item">';
                            //     foreach ($donatori as $row) {
                            //         if (! empty($row['donator'])) {
                            //             echo '<li>' . esc_html($row['donator']) . '</li>';
                            //         }
                            //     }
                            //     echo '</ul>';
                            //     echo '</div>';
                            // }

                            // Display Partneri
                            // if (! empty($partneri) && is_array($partneri)) {
                            //     echo '<div class="project-items">';
                            //     echo '<div class="item-label">Партнери</div>';
                            //     echo '<ul class="project-item">';
                            //     foreach ($partneri as $row) {
                            //         if (! empty($row['partner'])) {
                            //             echo '<li>' . esc_html($row['partner']) . '</li>';
                            //         }
                            //     }
                            //     echo '</ul>';
                            //     echo '</div>';
                            // }

                            $categories = get_the_terms(get_the_ID(), 'project-categories');
                            if (!empty($categories) && !is_wp_error($categories)) {
                                echo '<div class="project-items">';
                                echo '<div class="item-label">Категорија</div>';
                                echo '<ul class="project-item">';
                                foreach ($categories as $category) {
                                    echo '<li>' . esc_html($category->name) . '</li>';
                                }
                                echo '</ul>';
                                echo '</div>';
                            }

                            ?>
                        </div>
                    </div>
                </div>

                <div class="project-content">
                    <?php the_content(); ?>
                </div>

        <?php
            endwhile;
        else :
            echo '<p>Проектот не е најден.</p>';
        endif;
        ?>
    </div>
</div>

<?php get_footer(); ?>