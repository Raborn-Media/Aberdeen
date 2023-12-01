<?php
$section_icon = get_sub_field( 'section_icon' );
$section_title = get_sub_field( 'section_title' );
$section_text = get_sub_field( 'section_text' );
?>

<!-- BEGIN  full-width-sectio -->
<section class="full-width-section flexible-section">
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <div class="section-heading">
                    <?php if ( $section_icon ) : ?>
                        <div class="section-icon">
                            <div class="section-icon__wrap">
                                <?php echo display_svg( $section_icon, 'icon' ); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ( $section_title ) : ?>
                        <h3 class="section-title">
                            <?php echo $section_title; ?>
                        </h3>
                    <?php endif; ?>
                </div>
            </div>
            <div class="cell">
                <div class="section-text">
                    <?php echo $section_text; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END  full-width-sectio -->
