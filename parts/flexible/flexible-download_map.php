<?php
$section_image = get_sub_field( 'section_image' );
$download_file = get_sub_field( 'download_file' );
$location      = get_sub_field( 'location' );
$map_iframe    = get_sub_field( 'map_iframe' );
?>

<!-- BEGIN  download-map-section -->
<section class="download-map-section flexible-section">
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell">
                <?php if ( $section_image ) : ?>
                    <div class="section-image">
                        <?php echo wp_get_attachment_image( $section_image['id'], 'full_hd' ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( $download_file ) : ?>
                    <a href="<?php echo $download_file['url']; ?>" download="<?php echo $download_file['title']; ?>"
                       class="button button--arrow download-button">
                        <?php _e( 'Download PDF' ); ?>
                    </a>
                <?php endif; ?>

                <?php if ( $map_iframe ) : ?>
                    <div class="map-iframe">
                        <?php echo $map_iframe ?>
                    </div>
                <?php endif; ?>

                <?php if ( $location ) : ?>
                    <div class="cell contact__map-wrap">
                        <div class="acf-map contact__map">
                            <div class="marker"
                                 data-lat="<?php echo $location['lat']; ?>"
                                 data-lng="<?php echo $location['lng']; ?>"
                                 data-marker-icon="<?php echo asset_path( 'images/map_marker.png' ); ?>">
                                <p><?php echo $location['address']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- END  download-map-section -->
