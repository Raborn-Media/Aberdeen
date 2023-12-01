<?php
$section_icon  = get_sub_field( 'section_icon' );
$section_title = get_sub_field( 'section_title' );
$news_list     = get_sub_field( 'news_list' );
?>

<!-- BEGIN  post-slider-section -->
<section class="post-slider-section flexible-section">
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
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

            <?php
            $args = array(
                'post_type'      => $news_list,
                'order'          => 'ASC',
                // ASC, DESC
                'orderby'        => 'menu_order',
                // none, ID, author, title, name, date, modified, parent, rand, comment_count, menu_order, meta_value, meta_value_num, title menu_order, post__in
                'posts_per_page' => - 1,
            );
            ?>

            <?php $the_query = new WP_Query( $args ); ?>

            <?php if ( $the_query->have_posts() ) : ?>
                <div class="cell">
                    <div class="post-slider">
                        <!-- the loop -->
                        <?php while ( $the_query->have_posts() ) : $the_query->the_post();
                            $post_image = get_the_post_thumbnail();
                            ?>

                            <div class="post-slider__slide">
                                <div class="slide-inner">
                                    <div class="slide-image">
                                        <?php echo $post_image; ?>
                                    </div>
                                    <div class="slide-content">
                                        <h4><?php the_title(); ?></h4>
                                    </div>
                                </div>
                            </div>

                        <?php endwhile; ?>
                        <!-- end of the loop -->
                        <?php wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- END  post-slider-section -->
