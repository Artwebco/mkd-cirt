<?php get_header(); ?>

<?php
echo do_shortcode('[hero_section]');
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article>
            <?php the_content(); ?>
        </article>
    <?php endwhile;
else : ?>
    <p>Не е пронајдена содржина.</p>
<?php endif; ?>

<?php get_footer(); ?>