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
                $address = get_field( 'address' );
                $phone_number = get_field( 'phone_number' );
                $description = get_field( 'description' );
                $hours = get_field( 'hours' );
                $website = get_field( 'website' );
                $facebook = get_field( 'facebook' );
                $location_map = get_field( 'location_map' );
                $sub_title = get_field( 'post_sub_title' );
                ?>
                <?php if($sub_title) : ?>
                 <h5 class="sub-title">
                     <?php echo $sub_title;?>
                 </h5>
                <?php endif; ?>
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
                        <a href="tel:<?php echo sanitize_number($phone_number); ?>" class="phone-number post-info__item">
                            <?php echo $phone_number; ?>
                        </a>
                    <?php endif; ?>

                    <?php if ( $description ) : ?>
                        <div class="description post-info__item">
                            <?php echo $description; ?>
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
                        <?php _e('VISIT WEBSITE'); ?>
                    </a>
                <?php endif; ?>

                <?php if(has_post_thumbnail()) : ?>
                 <div class="entry__thumb">
                     <?php the_post_thumbnail();?>
                 </div>
                <?php endif; ?>

                <article class="entry__content">
                    <?php the_content(); ?>
                </article>
                <?php if ( $facebook ) : ?>
                    <a href="<?php echo $facebook; ?>" target="_blank" class="facebook-btn">
                        <i class="fa-brands fa-facebook"></i>
                        <?php _e('Visit Facebook Page'); ?>
                    </a>
                <?php endif; ?>

                <?php if ( $location_map ) : ?>
                    <div class="location-map">
                        <?php echo $location_map; ?>
                    </div>
                <?php endif; ?>

            </div>
            <!-- END of post content -->
        </div>
    </div>
</main>

<?php get_footer(); ?>
