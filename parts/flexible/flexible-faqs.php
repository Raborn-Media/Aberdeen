<?php
$section_icon  = get_sub_field( 'section_icon' );
$section_title = get_sub_field( 'section_title' );
?>

<!-- BEGIN  faq-section -->
<section class="faq-section flexible-section">
    <div class="grid-container section-container">
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
        </div>
        <?php if (have_rows('faqs_list')) : ?>
            <div class="accordion" data-accordion data-allow-all-closed="true" data-scroll>
                <?php while (have_rows('faqs_list')) :
                    the_row();
                    $accordion_title = get_sub_field('faq_title');
                    $accordion_content = get_sub_field('faq_content');
                    $active = get_row_index() == 1 ? 'is-active' : '';
                    ?>
                    <div class="accordion-item <?php echo $active ?>" data-accordion-item>
                        <a class="accordion-title">
                            <?php echo $accordion_title; ?>
                        </a>
                        <div class="accordion-content" data-tab-content>
                            <?php echo $accordion_content; ?>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- END  faq-section -->
