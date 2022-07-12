<?php
/**
 * The template for displaying custom menus
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */



if ( ! function_exists( 'parallax_frame_primary_menu' ) ) :
/**
 * Shows the Primary Menu
 *
 * default load in sidebar-header-right.php
 */
function parallax_frame_primary_menu() {
    $options  = parallax_frame_get_theme_options();

    ?>
	<nav id="site-navigation" class="nav-primary" role="navigation">
    <?php
        echo '<h2 class="screen-reader-text">' . esc_html__( 'Primary Menu', 'parallax-frame' ) . '</h2>';

        wp_nav_menu(
            array(
                'theme_location' => 'primary',
                'menu_class'     => 'menu parallax-frame-nav-menu',
                'container'      => false
            )
        );

        ?>
        <div class="primary-search-icon">
            <div id="search-toggle" class="genericon">
                <a class="screen-reader-text" href="#search-container"><?php esc_html_e( 'Search', 'parallax-frame' ); ?></a>
            </div>

            <div id="search-container" class="displaynone">
                <?php get_search_form(); ?>
            </div>
        </div><!-- .primary-search-icon -->

        <?php

        // Header Right Mobile Menu Anchor
        ?>
        <div id="mobile-header-right-menu" class="mobile-menu-anchor primary-menu">
            <a href="#mobile-header-right-nav" id="header-right-menu" class="genericon genericon-menu">
                <span class="mobile-menu-text"><?php esc_html_e( 'Menu', 'parallax-frame' );?></span>
            </a>
        </div><!-- #mobile-header-menu -->
    </nav><!-- .nav-primary -->
    <?php
}
endif; //parallax_frame_primary_menu


if ( ! function_exists( 'parallax_frame_footer_menu' ) ) :
/**
 * Shows the Footer Menu
 *
 * default load in sidebar-header-right.php
 */
function parallax_frame_footer_menu() {
	if ( has_nav_menu( 'footer' ) ) {
    ?>
	<nav class="nav-footer" role="navigation">
        <div class="wrapper">
            <?php
                $args = array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'menu parallax-frame-nav-menu',
                    'depth'          =>  1
                );
                wp_nav_menu( $args );
            ?>
    	</div><!-- .wrapper -->
    </nav><!-- .nav-footer -->
<?php
    }
}
endif; //parallax_frame_footer_menu
add_action( 'parallax_frame_footer', 'parallax_frame_footer_menu', 40 );


if ( ! function_exists( 'parallax_frame_mobile_menus' ) ) :
/**
 * This function loads Mobile Menus
 *
 * @get the data value from theme options
 * @uses parallax_frame_after action to add the code in the footer
 */
function parallax_frame_mobile_menus() {
    //Getting Ready to load options data
    $menu = wp_nav_menu(
        array(
            'theme_location' => 'primary',
            'container'      => false,
            'items_wrap'     => '<ul id="header-left-nav" class="menu primary">%3$s</ul>',
            'echo'           => false
        )
    );

    //Header Right Menu
    echo '<nav id="mobile-header-right-nav" class="mobile-menu" role="navigation">' . $menu . '</nav><!-- #mobile-header-right-nav -->';
}
endif; //parallax_frame_mobile_menus

add_action( 'parallax_frame_after', 'parallax_frame_mobile_menus', 20 );
