<?php
/**
 * Header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Set up Meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta charset="<?php bloginfo( 'charset' ); ?>">

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
    <!-- Remove Microsoft Edge's & Safari phone-email styling -->
    <meta name="format-detection" content="telephone=no,email=no,url=no">

    <!-- Add external fonts below (GoogleFonts / Typekit) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700&display=swap">
    <link rel="stylesheet" href="https://use.typekit.net/xui2opw.css">
    <?php wp_head(); ?>
</head>

<body <?php body_class( 'no-outline fxy' ); ?>>
<?php wp_body_open(); ?>

<!-- <div class="preloader hide-for-medium">
    <div class="preloader__icon"></div>
</div> -->

<!-- BEGIN of header -->
<header class="header">
    <div class='header-top-bar'>
        <div class='grid-container header-top-bar__container'>
            <div class="header-links" style="display: flex; flex-direction: row; align-items: center; column-gap: 24px; position: relative;">
                <div class="map-link">
                    <a href="/map"><?php _e( 'Map' ); ?></a>
                </div>
                <div class="blog-link">
                    <img src="./assets/images/map.svg" alt="" style="width: 20px; height: 20px; margin-right: 8px; vertical-align: middle; display: inline-block;" />
                    <a href="/blog" style="font-size: 16px; text-transform: uppercase; font-weight: 600; font-family: $font;"><?php _e( 'Blog' ); ?></a>
                </div>
            </div>
            <div class="header-contact-info">
                <?php if ( $phone = get_field( 'phone', 'options' ) ) : ?>
                    <div class="phone-number">
                        <a href="tel:<?php echo sanitize_number( $phone ); ?>">
                            <span><?php _e( 'Phone: ' ); ?></span>
                            <?php echo $phone; ?>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if ( $hours = get_field( 'hours', 'options' ) ) : ?>
                    <p class="hours">
<!--                        --><?php //_e( 'Hours: ' ); ?>
                        <span><?php _e( 'Hours: ' ); ?></span>
                        <?php echo $hours; ?>
                    </p>
                <?php endif; ?>
                <div class="search-form-container">
                    <button class="search-button-show">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <div class="search-form">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-container menu-grid-container">
        <div class="grid-x">
            <div class="medium-4 small-12 cell show-for-large">
                <div class="header-modal-buttons">
                    <button class="explore-button">
                        <span>
                            <?php _e( 'EXPLORE ABERDEEN' ); ?>
                        </span>
                    </button>
                    <button class="move-button">
                        <span>
                            <?php _e( 'MOVE TO ABERDEEN' ); ?>
                        </span>
                    </button>
                </div>
                <div class="header-modals explore-links-modal">
                    <?php if ( have_rows( 'explore_links', 'options' ) ) : ?>
                        <div class="explore-links">
                            <?php while ( have_rows( 'explore_links', 'options' ) ) : the_row();
                                $link_image = get_sub_field( 'link_image' );
                                $link       = get_sub_field( 'link' );
                                ?>
                                <?php if ( $link ) : ?>
                                    <div class="link-wrap">
                                        <a href="<?php echo $link['url']; ?>">
                                            <div class="image">
                                                <?php echo wp_get_attachment_image( $link_image['id'], 'large', false, ['loading' => 'eager'] ); ?>
                                            </div>
                                            <div class="link-title">
                                                <?php echo $link['title']; ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="header-modals move-links-modal">
                    <?php if ( have_rows( 'move_links', 'options' ) ) : ?>
                        <div class="move-links">
                            <?php while ( have_rows( 'move_links', 'options' ) ) : the_row();
                                $link_image = get_sub_field( 'link_image' );
                                $link       = get_sub_field( 'link' );
                                ?>
                                <?php if ( $link ) : ?>
                                    <div class="link-wrap">
                                        <a href="<?php echo $link['url']; ?>">
                                            <div class="image">
                                                <?php echo wp_get_attachment_image( $link_image['id'], 'large', false, ['loading' => 'eager'] ); ?>
                                            </div>
                                            <div class="link-title">
                                                <?php echo $link['title']; ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?>

                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="medium-4 small-6 cell">
                <div class="logo text-center medium-text-left">
                    <h1>
                        <?php show_custom_logo(); ?><span
                            class="show-for-sr"><?php echo get_bloginfo( 'name' ); ?></span>
                    </h1>
                </div>
            </div>
            <div class="large-4 medium-8 small-6 cell">
                <?php if ( has_nav_menu( 'header-menu' ) ) : ?>
                    <div class="title-bar hide-for-large" data-responsive-toggle="main-menu" data-hide-for="large">
                        <button class="menu-icon" type="button" data-toggle aria-label="Menu" aria-controls="main-menu">
                            <span></span></button>
                        <div class="title-bar-title">Menu</div>
                    </div>
                    <nav class="top-bar" id="main-menu">
                        <?php wp_nav_menu( array(
                            'theme_location' => 'header-menu',
                            'menu_class'     => 'menu header-menu',
                            'items_wrap'     => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion large-dropdown" data-submenu-toggle="true" data-multi-open="false" data-close-on-click-inside="false">%3$s</ul>',
                            'walker'         => new theme\FoundationNavigation()
                        ) ); ?>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<div class="fixed-socials">
    <?php get_template_part( 'parts/socials' ); // Social profiles?>
</div>
<!-- END of header -->
