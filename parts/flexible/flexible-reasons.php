<!-- BEGIN  reasons-section -->
<section class="reasons-section">
    <div class="grid-container">
        <?php if ( have_rows( 'reasons_list' ) ) : ?>
            <div class="grid-x section-row">
                <?php while ( have_rows( 'reasons_list' ) ) : the_row();
                    $reason_icon  = get_sub_field( 'reason_icon' );
                    $reason_title = get_sub_field( 'reason_title' );
                    $reason_text  = get_sub_field( 'reason_text' );
                    ?>
                    <div class="cell small-12 medium-6 large-3 text-center">
                        <div class="reason">
                            <div class="reason__icon">
                                <div class="icon-wrap">
                                    <?php echo display_svg( $reason_icon ); ?>
                                </div>
                            </div>
                            <h4>
                                <?php echo $reason_title;?>
                            </h4>
                            <article>
                                <?php echo $reason_text;?>
                            </article>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
<!-- END  reasons-section -->
