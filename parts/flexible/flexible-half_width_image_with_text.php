<?php
$image_position        = get_sub_field( 'image_position' );
$section_image        = get_sub_field( 'section_image' );
$section_text         = get_sub_field( 'section_text' );
$section_button       = get_sub_field( 'section_button' );
$section_top_image = get_sub_field( 'section_top_image' );
$section_bottom_image = get_sub_field( 'section_bottom_image' );
$bottom_image         = get_sub_field( 'bottom_image' );
$top_image         = get_sub_field( 'top_image' );
?>

<!-- BEGIN  half-image-w-text-section -->
<section class="half-image-w-text-section flexible-section">
    <div class="grid-container section-container">
        <div class="grid-x section-row <?php echo $image_position ? 'section-row__reverce' : '' ?>">
            <div class="cell large-6">
                <div class="section-image <?php echo $section_bottom_image ? 'with-bottom-image' : ''; ?>">
                    <?php echo wp_get_attachment_image( $section_image['id'], 'full_hd', false, ['class' => 'main-image'] ); ?>
                    <?php if ( $section_bottom_image == true ) :
                        echo wp_get_attachment_image( $bottom_image['id'], 'full_hd', false, ['class' => 'bottom-image'] );
                    endif; ?>

                    <?php if ( $section_top_image == true ) :
                        echo wp_get_attachment_image( $top_image['id'], 'full_hd', false, ['class' => 'top-image'] );
                    endif; ?>
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
<!-- END  half-image-w-text-section -->
