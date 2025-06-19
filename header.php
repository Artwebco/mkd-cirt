<!DOCTYPE html>

<html <?php language_attributes(); ?>>



<head>

    <meta charset="<?php bloginfo('charset'); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: "Inter", "Helvetica", sans-serif;
        }
    </style>

    <?php wp_head(); ?>

</head>



<body <?php body_class(); ?>>

    <div class="mobile-top-header only-mobile">
        <div class="container top-header-container">
            <div class="top-left language">
                <?php echo do_shortcode('[gtranslate]'); ?>
            </div>
            <div class="top-right incident-button">
                <a href="/onlajn-prijava" class="button">Пријави инцидент</a>
            </div>
        </div>
    </div>
    <header class="site-header <?php echo is_page(['konstituenti', 'studenti', 'gragjani', 'sorabotnici']) ? 'top_panel' : ''; ?>">
        <div class="container header-container">

            <!-- Logo -->

            <div class="logo">

                <a href="<?php echo home_url(); ?>" aria-label="Homepage of <?php bloginfo('name'); ?>">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg"
                            alt="<?php bloginfo('name'); ?> logo"
                            width="160" height="125">
                    <?php endif; ?>
                </a>


            </div>

            <div class="nav-bar">

                <!-- Main Navigation Menu -->

                <nav class="main-menu">

                    <?php

                    wp_nav_menu([

                        'theme_location' => 'primary',

                        'menu_class'     => 'main-navigation',

                        'container'      => false

                    ]);

                    ?>

                </nav>

                <div class="language"><?php echo do_shortcode('[gtranslate]'); ?></div>

                <div class="incident-button">

                    <a href="/onlajn-prijava" class="button">Пријави инцидент</a>

                </div>

                <button id="search-toggle" aria-label="Search" class="search-button">

                    <i class="fas fa-search"></i> <!-- Use an icon font or SVG -->

                </button>

            </div>

        </div>

        <button class="hamburger" id="menu-toggle" aria-label="Toggle Menu">

            <span></span>

            <span></span>

            <span></span>

        </button>

    </header>



    <?php wp_footer(); ?>

</body>



</html>