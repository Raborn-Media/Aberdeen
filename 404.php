<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header(); ?>
<!-- BEGIN of 404 page -->

<?php
$hero_image     = get_field( 'not_found_hero_bg', 'options' );
$not_found_text = get_field( 'not_found_text', 'options' );
?>

<!-- BEGIN  hero-section -->
<section
    class="hero-section <?php echo ! is_page_template( 'page-template-template-contact' ? '' : 'flexible-section' ) ?>" <?php bg( $hero_image['url'], 'full_hd' ); ?>>
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <h1>
                    <?php _e( '404' ); ?>
                </h1>
            </div>
        </div>
    </div>
</section>
<!-- END  hero-section -->
<section class="not-found flexible-section">
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <article>
                    <?php echo $not_found_text ?>
                </article>
                <a class="button button--arrow" href="<?php echo get_bloginfo( 'url' ) ?>">RETURN TO HOMEPAGE</a>
            </div>
        </div>
    </div>
</section>
<!-- END of 404 page -->
<?php get_footer(); ?>
