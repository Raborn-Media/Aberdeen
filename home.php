<?php
/**
 * Home
 *
 * Standard loop for the blog-page
 */
get_header(); ?>

<?php
$hero_image = get_sub_field('hero_image');
$hero_title = get_sub_field('hero_title')
?>

<!-- BEGIN  hero-section -->
<!-- Doesn't grab any image -->
<!-- <section id="blog-hero-section" class="hero-section flexible-section" <?php bg( $hero_image['url'], 'full_hd' ); ?>> -->
<!-- this grabs featured image from first blog post -->
<!-- <section id="blog-hero-section" class="hero-section flexible-section" <?php bg( get_attached_img_url( get_the_ID(), 'full_hd' ) ); ?>> -->
<section id="blog-hero-section" class="hero-section flexible-section">
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <h1>Blog</h1>
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
                    <span>Blog</span>
                </div>
                <section class="blog-post-section flexible-section">
                    <?php
                    $blog_post = new WP_Query( array(
                        'post_type'      => 'blog-post',
                        'order'          => 'DESC',
                        'orderby'        => 'menu_order',
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
