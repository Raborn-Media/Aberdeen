<?php
/**
 * Archive
 *
 * Standard loop for the search result page
 */
get_header(); ?>
<?php
$hero_image = get_field( 'not_found_hero_bg', 'options' );
?>

<!-- BEGIN  hero-section -->
<section
    class="hero-section <?php echo ! is_page_template( 'page-template-template-contact' ? '' : 'flexible-section' ) ?>" <?php bg( $hero_image['url'], 'full_hd' ); ?>>
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <h1 class="page-title page-title--archive"><?php echo get_the_archive_title(); ?></h1>
            </div>
        </div>
    </div>
</section>
<!-- END  hero-section -->
<section class="flexible-section search-results-section">
    <div class="grid-container">
        <div class="grid-x posts-list">
            <div class="cell small-12">
                <main class="main-content">

                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) :
                            the_post(); ?>
                            <?php get_template_part( 'parts/loop', 'activities' ); // Post item
                            ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </main>

            </div>
            <!-- END of search results -->
        </div>
    </div>
</section>

<?php get_footer(); ?>
