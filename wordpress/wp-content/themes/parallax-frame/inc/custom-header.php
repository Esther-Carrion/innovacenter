<?php
/**
 * Implement Custom Header functionality
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */


if ( ! function_exists( 'parallax_frame_custom_header' ) ) :
/**
 * Implementation of the Custom Header feature
 * Setup the WordPress core custom header feature and default custom headers packaged with the theme.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
	function parallax_frame_custom_header() {
		/**
		 * Get Theme Options Values
		 */
		$options 	= parallax_frame_get_theme_options();

		if ( 'light' == $options['color_scheme'] ) {
			$default_header_color = parallax_frame_get_default_theme_options();
			$default_header_color = $default_header_color['header_textcolor'];
		}
		elseif ( 'dark' == $options['color_scheme'] ) {
			$default_header_color = parallax_frame_default_dark_color_options();
			$default_header_color = $default_header_color['header_textcolor'];
		}

		$args = array(
			// Text color and image (empty to use none).
			'default-text-color' => $default_header_color,

			// Header image default
			'default-image'      => trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/slider1-1920x1080.jpg',

			// Set height and width, with a maximum value for the width.
			'height'             => 1080,
			'width'              => 1920,

			// Support flexible height and width.
			'flex-height'        => true,
			'flex-width'         => true,

			// Random image rotation off by default.
			'random-default'     => false,
		);

	$args = apply_filters( 'custom-header', $args );

	// Add support for custom header
	add_theme_support( 'custom-header', $args );

	}
endif; // parallax_frame_custom_header
add_action( 'after_setup_theme', 'parallax_frame_custom_header' );


if ( ! function_exists( 'parallax_frame_featured_page_post_image' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 *
	 * To override this in a child theme
	 * simply create your own parallax_frame_featured_imaage_pagepost(), and that function will be used instead.
	 *
	 * @since Catch Adaptive Pro 1.0
	 */
	function parallax_frame_featured_page_post_image() {
		global $post, $wp_query;

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		$page_for_posts = get_option('page_for_posts');

		$header_page_id = '';

		$image = get_header_image();

		if ( get_post() ) {
			if ( is_home() && $page_for_posts == $page_id ) {
				$header_page_id = $page_id;
			}
			else {
				$header_page_id = $post->ID;
			}
		}

		if ( has_post_thumbnail( $header_page_id ) ) {
			$options             = parallax_frame_get_theme_options();
			$featured_image_size = $options['featured_image_size'];
			$feat_image          = wp_get_attachment_image_src( get_post_thumbnail_id( $header_page_id ), $featured_image_size );

			$image = $feat_image[0];
		}

		return $image;
	} // parallax_frame_featured_page_post_image
endif;


if ( ! function_exists( 'parallax_frame_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own parallax_frame_featured_image(), and that function will be used instead.
	 *
	 * @since Catch Adaptive Pro 1.0
	 */
	function parallax_frame_featured_image() {
		global $post, $wp_query;
		$options             = parallax_frame_get_theme_options();
		$enable_header_image = $options['enable_featured_header_image'];
		$header_image        = get_header_image();
		$image               = false;

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		$page_for_posts = get_option('page_for_posts');

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_page() || is_single() ) {
			//Individual Page/Post Image Setting
			$meta_feat_image = get_post_meta( $post->ID, 'parallax-frame-header-image', true );

			if ( 'disabled' == $meta_feat_image || ( 'default' == $meta_feat_image && 'disabled' == $enable_header_image ) ) {
				return false;
			}
			elseif ( 'enabled' == $meta_feat_image ) {
				$image = parallax_frame_featured_page_post_image();
				return $image;
			}
		}

		// Check Homepage
		if ( 'homepage' == $enable_header_image  ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				$image = $header_image;
			}
		}
		// Check Excluding Homepage
		elseif ( 'exclude-home' == $enable_header_image  ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				return false;
			}
			else {
				$image = $header_image;
			}
		}
		elseif ( 'exclude-home-page-post' == $enable_header_image  ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				return false;
			}
			elseif ( is_page() || is_single() ) {
				$image = parallax_frame_featured_page_post_image();
			}
			else {
				$image = $header_image;
			}
		}
		// Check Entire Site
		elseif ( 'entire-site' == $enable_header_image  ) {
			$image = $header_image;
		}
		// Check Entire Site (Post/Page)
		elseif ( 'entire-site-page-post' == $enable_header_image  ) {
			if ( is_page() || is_single() ) {
				$image = parallax_frame_featured_page_post_image();
			}
			else {
				$image = $header_image;
			}
		}
		// Check Page/Post
		elseif ( 'pages-posts' == $enable_header_image  ) {
			if ( is_page() || is_single() ) {
				$image = parallax_frame_featured_page_post_image();
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}

		return $image;
	} // parallax_frame_featured_image
endif;

if ( ! function_exists( 'parallax_frame_header_div' ) ) :
	/**
	 * Display Featured Header Image div
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_header_div() {
		//Check if header image is active or not
		$header_image = parallax_frame_featured_image();

		if ( $header_image ) {
			global $post;
			$options             = parallax_frame_get_theme_options();
			$title               = $options['featured_header_title'];
			$content             = $options['featured_header_content'];
			$button_text         = $options['featured_header_button_text'];
			$button_link         = $options['featured_header_button_link'];
			$button_target       = $options['featured_header_button_target'];
			$enable_header_image = $options['enable_featured_header_image'];
			$button_target_value = '_self';

			if ( $button_target ) {
				$button_target_value = '_blank';
			}

			if ( $button_target ) {
				$button_target_value = '_blank';
			}

			$classes[] = 'parallax-effect';

			if ( trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/slider1-1920x1080.jpg' == $header_image ) {
				$classes[] = 'default';
			}

			echo '
			<div id="header-featured-image" class="' . esc_attr( implode( ' ', $classes ) ) . '">
				<article class="hentry header-image">
					<div class="entry-container">';
						if ( '' != $title ) {
							echo '
							<header class="entry-header">
								<h2 class="entry-title">
									' . esc_attr( $title ) . '
								</h2>
							</header>';
						}

						if ( '' != $content || '' != $button_text ) {
							echo '
							<div class="entry-content"><p>
								' . $content;

							if ( '' != $button_text ) {
								echo '
								<span class="readmore"><a href="' . esc_url( $button_link ) . '" class="button" target="' . esc_attr( $button_target_value ) . '">'. esc_html( $button_text ) .'</a></span>';
							}
							echo '</p></div>';
						}

					echo '
					</div><!-- .entry-container -->
				</article><!-- .hentry.header-image -->
			</div><!-- #header-featured-image -->';
		}
	} // parallax_frame_header_div
endif;
add_action( 'parallax_frame_after_header', 'parallax_frame_header_div', 10 );


if ( ! function_exists( 'parallax_frame_header_bg_custom_css' ) ) :
	/**
	 * Header Image Background Custom CSS
	 *
	 *
	 * @action wp_enqueue_scripts
	 *
	 * @since Parallax Frame 1.0
	 */
	function parallax_frame_header_bg_custom_css() {
		$header_image = parallax_frame_featured_image();
		$output       = '';

		if ( $header_image && trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/slider1-1920x1080.jpg' != $header_image ) {
			$output = "<!-- " . get_bloginfo('name') . " Header Image Background CSS Styles -->\n<style type='text/css' media='screen'>\n#header-featured-image { background-image: url(\"" . esc_url( $header_image ) . "\"); }\n</style>\n";
		}

		echo $output;
	}
endif; //parallax_frame_header_bg_custom_css
add_action( 'wp_head', 'parallax_frame_header_bg_custom_css', 102 );
