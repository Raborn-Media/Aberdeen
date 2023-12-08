<!-- BEGIN of Post -->
<article id="post-<?php the_ID(); ?>" <?php post_class( 'preview preview--' . get_post_type() ); ?>>
    <div class="grid-x">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="medium-4 small-12 cell text-center medium-text-left">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php the_post_thumbnail( 'medium', array( 'class' => 'preview__thumb' ) ); ?>
                </a>
            </div>
        <?php endif; ?>
        <div class="cell auto content-col">
            <div class="preview__content">
                <?php $post_id = get_the_ID();

                // Get the terms assigned to the post for the 'activity_types' taxonomy
                $terms = get_the_terms( $post_id, 'activity_types' );

                if ( $terms && ! is_wp_error( $terms ) ) :
                    // Display only the first term
                    $first_term = reset( $terms ); // Get the first term from the array
                    ?>
                    <h5 class="activity-type">
                        <?php echo $first_term->name; ?>
                    </h5>
                <?php endif; ?>
                <h3 class="preview__title">
                    <a href="<?php the_permalink(); ?>"
                       title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'fxy' ), the_title_attribute( 'echo=0' ) ) ); ?>"
                       rel="bookmark"><?php echo get_the_title() ?: __( 'No title', 'fxy' ); ?>
                    </a>
                </h3>
                <?php
                $access_terms   = get_the_terms( $post_id, 'accessibility' );
                $duration_terms = get_the_terms( $post_id, 'duration' ); ?>
                <div class="accessibility">
                    <?php
                    if ( $access_terms && ! is_wp_error( $access_terms ) ) : ?>
                        <?php foreach ( $access_terms as $index => $access_term ) : ?>
                            <p class="accessibility__item small">
                                <?php echo $access_term->name;
                                // Додайте кому, якщо це не останній елемент
                                echo ( $index !== count( $access_terms ) - 1 ) ? ',' : ''; ?>
                            </p>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php
                    if ( $duration_terms && ! is_wp_error( $duration_terms ) ) : ?>
                        <?php foreach ( $duration_terms as $index => $duration_term ) : ?>
                            <p class="accessibility__item small">
                                <?php echo $duration_term->name;
                                // Додайте кому, якщо це не останній елемент
                                echo ( $index !== count( $duration_terms ) - 1 ) ? ',' : ''; ?>
                            </p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if ( is_sticky() ) : ?>
                    <span class="secondary label preview__sticky"><?php _e( 'Sticky', 'fxy' ); ?></span>
                <?php endif; ?>
                <div class="preview__excerpt">
                    <?php // Show more for posts
                    $content = get_extended(get_the_content(''));
                    echo $content['extended'] ? $content['main'] : wp_trim_words( $content['main'], 35 );
                    ?>
                </div>
            </div>
            <div class="preview__buttons">
                <a href="<?php the_permalink(); ?>" class="button--arrow button">
                    <?php _e('Learn more'); ?>
                </a>
                <a href="" class="button--web button">
                    <?php _e('VISIT WEBSITE'); ?>
                </a>
                <a href="" class="button--pin button">
                    <?php _e('GET DIRECTIONS'); ?>
                </a>
            </div>
        </div>
    </div>
</article>
<!-- END of Post -->
