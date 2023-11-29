<?php
$top_award_image = get_sub_field('top_award_image');
$top_awarded_by  = get_sub_field('top_awarded_by');
$section_button  = get_sub_field('section_button');
?>

<!-- BEGIN  awards-section -->
<section class="awards-section flexible-section">
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <div class="top-award">
                    <?php if ($top_award_image) : ?>
                        <div class="top-award-image">
                            <?php echo wp_get_attachment_image($top_award_image['id'], 'large'); ?>
                        </div>
                    <?php endif; ?>
                    <p class="awarded-by">
                        <?php _e('Awarded by'); ?>
                    </p>
                    <?php if ($top_awarded_by) : ?>
                        <div class="top-awarded-by">
                            <?php echo wp_get_attachment_image($top_awarded_by['id'], 'large'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (have_rows('awards_list')) : ?>
            <div class="grid-x">
                <div class="cell">
                    <div class="awards-list">
                        <?php while (have_rows('awards_list')) :
                            the_row();
                            $award_year = get_sub_field('award_year');
                            $award_title = get_sub_field('award_title');
                            $award_number = get_sub_field('award_number');
                            ?>
                            <div class="award text-center">
                                <article>
                                    <p class="award-number">
                                        #<?php echo $award_number; ?>
                                    </p>
                                    <p class="award-title">
                                        <?php echo $award_title; ?>
                                    </p>
                                    <p class="award-year">
                                        <?php echo $award_year; ?>
                                    </p>
                                </article>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (have_rows('bottom_awarded_by')) : ?>
            <div class="grid-x">
                <div class="cell">
                    <div class="bottom-awarded-by">
                        <?php while (have_rows('bottom_awarded_by')) :
                            the_row();
                            $awarded_by_text  = get_sub_field('awarded_by_text');
                            $awarded_by_image = get_sub_field('awarded_by_image');
                            ?>
                            <div class="bottom-awarded-by__item text-center">
                                <p class="awarded-by">
                                    <?php echo $awarded_by_text; ?>
                                </p>
                                <?php if ($awarded_by_image) : ?>
                                    <div class="top-awarded-by">
                                        <?php echo wp_get_attachment_image($awarded_by_image['id'], 'large'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($section_button) : ?>
            <div class="grid-x">
                <div class="cell text-center">
                    <a href="<?php echo $section_button['URL']; ?>" class="button button--arrow">
                        <?php echo $section_button['title']; ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- END  awards-section -->
