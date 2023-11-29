<?php
/**
 * Page
 */
get_header(); ?>

<?php if (have_rows('flexible')) : ?>
    <?php while (have_rows('flexible')) :
        the_row();
        $layout = get_row_layout(); ?>
        <?php get_template_part('parts/flexible/flexible', $layout);
        ?>
    <?php endwhile; ?>
<?php endif;?>

<?php get_footer(); ?>
