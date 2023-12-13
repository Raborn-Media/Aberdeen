<?php
$post_type_to_show = get_sub_field( 'post_type_to_show' );
$list_map          = get_sub_field( 'list_map' );
?>

<!-- BEGIN  institutions-list-section -->
<section class="institutions-list-section flexible-section">
    <div class="grid-container">
        <div class="grid-x">
            <?php if ( $list_map ) : ?>
                <div class="cell">
                    <div class="list-map">
                        <?php echo $list_map ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="cell">
                <?php
                $institutions = new WP_Query( array(
                    'post_type'      => $post_type_to_show,
                    'order'          => 'ASC',
                    'orderby'        => 'ID',
                    'posts_per_page' => 10,
                    'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1, // Add pagination

                ) );
                ?>
                <div class="institutions-list-wrap">
                    <?php if ( $institutions ) : ?>
                        <div class="institutions-list" data-post-type="<?php echo $post_type_to_show; ?>">
                            <!-- the loop -->
                            <?php while ( $institutions->have_posts() ) : $institutions->the_post();
                                $post_type = get_post_type();

                                $icon        = get_field( 'icon' );
                                $description = get_field( 'description' );
                                $city        = get_field( 'city' );
                                ?>
                                <a href="<?php the_permalink() ?>" class="institutions-list__item">
                                    <div class="institution-icon">
                                        <div class="icon-wrap">
                                            <?php if ( $icon ) : ?>
                                                <?php echo display_svg( $icon ); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="institution-info">
                                        <h4><?php the_title(); ?></h4>
                                        <?php if ( $post_type == 'hotels' ) : ?>
                                            <?php if ( $city ) : ?>
                                                <p class="institution-description">
                                                    <?php echo $city; ?>
                                                </p>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if ( $description ) : ?>
                                                <p class="institution-description">
                                                    <?php echo $description; ?>
                                                </p>
                                            <?php else: ?>
                                                <p class="institution-description">
                                                    <?php _e( '---' ); ?>
                                                </p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                            <!-- end of the loop -->
                            <?php wp_reset_postdata(); ?>
                            <div class="pagination-wrap">
                                <?php $paged = max( 1, get_query_var( 'paged' ) ); // Get current page number
                                ?>
                                <div class="pagination"
                                     data-current-page="<?php echo esc_attr( $paged ); ?>"
                                     data-total-pages="<?php echo esc_attr( $institutions->max_num_pages ); ?>">
                                    <?php

                                    // Pagination
                                    $big = 999999999; // An unlikely integer

                                    echo paginate_links(
                                        array(
                                            'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                            'format'    => '?paged=%#%',
                                            'current'   => max( 1, $paged ),
                                            'total'     => $institutions->max_num_pages,
                                            // Use $activities to get total pages
                                            'prev_text' => '',
                                            'next_text' => '',
                                        )
                                    );
                                    ?>
                                </div>
                                <?php
                                $activities_max_num_pages = $institutions->max_num_pages;
                                if ( $activities_max_num_pages > 1 ) : ?>
                                    <div id="pagination-info">
                                        Page <span id="current-page"></span> of <span id="total-pages"></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END  institutions-list-section -->
