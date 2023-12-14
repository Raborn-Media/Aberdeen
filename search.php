<?php
/**
 * Index
 *
 * Standard loop for the search result page
 */
get_header(); ?>
<?php
$hero_image = get_field( 'not_found_hero_bg', 'options' );
?>

<!-- BEGIN  hero-section -->
<section
    class="hero-section <?php echo ! is_page_template( 'page-template-template-contact' ? '' : 'flexible-section' ) ?>" <?php bg( $hero_image['url'], 'full_hd' ); ?>>
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <h1>
                    <?php _e( 'Search Results For: “Aberdeen Attractions”' ); ?>
                </h1>
            </div>
        </div>
    </div>
</section>
<!-- END  hero-section -->
<section class="flexible-section search-results-section">
    <div class="grid-container">
        <div class="grid-x posts-list">
            <div class="cell small-12">
                <main class="main-content">
                    <?php
                    $search_query   = get_search_query();
                    $search_results = new WP_Query( array(
                        's'              => $search_query,
                        'posts_per_page' => 10,
                        'paged'          => get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1,
                        // Ensure the page number is an integer
                    ) );

                    $total_results = $search_results->found_posts;

                    if ( $total_results === 1 ) {
                        $result_text = 'result';
                    } else {
                        $result_text = 'results';
                    }
                    ?>

                    <p class="results-number">
                        <span class="search-count"><?php echo esc_html( $total_results ); ?></span><span
                            class=""><?php echo esc_html( $result_text ); ?></span>
                    </p>

                    <?php if ( $search_results->have_posts() ) : ?>
                        <?php while ( $search_results->have_posts() ) : $search_results->the_post(); ?>
                            <?php get_template_part( 'parts/loop', 'activities' ); ?>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'fxy' ); ?></p>
                    <?php endif; ?>

                    <!-- BEGIN of pagination -->
                    <div class="pagination-wrap">
                        <?php
                        // Assuming $activities is a WP_Query or another appropriate query object
                        $search_results_max_num_pages = $search_results->max_num_pages;

                        // Generate Foundation pagination
                        foundation_pagination();

                        // Get the current page number
                        $current_page = max( 1, get_query_var( 'paged' ) );
                        // Ensure the current page number is valid
                        $current_page = $current_page > $search_results_max_num_pages ? $search_results_max_num_pages : $current_page;
                        ?>

                        <?php if ( $search_results_max_num_pages > 1 ) : ?>
                            <div id="pagination-info-search">
                                Page <span id="current-page"><?php echo esc_html( $current_page ); ?></span> of <span
                                    id="total-pages"><?php echo esc_html( $search_results_max_num_pages ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- END of pagination -->
                </main>

            </div>
            <!-- END of search results -->
        </div>
    </div>
</section>

<?php get_footer(); ?>
