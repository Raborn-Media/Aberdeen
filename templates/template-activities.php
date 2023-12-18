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

<!-- BEGIN  filter -->
<section class="filter">

</section>
<!-- END  filter -->

<!-- BEGIN  activities-section -->
<section class="activities-section flexible-section">
    <?php
    //    $activities = array(
    //        'post_type' => 'activities',
    //        'order'     => 'ASC',
    //        // ASC, DESC
    //        'orderby'   => 'ID',
    //        // none, ID, author, title, name, date, modified, parent, rand, comment_count, menu_order, meta_value, meta_value_num, title menu_order, post__in
    ////        'posts_per_page' => - 1,
    //    );
    $activities = new WP_Query( array(
        'post_type'      => 'activities',
        'order'          => 'ASC',
        'orderby'        => 'ID',
        'posts_per_page' => 9,
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
                        <span><?php the_title();?></span>
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
                            <?php while ( $activities->have_posts() ) : $activities->the_post(); ?>

                                <?php get_template_part( 'parts/loop', 'activities' ); // Post item?>

                            <?php endwhile; ?>
                            <!-- end of the loop -->
                            <?php wp_reset_postdata(); ?>
                        </div>
                        <!--                        <div class="pagination">-->
                        <div class="pagination-wrap">
                            <?php $paged = max( 1, get_query_var( 'paged' ) ); // Get current page number
                            ?>
                            <div class="pagination"
                                 data-current-page="<?php echo esc_attr( $paged ); ?>"
                                 data-total-pages="<?php echo esc_attr( $activities->max_num_pages ); ?>">
                                <?php

                                // Pagination
                                $big = 999999999; // An unlikely integer

                                echo paginate_links(
                                    array(
                                        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                        'format'    => '?paged=%#%',
                                        'current'   => max( 1, $paged ),
                                        'total'     => $activities->max_num_pages, // Use $activities to get total pages
                                        'prev_text' => '',
                                        'next_text' => '',
                                    )
                                );
                                ?>
                            </div>
                            <?php
                            $activities_max_num_pages = $activities->max_num_pages;
                            if ( $activities_max_num_pages > 1 ) : ?>
                                <div id="pagination-info">
                                    Page <span id="current-page"></span> of <span id="total-pages"></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
<!-- END  activities-section -->

<?php get_footer(); ?>
