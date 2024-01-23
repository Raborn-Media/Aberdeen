<?php
/**
 * Functions
 */

// Declaring the assets manifest
$manifest_json = get_theme_file_path() . '/dist/assets.json';
$assets        = [
    'manifest'  => file_exists( $manifest_json ) ? json_decode( file_get_contents( $manifest_json ), true ) : [],
    'dist'      => get_theme_file_uri() . '/dist',
    'dist_path' => get_theme_file_path() . '/dist',
];
unset( $manifest_json );

/**
 * Retrieve the path to the asset, use hashed version if exists
 *
 * @param $asset
 * @param boolean $path Defines if returned result is a path or a url
 *
 * @return string
 */
function asset_path( $asset, $path = false ) {
    global $assets;
    $asset = isset( $assets['manifest'][ $asset ] ) ? $assets['manifest'][ $asset ] : $asset;

    return "{$assets[$path ? 'dist_path' : 'dist']}/{$asset}";
}

/******************************************************************************
 * Constants
 *****************************************************************************/
define( 'IMAGE_PLACEHOLDER', asset_path( 'images/placeholder.jpg' ) );

/******************************************************************************
 * Included Functions
 *****************************************************************************/
if ( file_exists( $composer = __DIR__ . '/vendor/autoload.php' ) ) {
    require_once $composer;
}

array_map( function ( $file ) {
    $file = "/inc/{$file}.php";
    if ( ! locate_template( $file, true, true ) ) {
        echo sprintf( __( 'Error locating <code>%s</code> for inclusion.', 'fxy' ), $file );
    }
}, [
    'helpers',
    'recommended-plugins',
    'class-foundation-navigation',
    'class-dynamic-admin',
    'class-lazyload',
    'theme-customizations',
    'home-slider',
    'svg-support',
    'gravity-form-customizations',
    'custom-fields-search',
    'google-maps',
    'tiny-mce-customizations',
//    'posttypes',
    'rest',
//    'gutenberg-support', // !!!IMPORTANT  Comment line 159 for enable Gutenberg
//    'woo-customizations',
//    'divi-support',
//    'elementor-support',
//    'shortcodes',
] );

// Register ACF Gravity Forms field
add_action( 'init', function () {
    if ( class_exists( 'ACF' ) ) {
        require_once 'inc/class-fxy-acf-field-gf-field-v5.php';
    }
} );

// Prevent Fatal error on site if ACF not installed/activated
add_action( 'wp', function () {
    include_once 'inc/acf-placeholder.php';
}, PHP_INT_MAX );

/******************************************************************************
 * Enqueue Scripts and Styles for Front-End
 *****************************************************************************/
add_action( 'init', function () {
    wp_register_script( 'runtime.js', asset_path( 'scripts/runtime.js' ), [], null, true );
    wp_register_script( 'vendor.js', asset_path( 'scripts/vendor.js' ), [], null, true );
    if ( file_exists( asset_path( 'styles/vendor.css', true ) ) ) {
        wp_register_style( 'vendor.css', asset_path( 'styles/vendor.css' ), [], null );
    }
} );

add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_admin() ) {
        // Disable gutenberg built-in styles
        // wp_dequeue_style('wp-block-library');

        wp_enqueue_script( 'jquery' );
//        wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.6.4.min.js', array(), '3.6.4', true );


        wp_enqueue_style( 'vendor.css' );
        wp_enqueue_style( 'main.css', asset_path( 'styles/main.css' ), [], null );
        wp_enqueue_script(
            'main.js',
            asset_path( 'scripts/main.js' ),
            [ 'jquery', 'runtime.js', 'vendor.js' ],
            null,
            true
        );

        wp_localize_script(
            'main.js',
            'ajax_object',
            [
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'    => wp_create_nonce( 'project_nonce' ),
            ]
        );
    }
} );

/******************************************************************************
 * Additional Functions
 *****************************************************************************/

// Dynamic Admin
if ( class_exists( 'theme\DynamicAdmin' ) && is_admin() ) {
    $dynamic_admin = new theme\DynamicAdmin();
//    $dynamic_admin->addField('page', 'template', __('Page Template', 'fxy'), 'template_detail_field_for_page');
    $dynamic_admin->run();
}

// Apply lazyload to whole page content
if ( class_exists( 'theme\CreateLazyImg' ) ) {
    add_action(
        'template_redirect',
        function () {
            ob_start( function ( $html ) {
                $lazy   = new theme\CreateLazyImg;
                $buffer = $lazy->ignoreScripts( $html );
                $buffer = $lazy->ignoreNoscripts( $buffer );

                $html = $lazy->lazyloadImages( $html, $buffer );
                $html = $lazy->lazyloadPictures( $html, $buffer );
                $html = $lazy->lazyloadBackgroundImages( $html, $buffer );

                return $html;
            } );
        }
    );
}

/*********************** PUT YOU FUNCTIONS BELOW *****************************/

// Custom media library's image sizes
add_image_size( 'full_hd', 1920, 0, [ 'center', 'center' ] );
add_image_size( 'large_high', 1024, 0, false );
// add_image_size( 'name', width, height, ['center','center']);

