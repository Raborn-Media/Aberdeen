<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>

<!--HOME PAGE SLIDER-->
<?php if (shortcode_exists('slider')) {
    echo do_shortcode('[slider]');
} ?>
<!--END of HOME PAGE SLIDER-->

<!-- BEGIN of main content -->
<?php if (have_rows('flexible')) : ?>
    <?php while (have_rows('flexible')) :
        the_row();
        $layout = get_row_layout(); ?>
        <?php get_template_part('parts/flexible/flexible', $layout);
        ?>
    <?php endwhile; ?>
<?php endif;?>
<!-- END of main content -->

<?php get_footer(); ?>
