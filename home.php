<?php
/**
 * Home
 *
 * Standard loop for the blog-page
 */
get_header(); ?>

<?php
// grabs blog page title
$our_title = get_the_title( get_option('page_for_posts', true) );
$slug = get_page_by_path( 'blog' );
$hero_image = get_field('hero_image', $slug );
$hero_title = get_sub_field('hero_title')
?>

<!-- BEGIN  hero-section -->
<section id="blog-hero-section" class="hero-section flexible-section" style="background: url('<?php echo $hero_image['url']; ?>')">
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <h1>
                    <?php echo $our_title; ?>
                </h1>
            </div>
        </div>
    </div>
</section>
<!-- END  hero-section -->
<main class="blog-main-content">
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell">
                <div class="custom-breadcrumbs">
                    <a href="<?php echo get_home_url(); ?>" class="home-url">Home</a>
                    <span>&nbsp;&gt;&nbsp;</span>
                    <span>
                        <?php echo $our_title; ?>
                    </span>
                </div>
                <section class="blog-post-section flexible-section">
                    <?php
                    $blog_post = new WP_Query( array(
                        'post_type'      => 'blog-post',
                        'posts_per_page' => - 1,
                    ) );
                    $posts      = $blog_post->posts;
                    $taxonomies = get_taxonomies( [ 'object_type' => [ 'blog-post' ] ] );
                    if ( $blog_post ) :
                        ?>
                        <div class="grid-x">
                            <div class="cell">

                                <div class="blog-post-wrap">
                                    <div class="blog-post-list">
                                        <!-- the loop -->
                                        <?php while ( $blog_post->have_posts() ) :
                                            $blog_post->the_post(); ?>

                                            <?php get_template_part( 'parts/loop', 'blog-posts' ); // Post item
                                            ?>

                                        <?php endwhile; ?>
                                        <!-- end of the loop -->
                                        <?php wp_reset_postdata(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
