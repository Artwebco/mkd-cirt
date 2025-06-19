<footer>
    <div class="container">
        <div class="footer-widgets">
            <?php for ($i = 1; $i <= 4; $i++) : ?>
                <?php if (is_active_sidebar("footer-$i")) : ?>
                    <div class="footer-widget-area">
                        <?php dynamic_sidebar("footer-$i"); ?>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?>, <?php bloginfo('name'); ?></p>
            <?php if (is_active_sidebar('footer-menu')) : ?>
                <div class="footer-menu horizontal">
                    <?php dynamic_sidebar('footer-menu'); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php wp_footer(); ?>
</footer>
<div id="search-modal" class="search-modal hidden">
    <div class="search-modal-content">
        <button id="close-search" class="close-button" aria-label="Close Search">&times;</button>
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <label>
                <span class="screen-reader-text">Search for:</span>
                <input type="search" class="search-field" placeholder="Внесете клучен збор…" value="<?php echo get_search_query(); ?>" name="s" />
            </label>
            <button type="submit" class="search-submit">Пребарај</button>
        </form>
    </div>
</div>
</body>

</html>