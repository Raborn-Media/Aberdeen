<?php
/**
 * Template Name: Contact Page
 */

get_header(); ?>
<?php if ($top_content_row = get_field('top_content_row')) : ?>
    <div class="top-content-row text-center">
        <p>
            <?php echo $top_content_row; ?>
        </p>
    </div>
<?php endif; ?>
<?php if (have_rows('flexible')) : ?>
    <?php while (have_rows('flexible')) :
        the_row();
        $layout = get_row_layout(); ?>
        <?php get_template_part('parts/flexible/flexible', $layout);
        ?>
    <?php endwhile; ?>
<?php endif; ?>
<section class="contact">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) :
            the_post(); ?>
            <article id="<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="grid-container">
                    <div class="grid-x grid-margin-x">
                        <div class="cell medium-6">
                            <h3 class="page-title"><?php _e('GET IN TOUCH'); ?></h3>
                            <div class="contact__links">
                                <?php if ($address = get_field('address', 'option')) : ?>
                                    <div class="contact-info address-info">
                                        <h4>
                                            <?php _e('Address'); ?>
                                        </h4>
                                        <address class="contact-link contact-link--address">
                                            <?php echo $address; ?>
                                        </address>
                                    </div>
                                <?php endif; ?>

                                <?php if ($phone = get_field('phone', 'options')) : ?>
                                    <div class="contact-info phone-info">
                                        <h4>
                                            <?php _e('Telephone'); ?>
                                        </h4>
                                        <p class="contact-link contact-link--phone">
                                            <a href="tel:<?php echo sanitize_number($phone); ?>"><?php echo $phone; ?></a>
                                        </p>
                                    </div>

                                <?php endif; ?>

                                <?php if ($email = get_field('email', 'options')) : ?>
                                    <div class="contact-info email-info">
                                        <h4>
                                            <?php _e('Email'); ?>
                                        </h4>
                                        <p class="contact-link contact-link--email">
                                            <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                                        </p>
                                    </div>

                                <?php endif; ?>
                            </div>
                        </div>
                        <?php $contact_form = get_field('contact_form'); ?>
                        <?php if (class_exists('GFAPI') && ! empty($contact_form) && is_array($contact_form)) : ?>
                            <div class="cell medium-6">
                                <div class="contact__form">
                                    <?php echo do_shortcode("[gravityform id='{$contact_form['id']}' title='false' description='false' ajax='true']"); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>
</section>

<?php get_footer(); ?>
