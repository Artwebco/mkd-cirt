<?php
function cirt_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

    // Register custom logo support explicitly
    add_theme_support('custom-logo');

    // 🔥 Register navigation menu
    register_nav_menus([
        'primary' => __('Primary Menu', 'mkd-cirt'),
    ]);
}
add_action('after_setup_theme', 'cirt_theme_setup');

function cirt_enqueue_scripts()
{

    // CSS
    wp_enqueue_style('cirt-main-style', get_template_directory_uri() . '/assets/scss/main.css', [], '1.3');

    // JS
    wp_enqueue_script('cirt-main-script', get_template_directory_uri() . '/assets/js/script.js', [], '1.3', true);
}
add_action('wp_enqueue_scripts', 'cirt_enqueue_scripts');

// Allow SVG file uploads in WordPress
function allow_svg_uploads($mimes)
{
    $mimes['svg'] = 'image/svg+xml'; // Add SVG MIME type
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

function cirt_widgets_init()
{
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar([
            'name' => "Footer Widget $i",
            'id' => "footer-$i",
            'before_widget' => '<div class="footer-widget">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ]);
    }
}
add_action('widgets_init', 'cirt_widgets_init');

function enqueue_font_awesome_pro()
{
    $font_awesome_css = get_template_directory_uri() . '/assets/fonts/fontawesome/css/all.min.css';

    // Enqueue as usual
    wp_enqueue_style('font-awesome-pro', $font_awesome_css, [], '6.5.1');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome_pro');

add_filter('style_loader_tag', function ($html, $handle) {
    if ('font-awesome-pro' === $handle) {
        // Use regex to replace the <link ... > tag and add media="print" and onload
        $html = preg_replace(
            '#<link([^>]+)>#',
            '<link$1 media="print" onload="this.media=\'all\'">',
            $html
        );
    }
    return $html;
}, 10, 2);

add_filter('gform_submit_button', 'add_custom_css_classes', 10, 2);
function add_custom_css_classes($button, $form)
{
    // Check if the form ID is 3
    if ($form['id'] == 3) {
        $fragment = WP_HTML_Processor::create_fragment($button);
        $fragment->next_token();
        $fragment->add_class('btn btn-red radius-40 left');
        return $fragment->get_updated_html();
    }
    // For other forms, return the button unchanged
    return $button;
}

function change_cpt_title_placeholder($title)
{
    $screen = get_current_screen();

    if ('projects' === $screen->post_type) {
        $title = 'Назив на проектот';
    }

    return $title;
}
add_filter('enter_title_here', 'change_cpt_title_placeholder');


//Projects page ajax
function filter_projects_callback()
{
    $paged = isset($_POST['paged']) ? (int) $_POST['paged'] : 1;
    $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';

    $meta_query = [];
    if ($status !== '') {
        $meta_query[] = [
            'key' => 'status',
            'value' => $status,
            'compare' => '=',
        ];
    }

    $tax_query = [];
    if (!empty($category)) {
        $tax_query[] = [
            'taxonomy' => 'project-categories',
            'field' => 'slug',
            'terms' => $category,
        ];
    }

    $args = [
        'post_type' => 'projects',
        'posts_per_page' => 10,
        'paged' => $paged,
        's' => $search,
        'meta_query' => $meta_query,
        'tax_query' => $tax_query,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'ignore_sticky_posts' => true,
        'fields' => '',
    ];

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $title = get_the_title();
            $status_raw = SCF::get('status', get_the_ID());
            $status_label = $status_raw == 1 ? 'Активен' : 'Завршен';

            $donatori = SCF::get('donatori', get_the_ID());
            $donor_names = [];

            if (!empty($donatori)) {
                foreach ($donatori as $d) {
                    if (!empty($d['donator'])) {
                        $donor_names[] = $d['donator'];
                    }
                }
            }

            ?>
            <a href="<?php the_permalink(); ?>" class="card" data-status="<?php echo esc_attr($status_label); ?>"
                data-donors="<?php echo esc_attr(implode(',', $donor_names)); ?>">
                <h2><?php echo esc_html($title); ?></h2>

                <?php if (!empty($status_label)):
                    $status_class = ($status_label === 'Активен') ? 'active' : 'inactive'; ?>
                    <div class="status <?php echo esc_attr($status_class); ?>">
                        <?php echo esc_html($status_label); ?>
                    </div>
                <?php endif; ?>

                <?php
                $categories = get_the_terms(get_the_ID(), 'project-categories');
                if (!empty($categories) && !is_wp_error($categories)):
                    $cat_names = wp_list_pluck($categories, 'name');
                    ?>
                    <div class="project-categories">
                        <?php echo esc_html(implode(', ', $cat_names)); ?>
                    </div>
                <?php endif; ?>
            </a>

            <?php
        }
    } else {
        echo '<p class="no-results">Нема проекти што одговараат на критериумите.</p>';
    }

    $html = ob_get_clean();

    wp_send_json_success([
        'html' => $html,
        'has_more' => ($paged < $query->max_num_pages),
    ]);
    wp_die();
}

add_action('wp_ajax_filter_projects', 'filter_projects_callback');
add_action('wp_ajax_nopriv_filter_projects', 'filter_projects_callback');


function mytheme_widgets_init()
{

    register_sidebar(array(
        'name' => __('Footer Menu'),
        'id' => 'footer-menu',
        'before_widget' => '<div class="footer-menu-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'mytheme_widgets_init');

//Logo dimesions
add_filter('get_custom_logo', function ($html) {
    // Check if the logo is an image tag
    if (strpos($html, '<img') === false) {
        return $html;
    }

    // Load the image src
    preg_match('/src=["\']([^"\']+)/', $html, $srcMatch);
    if (!isset($srcMatch[1])) {
        return $html;
    }

    $src = $srcMatch[1];
    $path = str_replace(home_url('/'), ABSPATH, $src);

    // Default fallback values
    $width = 160;
    $height = 125;

    // Try to read SVG dimensions if file exists
    if (file_exists($path) && strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'svg' && function_exists('simplexml_load_file')) {
        $svg = simplexml_load_file($path);
        if ($svg !== false && isset($svg['width']) && isset($svg['height'])) {
            $width = (int) $svg['width'];
            $height = (int) $svg['height'];
        }
    }

    // Inject width and height if not already present
    if (strpos($html, 'width=') === false && strpos($html, 'height=') === false) {
        $html = preg_replace(
            '/<img\s/',
            '<img width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" ',
            $html,
            1
        );
    }

    return $html;
});

function mark_menu_item_active_for_category($classes, $item)
{
    if (is_single()) {
        // Get current post categories
        $categories = get_the_category();
        foreach ($categories as $cat) {
            // If menu item URL matches category link
            if ($cat && $item->url === get_category_link($cat->term_id)) {
                $classes[] = 'current-menu-item';
                break;
            }
        }
    }

    return $classes;
}
add_filter('nav_menu_css_class', 'mark_menu_item_active_for_category', 10, 2);


add_filter('gform_confirmation', 'my_custom_confirmation', 10, 4);
function my_custom_confirmation($confirmation, $form, $entry, $ajax)
{
    $confirmation .= "<script> jQuery('.gform_wrapper').find('form')[0].reset(); </script>";
    return $confirmation;
}


add_action('wp_ajax_reload_gf_form', 'reload_gf_form_callback');
add_action('wp_ajax_nopriv_reload_gf_form', 'reload_gf_form_callback');

function reload_gf_form_callback()
{
    $form_id = isset($_POST['form_id']) ? intval($_POST['form_id']) : 0;
    if (!$form_id) {
        wp_send_json_error('Invalid form ID');
    }

    // Capture the form HTML output
    ob_start();
    gravity_form($form_id, false, false, false, '', false);
    $form_html = ob_get_clean();

    wp_send_json_success(['form_html' => $form_html]);
}


//Adds html width and height to the default image gutemberg block
add_filter('render_block', 'cirt_add_svg_dimensions_to_gutenberg_images', 10, 2);
function cirt_add_svg_dimensions_to_gutenberg_images($block_content, $block)
{
    if ($block['blockName'] === 'core/image' && isset($block['attrs']['id'])) {
        $attachment_id = $block['attrs']['id'];
        $mime_type = get_post_mime_type($attachment_id);

        if ($mime_type === 'image/svg+xml') {
            $file_path = get_attached_file($attachment_id);
            if (file_exists($file_path)) {
                $svg_content = file_get_contents($file_path);
                // Extract width and height from SVG tag
                preg_match('/<svg[^>]*width=["\']?([\d\.]+)(px)?["\']?[^>]*height=["\']?([\d\.]+)(px)?["\']?/', $svg_content, $matches);

                if (!empty($matches)) {
                    $width = $matches[1];
                    $height = $matches[3];
                } else {
                    // Fallback: try to get dimensions from viewBox (viewBox="0 0 width height")
                    preg_match('/<svg[^>]*viewBox=["\']?0 0 ([\d\.]+) ([\d\.]+)["\']?/', $svg_content, $viewbox_matches);
                    if (!empty($viewbox_matches)) {
                        $width = $viewbox_matches[1];
                        $height = $viewbox_matches[2];
                    } else {
                        // Final fallback to some default
                        $width = 100;
                        $height = 100;
                    }
                }

                // Add width and height attributes if not present
                if (strpos($block_content, 'width=') === false && strpos($block_content, 'height=') === false) {
                    $block_content = preg_replace(
                        '/<img(.*?)\/?>/',
                        '<img$1 width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" />',
                        $block_content
                    );
                }
            }
        }
    }

    return $block_content;
}


add_action('wp_head', function () {
    $theme_path = get_template_directory(); // Server path
    $theme_uri = get_template_directory_uri(); // URL path
    $font_dir = $theme_path . '/assets/fonts/inter/';

    if (is_dir($font_dir)) {
        $fonts = glob($font_dir . '*.woff2');
        if ($fonts) {
            foreach ($fonts as $font_path) {
                // Get filename only
                $font_file = basename($font_path);
                // Output preload tag
                echo '<link rel="preload" href="' . esc_url($theme_uri . '/assets/fonts/inter/' . $font_file) . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
            }
        }
    }
});


add_action('wp_head', function () {
    if (wp_is_mobile()) {
        echo '<link rel="preload" as="image" href="' . get_template_directory_uri() . '/assets/images/mobile-background.webp" type="image/webp" fetchpriority="high">';
    }
});


add_action('init', 'download_cymru_report');

function download_cymru_report()
{
    if (!is_admin() && isset($_GET['download_cymru'])) {

        $file_url = 'https://www.cymru.com/mkd/report_info.txt';
        $username = 'mkd';
        $password = 'p1hO3g1qJ1JCisI';

        $headers = array(
            'Authorization' => 'Basic ' . base64_encode("$username:$password"),
        );

        $response = wp_remote_get($file_url, array(
            'headers' => $headers,
            'timeout' => 15,
        ));

        if (is_wp_error($response)) {
            echo 'Error: ' . $response->get_error_message();
        } else {
            echo '<pre>';
            echo "Status: " . wp_remote_retrieve_response_code($response) . "\n";
            echo htmlentities(wp_remote_retrieve_body($response));
            echo '</pre>';
        }

        exit;
    }
}

add_shortcode('hero_section', 'render_hero_section');
function render_hero_section()
{
    // Only show on specific pages by slug or ID
    if (is_page(['konstituenti', 'studenti', 'gragjani', 'sorabotnici'])) {
        ob_start();
        get_template_part('template-parts/hero');
        return ob_get_clean();
    }
    return ''; // Don't render on other pages
}

add_filter('gform_submit_button', 'add_custom_css_classes', 10, 2);