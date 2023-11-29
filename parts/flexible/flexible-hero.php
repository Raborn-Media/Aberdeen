<?php
$hero_image = get_sub_field( 'hero_image' );
?>

<!-- BEGIN  hero-section -->
<section
    class="hero-section <?php echo ! is_page_template( 'page-template-template-contact' ? '' : 'flexible-section' ) ?>" <?php bg( $hero_image['url'], 'full_hd' ); ?>>
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <?php if($hero_title = get_sub_field('hero_title')) : ?>
                    <h1>
                        <?php echo $hero_title; ?>
                    </h1>
                <?php else: ?>
                    <h1>
                        <?php the_title(); ?>
                    </h1>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- END  hero-section -->
