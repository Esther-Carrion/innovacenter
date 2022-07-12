<?php
/**
 * Functions and definitions
 *
 * Sets up the theme using core parallax-frame-core and provides some helper functions using parallax-frame-custon-functions.
 * Others are attached to action and
 * filter hooks in WordPress to change core functionality
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */

//define theme version
if ( !defined( 'PARALLAXFRAME_THEME_VERSION' ) ) {
	$theme_data = wp_get_theme();

	define ( 'PARALLAXFRAME_THEME_VERSION', $theme_data->get( 'Version' ) );
}

/**
 * Implement the core functions
 */
require trailingslashit( get_template_directory() ) . 'inc/core.php';