<?php
$feed = get_sub_field( 'feed' );
?>

<!-- BEGIN  instagram-feed-section -->
<section class="instagram-feed-section flexible-section">
    <div class="grid-container">
        <div class="grod-x">
            <div class="cell">
                <?php if ( $feed ) : ?>
                    <article>
                        <?php echo $feed; ?>
                    </article>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- END  instagram-feed-section -->
