<?php
$section_top_image_title = get_sub_field('section_top_image_title');
?>

<!-- BEGIN  page-links-section -->
<section class="page-links-section flexible-section">
    <div class="grid-container fluid">
        <div class="grid-x">
            <div class="cell text-center">
                <?php if ($section_top_image_title) : ?>
                    <div class="section-top-image-title">
                        <?php echo wp_get_attachment_image($section_top_image_title['id'], 'large'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (have_rows('page_links')) : ?>
            <div class="grid-x">
                <?php while (have_rows('page_links')) :
                    the_row();
                    $page_link_image = get_sub_field('page_link_image');
                    $link            = get_sub_field('link');
                    ?>
                    <div class="cell large-4">
                        <div class="page-link" <?php echo bg($page_link_image['url'], 'full_hd'); ?>>
                            <h3 class="page-link__title">
                                <?php echo $link['title']; ?>
                            </h3>
                            <a href="<?php echo $link['title']; ?>" class="button">
                                <svg width="46" height="34" viewBox="0 0 46 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.717773 14.5991H39.3071V19.5777H0.717773V14.5991Z" fill="#3F4966"/>
                                    <path d="M28.6033 33.7695L25.1162 30.2824L38.3131 17.0879L25.1162 3.89335L28.6033 0.40625L45.2826 17.0879L28.6033 33.7695Z" fill="#3F4966"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- END  page-links-section -->
