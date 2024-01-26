<?php
$section_icon  = get_sub_field( 'section_icon' );
$section_title = get_sub_field( 'section_title' );
$section_video = get_sub_field( 'section_video' );
?>

<!-- BEGIN  testimonials-section -->
<section class="testimonials-section flexible-section">
    <div class="grid-container section-container">
        <div class="grid-x">
            <div class="cell text-center">
                <div class="section-heading">
                    <?php if ( $section_icon ) : ?>
                        <div class="section-icon">
                            <div class="section-icon__wrap">
                                <?php echo display_svg( $section_icon, 'icon' ); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ( $section_title ) : ?>
                        <h3 class="section-title">
                            <?php echo $section_title; ?>
                        </h3>
                    <?php endif; ?>
                </div>
            </div>
            <?php if($section_video) : ?>
                <div class="cell">
                    <video src="<?php echo $section_video; ?>"
                           autoplay
                           preload="none"
                           muted="muted"
                           loop="loop"
                           class="video testimonials-section__video"></video>
                </div>
            <?php endif; ?>

            <?php
            $featured_posts = get_sub_field( 'testimonials' );
            if ( $featured_posts ): ?>
                <div class="cell">
                    <div class="testimonials">
                        <?php foreach ( $featured_posts as $post ):

                            // Setup this post for WP functions (variable must be named $post).
                            setup_postdata( $post );
                            $post_image = get_the_post_thumbnail();

                            ?>
                            <div class="testimonial text-center">
                                <div class="testimonial__image">
                                    <?php echo $post_image; ?>
                                </div>
                                <h5><?php the_title(); ?></h5>
                                <article><?php the_content(); ?></article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php
                // Reset the global post object so that the rest of the page works correctly.
                wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>
