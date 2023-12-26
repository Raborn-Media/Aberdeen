<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = Tribe__Events__Main::postIdHelper( get_the_ID() );

/**
 * Allows filtering of the event ID.
 *
 * @param int $event_id
 *
 * @since 6.0.1
 *
 */
$event_id = apply_filters( 'tec_events_single_event_id', $event_id );

/**
 * Allows filtering of the single event template title classes.
 *
 * @param array $title_classes List of classes to create the class string from.
 * @param string $event_id The ID of the displayed event.
 *
 * @since 5.8.0
 *
 */
$title_classes = apply_filters( 'tribe_events_single_event_title_classes', [ 'tribe-events-single-event-title' ], $event_id );
$title_classes = implode( ' ', tribe_get_classes( $title_classes ) );

?>
<section class="flexible-section">
    <div class="grid-container event-container">
        <div class="grid-x">
            <div class="cell">
                <div id="tribe-events-content" class="tribe-events-single">
                    <h5>
                        <?php _e( 'events' ); ?>
                    </h5>
                    <h3>
                        <?php the_title(); ?>
                    </h3>
                    <div class="acf-post-info">
                        <?php
                        $address      = get_field( 'event_address' );
                        $phone_number = get_field( 'event_phone' );
                        $website      = get_field( 'event_website' );
                        $facebook     = get_field( 'event_facebook' );
                        $location_map = get_field( 'event_location_map' );
                        ?>
                        <?php if ( $address ) : ?>
                            <div class="address post-info__item">
                                <?php echo $address; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $phone_number ) : ?>
                            <a href="tel:<?php echo sanitize_number( $phone_number ); ?>"
                               class="phone-number post-info__item">
                                <?php echo $phone_number; ?>
                            </a>
                        <?php endif; ?>

                        <?php if ( $custom_event_time = get_field( 'custom_event_time' ) ) : ?>
                            <p class="events-time hours">
                                <?php echo $custom_event_time; ?>
                            </p>
                        <?php else : ?>
                        <?php if(tribe_event_is_all_day()) :
                                $start_time = get_post_meta( $event_id, '_EventStartDate', true );
                                $end_time   = get_post_meta( $event_id, '_EventEndDate', true );

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

                        <?php endif; ?>
                    </div>
                    <?php if ( $website ) : ?>
                        <div>
                            <a href="<?php echo $website; ?>" target="_blank" class="website button button--web">
                                <?php _e( 'VISIT WEBSITE' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php while ( have_posts() ) : the_post(); ?>
                        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <!-- Event featured image, but exclude link -->
                            <?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>

                            <!-- Event content -->
                            <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
                            <div class="tribe-events-single-event-description tribe-events-content">
                                <?php the_content(); ?>
                            </div>
                            <?php if ( $facebook ) : ?>
                                <a href="<?php echo $facebook; ?>" target="_blank" class="facebook-btn">
                                    <i class="fa-brands fa-facebook"></i>
                                    <?php _e( 'Visit Facebook Page' ); ?>
                                </a>
                            <?php endif; ?>
                            <?php if ( $location_map ) : ?>
                                <div class="location-map">
                                    <?php echo $location_map; ?>
                                </div>
                            <?php endif; ?>
                        </div> <!-- #post-x -->
                    <?php endwhile; ?>
                </div><!-- #tribe-events-content -->
            </div>
        </div>
    </div>
</section>
