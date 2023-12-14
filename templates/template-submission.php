<?php
/**
 * Template Name: Submission
 */

get_header(); ?>
<?php if ( $top_content_row = get_field( 'top_content_row' ) ) : ?>
    <div class="top-content-row text-center">
        <p>
            <?php echo $top_content_row; ?>
        </p>
    </div>
<?php endif; ?>

<!-- BEGIN  submission-content -->
<section class="submission-content flexible-section">
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <div class="section-content">
                    <?php the_content(); ?>
                </div>
                <a class="button button--arrow" href="<?php echo get_bloginfo( 'url' ) ?>">RETURN TO HOMEPAGE</a>
            </div>
        </div>
    </div>
</section>
<!-- END  submission-content -->

<?php get_footer(); ?>
