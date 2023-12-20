<?php
$section_top_image_title = get_sub_field( 'section_top_image_title' );
$section_bg              = get_sub_field( 'section_bg' );
$mail_icon               = get_sub_field( 'mail_icon' );
$logo                    = get_sub_field( 'logo' );
$section_title           = get_sub_field( 'section_title' );
$section_text            = get_sub_field( 'section_text' );
$section_button          = get_sub_field( 'section_button' );
?>

<!-- BEGIN  sign-up-banner-section -->
<section class="sign-up-banner-section flexible-section">
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <?php if ( $section_top_image_title ) : ?>
                    <div class="section-top-image-title ease-btm" data-scroll>
                        <?php echo wp_get_attachment_image( $section_top_image_title['id'], 'large', false, [ 'class' => '' ] ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid-x">
            <div class="cell">
                <div class="banner">
                    <?php echo wp_get_attachment_image( $section_bg['id'], 'full_hd', false, ['class' => 'banner-bg'] ); ?>
                    <div class="banner-content">
                        <?php if ( $mail_icon ) : ?>
                            <div class="banner-content__mail-icon">
                                <?php echo wp_get_attachment_image( $mail_icon['id'], 'large' ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="banner-content__text">
                            <?php if ( $section_title ) : ?>
                                <h3>
                                    <?php echo $section_title ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ( $section_text ) : ?>
                                <h4>
                                    <?php echo $section_text ?>
                                </h4>
                            <?php endif; ?>

                            <?php if ( $section_button ) : ?>
                                <a href="<?php echo $section_button['url']; ?>" class="button button--arrow">
                                    <?php echo $section_button['title']; ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        <?php if ( $logo ) : ?>
                            <div class="banner-content__logo">
                                <?php echo wp_get_attachment_image( $logo['id'], 'large' ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END  sign-up-banner-section -->
