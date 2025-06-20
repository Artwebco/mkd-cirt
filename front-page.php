<?php get_header(); ?>

<?php
// Render the hero section BEFORE the content and scripts
if (is_page(['konstituenti', 'studenti', 'gragjani', 'sorabotnici'])) {
    get_template_part('template-parts/hero');
}
?>

<?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>
        <article>
            <?php the_content(); ?>
        </article>
    <?php endwhile;
else: ?>
    <p>Не е пронајдена содржина.</p>
<?php endif; ?>

<?php get_footer(); ?>