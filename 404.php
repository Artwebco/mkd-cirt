<?php get_header(); ?>



<div style="text-align: center; padding: 80px 20px;">
    <h1 style="font-size: 48px; margin-bottom: 20px;">404 - Страната не е пронајдена</h1>
    <p style="font-size: 18px; margin-bottom: 30px;">
        Извинете, но страницата што ја барате не постои или е преместена.
    </p>
    <a href="<?php echo esc_url(home_url('/')); ?>"
        style="display: inline-block; padding: 12px 30px; background-color: #9D1236; color: #fff; text-decoration: none; border-radius: 20px;">
        Врати се на почетната страница
    </a>
</div>

<?php get_footer(); ?>