<?php
/**
 * Template Name: Activities template
 */
get_header();
//$hero_image =
?>

<!-- BEGIN  hero-section -->
<section
    class="hero-section" <?php bg( get_attached_img_url( get_the_ID(), 'full_hd' ) ); ?>>
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <h1>
                    <?php the_title(); ?>
                </h1>
            </div>
        </div>
    </div>
</section>
<!-- END  hero-section -->

<!-- BEGIN  activities-section -->
<section class="activities-section flexible-section">
    <?php
    $activities = new WP_Query( array(
        'post_type'      => 'activities',
        'order'          => 'DESC',
        'post__not_in'   => array( 939, 945, 941, 943, 947 ),
        'orderby'        => 'menu_order',
//        'posts_per_page' => 9,
        'posts_per_page' => - 1,
        'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1, // Add pagination
    ) );
    $posts      = $activities->posts;
    $taxonomies = get_taxonomies( [ 'object_type' => [ 'activities' ] ] );
    if ( $activities ) :
        ?>
        <div class="grid-container">
            <div class="grid-x">
                <div class="cell">
                    <div class="filter-wrapper">
                        <?php foreach ( $taxonomies as $taxonomy ) :
                            $tax_name = get_taxonomy( $taxonomy );
                            ?>
                            <div class="filter-item filter-<?php echo $taxonomy; ?>">
                                <select id="<?php echo $taxonomy; ?>" class="tax-filter"
                                        filter-name="<?php echo $taxonomy; ?>">
                                    <option>
                                        <?php _e( $tax_name->labels->singular_name . '' ) ?>
                                    </option>
                                    <?php $terms = get_terms( array(
                                        'taxonomy'   => $taxonomy, // to make it simple I use default categories
                                        'orderby'    => 'name',
                                        'hide_empty' => false
                                    ) ); ?>
                                    <?php foreach ( $terms as $term ) : ?>
                                        <option title="<?php echo $term->slug; ?>"
                                                value="<?php echo $term->term_id; ?>">
                                            <?php echo $term->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endforeach; ?></div>
                </div>
            </div>
            <div class="grid-x">
                <div class="cell">
                    <div class="custom-breadcrumbs">
                        <a href="<?php echo get_home_url(); ?>" class="home-url">Home</a>
                        <span>&nbsp;&gt;&nbsp;</span>
                        <span>EXPLORE</span>
                        <span>&nbsp;&gt;&nbsp;</span>
                        <span><?php the_title(); ?></span>
                    </div>
                    <article class="text-center page-content">
                        <?php the_content(); ?>
                    </article>
                </div>
            </div>
            <div class="grid-x">
                <div class="cell">

                    <div class="activities-wrap">
                        <div class="activities-list">
                            <!-- the loop -->
                            <?php while ( $activities->have_posts() ) :
                                $activities->the_post(); ?>

                                <?php get_template_part( 'parts/loop', 'activities' ); // Post item
                                ?>

                            <?php endwhile; ?>
                            <!-- end of the loop -->
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- BEGIN  nearby-attractions-section -->
    <div class="nearby-attractions">
        <div class="grid-container">
            <div class="grid-x">
                <?php if ( $attractions_section_top_content = get_field( 'attractions_section_top_content' ) ) : ?>
                    <div class="cell">
                        <article class="text-center page-content">
                            <?php echo $attractions_section_top_content; ?>
                        </article>
                    </div>
                <?php endif; ?>

                <?php if ( $attractions_location_map = get_field( 'attractions_location_map' ) ) : ?>
                    <div class="cell">
                        <div class="list-map">
                            <?php echo $attractions_location_map ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                $args = array(
                    'post_type'      => 'activities',
                    'order'          => 'ASC',
                    'post__in'       => array( 939, 945, 941, 943, 947 ),
                    'orderby'        => 'ID',
                    'posts_per_page' => 5,
                    'post_status'    => 'publish',

                );
                ?>

                <?php $the_query = new WP_Query( $args ); ?>

                <?php if ( $the_query->have_posts() ) : ?>
                    <div class="cell">
                        <div class="nearby-attractions__list">
                            <!-- the loop -->
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                <!--                            --><?php //get_template_part( 'parts/loop', 'activities' ); // Post item
//                            ?>
                                <a href="<?php the_permalink() ?>" class="nearby-attractions__list-item">
                                    <div class="attraction-icon">
                                        <div class="icon-wrap">
                                            <?php if ( $icon = get_field( 'attraction_icon' ) ) : ?>
                                                <?php echo display_svg( $icon ); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="attraction-info">
                                        <h4><?php the_title(); ?></h4>

                                        <?php if ( $activity_address = get_field( 'activity_address' ) ) : ?>
                                            <p>
                                                <?php echo $activity_address; ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </a>

                            <?php endwhile; ?>
                            <!-- end of the loop -->
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- END  nearby-attractions-section -->
</section>
<!-- END  activities-section -->

<?php get_footer(); ?>
