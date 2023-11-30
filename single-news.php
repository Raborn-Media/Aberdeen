<?php
/**
 * Single
 *
 * Loop container for single post content
 */
get_header(); ?>
<main class="main-content">
    <div class="grid-container post-container">
        <div class="grid-x ">
            <!-- BEGIN of post content -->
            <div class="small-12 cell">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) :
                        the_post();
                        $post_id = get_the_ID();
                        $terms   = get_the_terms( $post_id, 'news_cat' ); ?>

                        <?php
                        $post_date     = get_the_date( 'M j, Y' );
                        $post_time     = get_the_time( 'h:i A' );
                        $post_timezone = get_the_time( 'T' );
                        ?>
                        <div class="post-date">
                            <?php echo $post_date . ', ' . $post_time . ' ' . $post_timezone; ?>
                        </div>
                        <h3 class="page-title news-title"><?php the_title(); ?></h3>

                        <?php if ( have_rows( 'author_info' ) ): ?>
                        <?php while ( have_rows( 'author_info' ) ): the_row();

                            // Get sub field values.
                            $image           = get_sub_field( 'author_photo' );
                            $author_name     = get_sub_field( 'author_name' );
                            $author_position = get_sub_field( 'author_position' );

                            ?>
                            <div id="author-info">
                                <div class="author-image">
                                    <img src="<?php echo esc_url( $image['url'] ); ?>"
                                         alt="<?php echo esc_attr( $image['alt'] ); ?>"/>
                                </div>
                                <div class="author">
                                    <p><?php echo $author_name; ?></p>
                                    <p><?php echo $author_position; ?></p>
                                </div>
                            </div>
                            <style type="text/css">
                                #hero {
                                    background-color: <?php the_sub_field('color'); ?>;
                                }
                            </style>
                        <?php endwhile; ?>
                    <?php endif; ?>

                        <?php
                        if ( $terms && ! is_wp_error( $terms ) ) : ?>
                            <div class="post-terms">
                                <?php foreach ( $terms as $term ) : ?>
                                    <div class="term">
                                        <?php echo $term->name; ?>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        <?php endif; ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
                            <div class="entry__content clearfix">
                                <?php the_content( '', true ); ?>
                            </div>
                        </article>
                        <?php
                        if ( $terms && ! is_wp_error( $terms ) ) : ?>
                            <div class="post-terms">
                                <?php foreach ( $terms as $term ) : ?>
                                    <div class="term">
                                        <?php echo $term->name; ?>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <!-- END of post content -->
        </div>
    </div>
</main>

<?php get_footer(); ?>
