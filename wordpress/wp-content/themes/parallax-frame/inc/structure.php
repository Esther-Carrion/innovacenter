<?php
/**
 * The template for Managing Theme Structure
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */



if ( ! function_exists( 'parallax_frame_doctype' ) ) :
	/**
	 * Doctype Declaration
	 *
	 * @since Parallax Frame 0.1
	 *
	 */
	function parallax_frame_doctype() {
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
		<?php
	}
endif;
add_action( 'parallax_frame_doctype', 'parallax_frame_doctype', 10 );


if ( ! function_exists( 'parallax_frame_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Parallax Frame 0.1
	 *
	 */
	function parallax_frame_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}
endif;
add_action( 'parallax_frame_before_wp_head', 'parallax_frame_head', 10 );


if ( ! function_exists( 'parallax_frame_doctype_start' ) ) :
	/**
	 * Start div id #page
	 *
	 * @since Parallax Frame 0.1
	 *
	 */
	function parallax_frame_page_start() {
		?>
		<div id="page" class="hfeed site">
		<?php
	}
endif;
add_action( 'parallax_frame_header', 'parallax_frame_page_start', 10 );


if ( ! function_exists( 'parallax_frame_page_end' ) ) :
	/**
	 * End div id #page
	 *
	 * @since Parallax Frame 0.1
	 *
	 */
	function parallax_frame_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'parallax_frame_footer', 'parallax_frame_page_end', 100 );


if ( ! function_exists( 'parallax_frame_header_start' ) ) :
	/**
	 * Start Header id #masthead and class .wrapper
	 *
	 * @since Parallax Frame 0.1
	 *
	 */
	function parallax_frame_header_start() {
	?>
		<header id="masthead" class="fixed-header" role="banner">
    		<div class="wrapper">
		<?php
	}
endif;


if ( ! function_exists( 'parallax_frame_site_branding' ) ) :
	/**
	 * Get the logo and display
	 *
	 * @uses get_transient, parallax_frame_get_theme_options, get_header_textcolor, get_bloginfo, set_transient, display_header_text
	 * @get logo from options
	 *
	 * @display logo
	 *
	 * @action
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_site_branding() {
		$options = parallax_frame_get_theme_options();

		$site_logo = '';
		//Checking Logo
		if ( has_custom_logo() ) {
			$site_logo = '<div id="site-logo">'. get_custom_logo() . '</div><!-- #site-logo -->';
		}

		$tagline_class     = '';

		$hide_tagline = $options['hide_tagline'];

		if ( $hide_tagline ) {
			$tagline_class = ' screen-reader-text';
		}

		$header_text = '<div id="site-header">';

		//Set screen-reader-text class if site-header is disabled
		if ( !display_header_text() ) {
			$header_text = '<div id="site-header" class="screen-reader-text">';
		}

		//Add Site Title.
		if ( is_front_page() && is_home() ) {
			$header_text .= '<h1 class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a></h1>';
		} else {
			$header_text .= '<p class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a></p>';
		}

		//Add Tagline
		$header_text .= '<p class="site-description' . $tagline_class . '">' . get_bloginfo( 'description' ) . '</p>';

		//End Site Header
		$header_text .= '</div><!-- #site-header -->';

		$site_branding	= '<div id="site-branding">' . $header_text;

		if ( has_custom_logo() ) {
			$move_title_tagline = $options['move_title_tagline'];

			if ( $move_title_tagline ) {
				$site_branding  = '<div id="site-branding" class="logo-right">' . $header_text . $site_logo;
			}
			else {
				$site_branding  = '<div id="site-branding" class="logo-left">' . $site_logo . $header_text;
			}
		}

		$site_branding 	.= '</div><!-- #site-branding-->';

		echo $site_branding;
	}
endif; // parallax_frame_site_branding


if ( ! function_exists( 'parallax_frame_header_end' ) ) :
	/**
	 * End Header id #masthead and class .wrapper
	 *
	 * @since Parallax Frame 0.1
	 *
	 */
	function parallax_frame_header_end() {
	?>
			</div><!-- .wrapper -->
		</header><!-- #masthead -->
		<?php
	}
endif;


if ( ! function_exists( 'parallax_frame_masthead' ) ) :
	/**
	 * Masthead Content
	 *
	 * @since Parallax Frame 0.1
	 *
	 */
	function parallax_frame_masthead() {
		//Getting Ready to load options data
    	$options = parallax_frame_get_theme_options();

    	add_action( 'parallax_frame_header', 'parallax_frame_header_start', 20 );
		add_action( 'parallax_frame_header', 'parallax_frame_site_branding', 30 );
		add_action( 'parallax_frame_header', 'parallax_frame_primary_menu', 40 );
		add_action( 'parallax_frame_header', 'parallax_frame_header_end', 50 );
	}
endif;
add_action( 'parallax_frame_before', 'parallax_frame_masthead', 10 );


if ( ! function_exists( 'parallax_frame_content_start' ) ) :
	/**
	 * Start div id #content and class .wrapper
	 *
	 * @since Parallax Frame 0.1
	 *
	 */
	function parallax_frame_content_start() {
		?>
		<div id="content" class="site-content">
			<div class="wrapper">
	<?php
	}
endif;
add_action('parallax_frame_content', 'parallax_frame_content_start', 20 );


if ( ! function_exists( 'parallax_frame_content_end' ) ) :
	/**
	 * End div id #content and class .wrapper
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_content_end() {
		?>
			</div><!-- .wrapper -->
	    </div><!-- #content -->
		<?php
	}

endif;
add_action( 'parallax_frame_after_content', 'parallax_frame_content_end', 20 );


if ( ! function_exists( 'parallax_frame_footer_content_start' ) ) :
/**
 * Start footer id #colophon
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_footer_content_start() {
	?>
	<footer id="colophon" class="site-footer" role="contentinfo">
    <?php
}
endif;
add_action('parallax_frame_footer', 'parallax_frame_footer_content_start', 10 );


if ( ! function_exists( 'parallax_frame_footer_sidebar' ) ) :
/**
 * Footer Sidebar
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_footer_sidebar() {
	get_sidebar( 'footer' );
}
endif;
add_action( 'parallax_frame_footer', 'parallax_frame_footer_sidebar', 20 );


if ( ! function_exists( 'parallax_frame_footer_content_end' ) ) :
/**
 * End footer id #colophon
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_footer_content_end() {
	?>
	</footer><!-- #colophon -->
	<?php
}
endif;
add_action( 'parallax_frame_footer', 'parallax_frame_footer_content_end', 90 );