// Disable gutenberg
add_filter( 'use_block_editor_for_post_type', '__return_false' );

/*****************************************************************************/

add_filter( 'excerpt_length', function () {
    return 40;
} );

function ajax_filter_get_posts() {
    $filter = [
        'activity_types' => isset( $_POST['activity_types'] ) ? $_POST['activity_types'] : null,
        'accessibility'  => isset( $_POST['accessibility'] ) ? $_POST['accessibility'] : null,
        'duration'       => isset( $_POST['duration'] ) ? $_POST['duration'] : null,
    ];
    $paged  = $_POST['paged'];

    $args = array(
        'order'          => 'DESC',
        'orderby'        => 'menu_order',
        'paged'          => $paged,
        'post_type'      => 'activities',
        'post_status'    => 'publish',
        'post__not_in'   => array( 939, 945, 941, 943, 947 ),
        'posts_per_page' => 9,
        'tax_query'      => [
            'relation' => 'AND'
        ]
    );

    foreach ( $filter as $key => $item ) {
        if ( $item ) {
            $args['tax_query'][] = [
                array(
                    'taxonomy' => $key,
                    'field'    => 'slug',
                    'terms'    => $item
                ),
            ];
        }
    }// Verify nonce
    $activities = new WP_Query( $args );
    $posts      = $activities->posts;
    ob_start(); ?>
    <div class="activities-list">
        <?php

        while ( $activities->have_posts() ) :
            $activities->the_post();
            $taxonomy_names = get_post_taxonomies();
            ?>
            <!-- the loop -->

            <?php get_template_part( 'parts/loop', 'activities' ); // Post item
            ?>

        <?php endwhile;
        wp_reset_postdata(); ?>
    </div>
    <div class="pagination-wrap">

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
    <?php
    $data = ob_get_clean();
    wp_send_json( [ 'data' => $data ] );
}

add_action( 'wp_ajax_filter_posts', 'ajax_filter_get_posts' );
add_action( 'wp_ajax_nopriv_filter_posts', 'ajax_filter_get_posts' );

function ajax_institutions_pagination() {
    $paged             = $_POST['paged'];
    $post_type_to_show = $_POST['postType'];


    $args         = array(
        'post_type'      => $post_type_to_show,
        'order'          => 'ASC',
//        'orderby'        => 'ID',
        'orderby'        => 'menu_order',
        'posts_per_page' => 10,
        'post_status'    => 'publish',
        'paged'          => $paged,
        // Add pagination
    );
    $institutions = new WP_Query( $args );
    ob_start(); ?>
    <div class="institutions-list" data-post-type="<?php echo $post_type_to_show; ?>">
        <?php
        while ( $institutions->have_posts() ) :
            $institutions->the_post();
            $post_type = get_post_type();

            $icon        = get_field( 'icon' );
            $description = get_field( 'description' );
            $city        = get_field( 'city' );
            ?>
            <!-- the loop -->

            <a href="<?php the_permalink() ?>" class="institutions-list__item">
                <div class="institution-icon <?php echo $city === 'Aberdeen' ? 'blue-icon' : ''; ?>">
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
                    <?php else : ?>
                        <?php if ( $description ) : ?>
                            <p class="institution-description">
                                <?php echo $description; ?>
                            </p>
                        <?php else : ?>
                            <p class="institution-description">
                                <?php _e( '---' ); ?>
                            </p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </a>

        <?php endwhile;
        wp_reset_postdata(); ?>
        <div class="pagination-wrap">

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
                        'total'     => $institutions->max_num_pages, // Use $activities to get total pages
                        'prev_text' => '',
                        'next_text' => '',
                    )
                );
                ?>
            </div>
            <?php
            $institutions_max_num_pages = $institutions->max_num_pages;
            if ( $institutions_max_num_pages > 1 ) : ?>
                <div id="pagination-info">
                    Page <span id="current-page"></span> of <span id="total-pages"></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    $data = ob_get_clean();
    wp_send_json( [ 'data' => $data ] );
}

add_action( 'wp_ajax_ajax_institutions_pagination', 'ajax_institutions_pagination' );
add_action( 'wp_ajax_nopriv_ajax_institutions_pagination', 'ajax_institutions_pagination' );

add_action( 'admin_head', 'my_custom_fonts' );
function my_custom_fonts() {
    echo '<style>
#event_tribe_organizer, #event_tribe_venue, #event_cost {
display: none;
}
</style>';
}

// Add filter to remove srcset attribute
function remove_image_srcset( $sources ) {
    return false;
}

add_filter( 'wp_get_attachment_image_srcset', 'remove_image_srcset' );
function custom_get_attachment_image_without_srcset( $attachment_id, $size = 'full' ) {
    $image = wp_get_attachment_image_src( $attachment_id, $size );
    if ( $image ) {
        return '<img src="' . $image[0] . '" alt="" data-no-lazy="1" decoding="async" loading="lazy" width="' . $image[1] . '" height="' . $image[2] . '">';
    }

    return '';
}


