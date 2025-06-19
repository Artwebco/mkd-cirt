<?php get_header(); ?>
<main>
  <?php if (!is_page(array('studenti', 'gragjani', 'sorabotnici'))) : ?>
    <div class="container margin-top-bottom-80">
    <?php endif; ?>

    <?php while (have_posts()) : the_post(); ?>
      <?php if (!is_page(array('studenti', 'gragjani', 'sorabotnici'))) : ?>
        <h1 class="page-title"><?php the_title(); ?></h1>
      <?php endif; ?>
      <?php the_content(); ?>
    <?php endwhile; ?>

    <?php if (!is_page(array('studenti', 'gragjani', 'sorabotnici'))) : ?>
    </div>
  <?php endif; ?>
</main>
<?php get_footer(); ?>