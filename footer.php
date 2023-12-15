<?php
/**
 * Footer
 */
?>

<!-- BEGIN of footer -->
<?php if ( $cta_bg = get_field( 'cta_bg', 'options' ) ) : ?>
    <div class="cta-bg">
        <?php echo wp_get_attachment_image( $cta_bg['id'], 'full_hd' ); ?>
    </div>
<?php endif; ?>
<div class="cta-section">
    <div class="grid-container cta-section__container">
        <div class="grid-x">
            <div class="cell large-7 form-col">
                <?php if ( $cta_form_title = get_field( 'cta_form_title', 'option' ) ) : ?>
                    <h4>
                        <?php echo $cta_form_title; ?>
                    </h4>
                <?php endif; ?>
                <?php if ( $cta_form = get_field( 'cta_form', 'options' ) ) : ?>
                    <div class="cta-form">
                        <?php echo do_shortcode( "[gravityform id='{$cta_form['id']}' title='false' description='false' ajax='true']" ); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="cell large-5 map-col">
                <div class="cta-map-info">
                    <?php if ( $cta_map_title = get_field( 'cta_map_title', 'option' ) ) : ?>
                        <h4>
                            <?php echo $cta_map_title; ?>
                        </h4>
                    <?php endif; ?>

                    <?php if ( $cta_map_link = get_field( 'cta_map_link', 'option' ) ) : ?>
                        <a href="<?php echo $cta_map_link['url']; ?>">
                            <?php echo $cta_map_link['title']; ?>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14"
                                     fill="none">
  <path d="M0.5 6.11145H15.6321V8.0637H0.5V6.11145Z" fill="white"/>
  <path
      d="M11.4343 13.6293L10.0669 12.2619L15.2418 7.08789L10.0669 1.91391L11.4343 0.546509L17.9748 7.08791L11.4343 13.6293Z"
      fill="white"/>
</svg>
                            </span>
                        </a>
                    <?php endif; ?>
                </div>
                <?php if ( $cta_map_image = get_field( 'cta_map_image', 'options' ) ) : ?>
                    <div class="cta-map-image">
                        <?php echo wp_get_attachment_image( $cta_map_image['id'], 'large' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell large-3">
                <div class="footer__logo">
                    <?php if ( $footer_logo = get_field( 'footer_logo', 'options' ) ) :
                        echo wp_get_attachment_image( $footer_logo['id'], 'medium' );
                    else :
                        show_custom_logo();
                    endif; ?>
                    <div class="cell large-3 footer__sp">
                        <?php get_template_part( 'parts/socials' ); // Social profiles?>
                    </div>
                </div>
            </div>
            <div class="cell large-9 links-col">
                <div class="footer-links-wrap">
                    <div class="footer-contact__links matchHeight">
                        <h6 class="links-title">
                            <?php _e( 'Contact us' ); ?>
                        </h6>
                        <?php if ( $address = get_field( 'address', 'option' ) ) : ?>
                            <div class="footer-contact-info footer-address-info">
                                <address class="contact-link contact-link--address">
                                    <?php echo $address; ?>
                                </address>
                            </div>
                        <?php endif; ?>

                        <?php if ( $phone = get_field( 'phone', 'options' ) ) : ?>
                            <div class="footer-contact-info footer-phone-info">
                                <p class="contact-link contact-link--phone">
                                    <a href="tel:<?php echo sanitize_number( $phone ); ?>"><?php echo $phone; ?></a>
                                </p>
                            </div>

                        <?php endif; ?>

                        <?php if ( $email = get_field( 'email', 'options' ) ) : ?>
                            <div class="footer-contact-info footer-email-info">
                                <p class="contact-link contact-link--email">
                                    <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                                </p>
                            </div>

                        <?php endif; ?>
                    </div>

                    <?php if ( have_rows( 'explore_footer_links', 'options' ) ) : ?>
                        <div class="explore-footer-links footer-links matchHeight">
                            <h6 class="links-title">
                                <?php _e( 'Explore' ); ?>
                            </h6>
                            <?php while ( have_rows( 'explore_footer_links', 'options' ) ) : the_row();
                                $link = get_sub_field( 'link' );
                                ?>
                                <a href="<?php echo $link['url']; ?>">
                                    <?php echo $link['title']; ?>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( have_rows( 'move_to_links', 'options' ) ) : ?>
                        <div class="move-to-footer-links footer-links matchHeight">
                            <h6 class="links-title">
                                <?php _e( 'move to' ); ?>
                            </h6>
                            <?php while ( have_rows( 'move_to_links', 'options' ) ) : the_row();
                                $link = get_sub_field( 'link' );
                                ?>
                                <a href="<?php echo $link['url']; ?>">
                                    <?php echo $link['title']; ?>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( have_rows( 'quick_links', 'options' ) ) : ?>
                        <div class="quick-footer-links footer-links matchHeight">
                            <h6 class="links-title">
                                <?php _e( 'quick links' ); ?>
                            </h6>
                            <?php while ( have_rows( 'quick_links', 'options' ) ) : the_row();
                                $link = get_sub_field( 'link' );
                                ?>
                                <a href="<?php echo $link['url']; ?>">
                                    <?php echo $link['title']; ?>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <?php if ( $copyright = get_field( 'copyright', 'options' ) ) : ?>
        <div class="footer__copy">
            <div class="grid-container">
                <div class="grid-x grid-margin-x">
                    <div class="cell ">
                        <?php echo $copyright; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</footer>
<!-- END of footer -->

<?php wp_footer(); ?>
</body>
</html>
