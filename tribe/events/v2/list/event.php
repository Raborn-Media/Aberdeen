<?php
/**
 * View: List Event
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

$container_classes = [
    'tribe-common-g-row',
    'tribe-events-calendar-list__event-row'
];
$container_classes['tribe-events-calendar-list__event-row--featured'] = $event->featured;

$event_classes = tribe_get_post_class([
    'tribe-events-calendar-list__event',
    'tribe-common-g-row',
    'tribe-common-g-row--gutters'
], $event->ID);
?>
<div <?php tribe_classes($container_classes); ?>>


    <div class="tribe-events-calendar-list__event-wrapper tribe-common-g-col">
        <article <?php tribe_classes($event_classes) ?>>
            <?php $this->template('list/event/featured-image', [ 'event' => $event ]); ?>

            <div class="tribe-events-calendar-list__event-details tribe-common-g-col event-info">

                <header class="tribe-events-calendar-list__event-header">
                    <?php if ($custom_top_date = get_field('custom_top_date')) : ?>
                        <div class="top-date">
                            <?php echo $custom_top_date; ?>
                        </div>
                    <?php else : ?>
                        <div class="top-date">
                            <?php
                            $formatted_date = date('F j', strtotime($event->start_date));

                            echo $formatted_date; ?>
                        </div>
                    <?php endif; ?>
                    <?php $this->template('list/event/title', [ 'event' => $event ]); ?>

                    <?php if ($custom_event_time = get_field('custom_event_time')) : ?>
                        <p class="events-time">
                            <?php echo $custom_event_time; ?>
                        </p>
                    <?php else : ?>
                        <p class="events-time">
                            <?php
                            $formatted_start_time = date('g:i A', strtotime($event->start_date));
                            $formatted_end_time   = date('g:i A', strtotime($event->end_date));

                            // Output the formatted times
                            echo $formatted_start_time . ' - ' . $formatted_end_time
                            ?>
                        </p>
                    <?php endif; ?>

                </header>

                <?php $this->template('list/event/description', [ 'event' => $event ]); ?>

                <div class="event-buttons">
                    <a href="<?php echo esc_url($event->permalink); ?>" class="button button--arrow">
                        <?php _e('Learn more'); ?>
                    </a>

                    <a href="" class="button button--web">
                        <?php _e('VISIT WEBSITE'); ?>
                    </a>
                    <a href="" class="button button--pin">
                        <?php _e('GET DIRECTIONS'); ?>
                    </a>
                </div>
            </div>

        </article>
    </div>

</div>
