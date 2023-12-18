<?php
/**
 * Single
 *
 * Loop container for single post content
 */
get_header();

global $post;
?>
<main class="main-content">
    <div class="grid-container post-container">
        <div class="grid-x ">
            <!-- BEGIN of post content -->
            <div class="small-12 cell">

                <?php
                $address      = get_field( 'activity_address' );
                $phone_number = get_field( 'activity_phone' );
                $hours        = get_field( 'activity_hours' );
                $website      = get_field( 'visit_website' );
                $facebook     = get_field( 'activity_facebook_page' );
                $location_map = get_field( 'activity_location_map' );
                ?>
                <div class="custom-breadcrumbs">
                    <a href="<?php echo get_home_url(); ?>" class="home-url">Home</a>
                    <span>&nbsp;&gt;&nbsp;</span>
                    <a href="/things-to-see-do"><?php _e('EXPLORE'); ?></a>
                    <span>&nbsp;&gt;&nbsp;</span>
                    <span><?php the_title(); ?></span>
                </div>
                <h3>
                    <?php the_title(); ?>
                </h3>
                <div class="acf-post-info">
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

                    <?php
                    $post_id      = get_the_ID();
                    $access_terms = get_the_terms( $post_id, 'accessibility' );
                    if ( $access_terms && ! is_wp_error( $access_terms ) ) : ?>
                        <div class="description post-info__item">
                            <?php foreach ( $access_terms as $index => $access_term ) : ?>
                                <p class="accessibility__item small">
                                    <?php echo $access_term->name;
                                    // Додайте кому, якщо це не останній елемент
                                    echo ( $index !== count( $access_terms ) - 1 ) ? ',' : ''; ?>
                                </p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( $hours ) : ?>
                        <div class="hours post-info__item">
                            <?php echo $hours; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ( $website ) : ?>
                    <a href="<?php echo $website; ?>" target="_blank" class="website button button--web">
                        <?php _e( 'VISIT WEBSITE' ); ?>
                    </a>
                <?php endif; ?>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="entry__thumb">
                        <?php the_post_thumbnail(); ?>
                    </div>
                <?php endif; ?>

                <article class="entry__content">
                    <?php the_content(); ?>
                </article>
                <?php if ( $facebook ) : ?>
                    <a href="<?php echo $facebook; ?>" target="_blank" class="facebook-btn">
                        <i class="fa-brands fa-facebook"></i>
                        <?php _e( 'Visit Facebook Page' ); ?>
                    </a>
                <?php endif; ?>

                <?php if ( $location_map ) : ?>
                    <div id="location-map" class="location-map">
                        <?php echo $location_map; ?>
                    </div>
                <?php endif; ?>

            </div>
            <!-- END of post content -->
        </div>
    </div>
</main>

<?php get_footer(); ?>
