<?php
/**
 * Home
 *
 * Standard loop for the blog-page
 */
get_header(); ?>

<!-- for debugging -->
<?php
function debug_to_console($data) {
    $post_type = $data;
    if (is_array($post_type))
    $post_type = implode(',', $post_type);
    echo "<script>console.log('get_post_type: " . $post_type . "');</script>";
}
?>
<main class="main-content">
    <div class="grid-container">
        <div class="grid-x grid-margin-x posts-list">
            <div class="grid-x">
                <div class="cell">
                    <div class="custom-breadcrumbs">
                        <a href="<?php echo get_home_url(); ?>" class="home-url">Home</a>
                        <span>&nbsp;&gt;&nbsp;</span>
                        <span>Blog</span>
                    </div>
                    <article class="text-center page-content">
                        <?php the_content(); ?>
                    </article>
                </div>
            </div>

            <!-- BEGIN of Blog posts -->
            <div class="large-8 medium-8 small-12 cell">
                <?php if (have_posts()) : ?>
                    <!-- for debugging -->
                    <?php while (have_posts()) :
                            the_post(); ?>
                            <?php debug_to_console(get_post_type()); ?>
                            <?php if (get_post_type() == 'blog-post') : ?>
                                <?php get_template_part('parts/loop', 'blog-posts'); // Post item?>
                            <?php endif; ?>
                        <?php endwhile; ?>
                <?php endif; ?>
                <!-- BEGIN of pagination -->
                <?php foundation_pagination(); ?>
                <!-- END of pagination -->
            </div>
            <!-- END of Blog posts -->

            <!-- BEGIN of sidebar -->
            <!-- <div class="large-4 medium-4 small-12 cell sidebar">
                <?php get_sidebar('right'); ?>
            </div> -->
            <!-- END of sidebar -->
        </div>
    </div>
</main>

<?php get_footer(); ?>
