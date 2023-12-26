<?php
$section_icon   = get_sub_field( 'section_icon' );
$section_title  = get_sub_field( 'section_title' );
$section_text   = get_sub_field( 'section_text' );
$featured_posts = get_sub_field( 'events_list' );
?>

<!-- BEGIN  featured-events-section -->
<section class="featured-events-section flexible-section">
    <div class="grid-container">
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
                    <?php if ( $section_text ) : ?>
                        <p class="section-text">
                            <?php echo $section_text; ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <?php
            if ( $featured_posts ): ?>
                <div class="cell">
                    <div class="events-list">
                        <?php foreach ( $featured_posts as $post ):

                            // Setup this post for WP functions (variable must be named $post).
                            setup_postdata( $post );
                            $post_image = get_the_post_thumbnail();
                            ?>
                            <div class="event">
                                <a href="<?php the_permalink(); ?>">
                                <span class="featured">
                                    <?php _e( 'Featured' ); ?>
                                </span>
                                    <div class="event__image">
                                        <?php echo $post_image; ?>
                                    </div>
                                    <h4>
                                        <?php the_title(); ?>
                                    </h4>
                                    <?php if ( tribe_event_is_all_day() ) :

                                        $event_id = get_the_ID();
                                        $start_time = get_post_meta( $event_id, '_EventStartDate', true );
                                        $end_time = get_post_meta( $event_id, '_EventEndDate', true );

                                        $formatted_start_time = date( 'd M', strtotime( $start_time ) );
                                        $formatted_end_time   = date( 'd M', strtotime( $end_time ) );
                                        ?>
                                        <p class="events-time hours post-info__item">
                                            <?php echo $formatted_start_time . ' - ' . $formatted_end_time; ?>
                                        </p>
                                    <?php else : ?>
                                        <p class="events-time hours post-info__item">
                                            <?php
                                            $start_time = get_post_meta( $event_id, '_EventStartDate', true );
                                            $end_time   = get_post_meta( $event_id, '_EventEndDate', true );

                                            $formatted_start_time = date( 'g:i A', strtotime( $start_time ) );
                                            $formatted_end_time   = date( 'g:i A', strtotime( $end_time ) );

                                            // Output the formatted times
                                            echo $formatted_start_time . ' - ' . $formatted_end_time
                                            ?>
                                        </p>
                                    <?php endif; ?>
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
