<?php
$section_image = get_sub_field('section_image');
$section_text = get_sub_field('section_text');
$section_button = get_sub_field('section_button');
$content_position = get_sub_field('content_position');
$aqua_bg = get_sub_field('aqua_bg');
?>

<!-- BEGIN  relocate-section -->
<section class="relocate-section flexible-section <?php echo $aqua_bg ? 'aqua-bg' : '';?>">
    <div class="grid-container">
        <div class="grid-x section-row <?php echo $content_position ? 'section-row__reverce' : ''; ?>">
            <div class="cell large-6">
                <div class="section-image">
                    <?php echo wp_get_attachment_image( $section_image['id'], 'large', false, ['class' => ''] ); ?>
                </div>
            </div>
            <div class="cell large-6">
                <?php if($section_text) : ?>
                    <article class="section-text">
                        <?php echo $section_text;?>
                        <?php if($section_button) : ?>
                            <a href="<?php echo $section_button['url']?>" class="button button--arrow">
                                <?php echo $section_button['title'];?>
                            </a>
                        <?php endif; ?>
                    </article>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- END  relocate-section -->
