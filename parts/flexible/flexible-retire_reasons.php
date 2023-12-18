<!-- BEGIN  retire-reasons-section -->
<section class="retire-reasons-section">
    <div class="grid-container">
        <?php if ( have_rows( 'retire_reasons_list' ) ) :
            $i = 1;
            ?>
            <div class="grid-x">
                <div class="cell">
                    <div class="retire-reasons-list">
                        <?php while ( have_rows( 'retire_reasons_list' ) ) : the_row();
                            $reason_title = get_sub_field( 'reason_title' );
                            $reason_image = get_sub_field( 'reason_image' );
                            $reason_text  = get_sub_field( 'reason_text' );
                            ?>
                            <div class="card" <?php echo bg( $reason_image['url'], 'full_hd' ); ?>>
                                <div class="card-inner">
                                    <div class="number">
                                        <?php echo $i; ?>
                                    </div>

                                    <h3>
                                        <?php echo $reason_title; ?>
                                    </h3>
                                </div>
                                <div class="card-modal card-modal-<?php echo $i;?>">
                                    <div class="modal-image">
                                        <?php echo wp_get_attachment_image( $reason_image['id'], 'large' ); ?>
                                    </div>
                                    <div class="modal-comtent">
                                        <div class="content-inner">
                                            <h3>
                                                <?php echo $reason_title; ?>
                                            </h3>
                                            <article>
                                                <?php echo $reason_text; ?>
                                            </article>
                                        </div>
                                        <button class="back">
                                            <?php _e('Back'); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $i ++;
                        endwhile; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- END  retire-reasons-section -->
