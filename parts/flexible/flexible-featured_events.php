<?php
$section_icon  = get_sub_field( 'section_icon' );
$section_title = get_sub_field( 'section_title' );
$section_text     = get_sub_field( 'section_text' );
$featured_posts     = get_sub_field( 'events_list' );
?>

<!-- BEGIN  featured-events-section -->
<section class="featured-events-section flexible-section">
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
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
                <?php if ( $section_text ) : ?>
                    <p class="section-text">
                        <?php echo $section_text; ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php
            if( $featured_posts ): ?>
            <div class="cell">
                <div class="events-list">
                    <?php foreach( $featured_posts as $post ):

                        // Setup this post for WP functions (variable must be named $post).
                        setup_postdata($post);
                        $post_image = get_the_post_thumbnail();
                        ?>
                        <div class="event">
                            <a href="<?php the_permalink(); ?>">
                                <span class="featured">
                                    <?php _e('Featured'); ?>
                                </span>
                                <div class="event__image">
                                    <?php echo $post_image; ?>
                                </div>
                            </a>
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
<!-- END  featured-events-section -->
