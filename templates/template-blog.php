<?php
/**
 * Template Name: Blog
 *
 *  Use home.php for blog page instead
 */
get_header();

$hero_image = get_field('hero_image');
// $hero_image = get_sub_field('hero_image');
$hero_title = get_sub_field('hero_title')
?>

<!-- BEGIN  hero-section -->
 <!-- doesn't get hero image -->
<!-- <section id="blog-hero-section" class="hero-section flexible-section" <?php bg( $hero_image['url'], 'full_hd' ); ?>> -->
<!-- only works on local site, but doesn't work w/ flexible content hero image -->
<section id="blog-hero-section" class="hero-section flexible-section" style="background: url('<?php echo $hero_image['url']; ?>')">

    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <h1>
                    <?php the_title(); ?>
                </h1>
            </div>
        </div>
    </div>
</section>
<!-- END  hero-section -->

<!-- BEGIN  blog-post-section -->
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
        <div class="grid-container">
            <div class="grid-x">
                <div class="cell">
                    <div class="custom-breadcrumbs">
                        <a href="<?php echo get_home_url(); ?>" class="home-url">Home</a>
                        <span>&nbsp;&gt;&nbsp;</span>
                        <span><?php the_title(); ?></span>
                    </div>
                    <article class="text-center page-content">
                        <?php the_content(); ?>
                    </article>
                </div>
            </div>
            <div class="grid-x">
                <div class="cell">

                    <div class="blog-post-wrap">
                        <div class="blog-post-list">
                            <!-- the loop -->
                            <?php while ( $blog_post->have_posts() ) :
                                $blog_post->the_post(); ?>

                                <?php get_template_part( 'parts/loop', 'post' ); // Post item
                                ?>

                            <?php endwhile; ?>
                            <!-- end of the loop -->
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
<!-- END  blog-post-section -->

<?php get_footer(); ?>
