<?php
$section_text = get_sub_field( 'section_text' );
?>

<!-- BEGIN  full-width-sectio -->
<section class="full-width-section flexible-section">
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell">
                <div class="section-text">
                    <?php echo $section_text; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END  full-width-sectio -->
