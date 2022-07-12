<?php
/**
 * Core functions and definitions
 *
 * Sets up the theme
 *
 * The first function, parallax_frame_initial_setup(), sets up the theme by registering support
 * for various features in WordPress, such as theme support, post thumbnails, navigation menu, and the like.
 *
 * Parallax Frame functions and definitions
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */


if ( ! function_exists( 'parallax_frame_content_width' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 */
	function parallax_frame_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'parallax_frame_content_width', 860 );
	}
endif;
add_action( 'after_setup_theme', 'parallax_frame_content_width', 0 );


if ( ! function_exists( 'parallax_frame_template_redirect' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet for different value other than the default one
	 *
	 * @global int $content_width
	 */
	function parallax_frame_template_redirect() {
	    $layout = parallax_frame_get_theme_layout();

	    if ( 'no-sidebar-full-width' == $layout ) {
			$GLOBALS['content_width'] = 1200;
		}
	}
endif;
add_action( 'template_redirect', 'parallax_frame_template_redirect' );


if ( ! function_exists( 'parallax_frame_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 */
	function parallax_frame_setup() {
		/**
		 * Get Theme Options Values
		 */
		$options = parallax_frame_get_theme_options();
		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 * If you're building a theme based on parallaxframe, use a find and replace
		 * to change 'parallax-frame' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'parallax-frame', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails on posts and pages
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// used in Header Highlight small image, Post Thumbnail Ratio 4:3
		set_post_thumbnail_size( 400, 300, true );

		// Used for Featured Slider Ratio 16:9
        add_image_size( 'parallax-frame-slider', 1920, 1080, true);

        //Used For Archive Landescape Ratio 16:9
    	add_image_size( 'parallax-frame-featured', 860, 484, true);

		// Used for Featured Content, portfolio, hero content
    	add_image_size( 'parallax-frame-featured-content', 480, 320, true); // used in Featured Content Options Ratio 16:9

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			'primary'      => esc_html__( 'Primary Menu', 'parallax-frame' ),
			'footer'       => esc_html__( 'Footer Menu', 'parallax-frame' ),
		) );

		/**
		 * Enable support for Post Formats
		 */
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

		/**
		 * Setup the WordPress core custom background feature.
		 */
		$default_bg_color = parallax_frame_get_default_theme_options();

		if ( 'dark' == $options['color_scheme'] ) {
			$default_bg_color = parallax_frame_default_dark_color_options();
		}

		add_theme_support( 'custom-background', apply_filters( 'parallax_frame_custom_background_args', array(
			'default-color' => $default_bg_color['background_color'],
		) ) );

		/**
		 * Setup Editor style
		 */
		add_editor_style( 'css/editor-style.css' );

		/**
		 * Setup title support for theme
		 * Supported from WordPress version 4.1 onwards
		 * More Info: https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
		 */
		add_theme_support( 'title-tag' );

		/**
		* Setup Custom Logo Support for theme
		* Supported from WordPress version 4.5 onwards
		* More Info: https://make.wordpress.org/core/2016/03/10/custom-logo/
		*/
		add_theme_support( 'custom-logo' );

		/**
		 * Setup Infinite Scroll using JetPack if navigation type is set
		 */
		$pagination_type = $options['pagination_type'];

		if ( 'infinite-scroll-click' == $pagination_type ) {
			add_theme_support( 'infinite-scroll', array(
				'type'		=> 'click',
				'container' => 'main',
				'footer'    => 'page'
			) );
		}
		elseif ( 'infinite-scroll-scroll' == $pagination_type ) {
			//Override infinite scroll disable scroll option
        	update_option('infinite_scroll', true);

			add_theme_support( 'infinite-scroll', array(
				'type'		=> 'scroll',
				'container' => 'main',
				'footer'    => 'page'
			) );
		}
	}
endif; // parallax_frame_setup
add_action( 'after_setup_theme', 'parallax_frame_setup' );

/**
 * Register Google fonts.
 *
 */
function parallax_frame_fonts_url() {
	$font_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Open Sans, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$open_sans = _x( 'on', 'Open Sans: on or off', 'parallax-frame' );

	if ( 'off' !== $open_sans ) {
		$font_family = 'Open Sans';
		$query_args = array(
			'family' => urlencode( $font_family ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$font_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $font_url );
}

/**
 * Enqueue scripts and styles
 *
 * @uses  wp_register_script, wp_enqueue_script, wp_register_style, wp_enqueue_style, wp_localize_script
 * @action wp_enqueue_scripts
 *
 * @since  Parallax Frame 0.1
 */
function parallax_frame_scripts() {
	$options = parallax_frame_get_theme_options();

	$fonts_url = parallax_frame_fonts_url();
	if ( '' != $fonts_url ) {
		//Enqueue Google fonts
		wp_register_style( 'parallax-frame-fonts', $fonts_url, array(), '1.0.0' );

		$styles_deps[] = 'parallax-frame-fonts';
	}

	wp_enqueue_style( 'parallax-frame-style', get_stylesheet_uri(), $styles_deps, PARALLAXFRAME_THEME_VERSION );

	wp_enqueue_script( 'parallax-frame-navigation', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/navigation.min.js', array(), PARALLAXFRAME_THEME_VERSION, true );

	wp_enqueue_script( 'parallax-frame-skip-link-focus-fix', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/skip-link-focus-fix.min.js', array(), PARALLAXFRAME_THEME_VERSION, true );

	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	//For genericons
	wp_enqueue_style( 'genericons', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/genericons/genericons.css', false, '3.4.1' );

	/**
	 * Enqueue the styles for the current color scheme for parallaxframe.
	 */
	if ( 'dark' == $options['color_scheme'] ) {
		wp_enqueue_style( 'parallax-frame-dark', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/colors/dark.css', array(), null );
	}

	//Responsive Menu
	wp_enqueue_script( 'jquery-sidr', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/jquery.sidr.min.js', array('jquery'), '2.2.1.1', false );

	wp_enqueue_script( 'jquery-fitvids', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/fitvids.min.js', array( 'jquery' ), '1.1', true );

	/**
	 * Loads default sidr color scheme styles(Does not require handle prefix)
	 */
	wp_enqueue_style( 'jquery-sidr', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/jquery.sidr.'. $options['color_scheme'] .'.min.css', false, '2.1.0' );


	/**
	 * Loads up Cycle JS
	 */
	if ( 'disabled' != $options['featured_slider_option'] || $options['featured_content_slider'] || 'disabled' != $options['logo_slider_option']  ) {
		wp_register_script( 'jquery-cycle2', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/jquery.cycle/jquery.cycle2.min.js', array( 'jquery' ), '2.1.5', true );

		wp_enqueue_script( 'jquery-cycle2' );
	}

	/**
	 * Loads up Scroll Up script
	 */
	if ( !$options['disable_scrollup'] ) {
		wp_enqueue_script( 'parallax-frame-scrollup', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/scrollup.min.js', array( 'jquery' ), PARALLAXFRAME_THEME_VERSION, true  );
	}

	/**
	 * Enqueue custom script for parallax-frame.
	 */
	wp_enqueue_script( 'parallax-frame-custom-scripts', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/custom-scripts.min.js', array( 'jquery' ), null );

	wp_enqueue_style( 'parallax-frame-ie9', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/html5.min.js', array( 'parallax-frame-style' ) );
	wp_style_add_data( 'parallax-frame-ie9', 'conditional', 'lte IE 9' );
}
add_action( 'wp_enqueue_scripts', 'parallax_frame_scripts' );

/**
 * Returns the options array for parallaxframe.
 * @uses  get_theme_mod
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_get_theme_options() {
	$parallax_frame_default_options = parallax_frame_get_default_theme_options();

	return array_merge( $parallax_frame_default_options , get_theme_mod( 'parallax_frame_theme_options', $parallax_frame_default_options ) ) ;
}

/**
 * Flush out all transients
 *
 * @uses delete_transient
 *
 * @action customize_save, parallax_frame_customize_preview (see parallax_frame_customizer function: parallax_frame_customize_preview)
 *
 * @since  Parallax Frame 0.1
 */
function parallax_frame_flush_transients(){
	delete_transient( 'parallax_frame_header_highlight_content' );
	delete_transient( 'parallax_frame_featured_slider' );
	delete_transient( 'parallax_frame_hero_content' );
	delete_transient( 'parallax_frame_featured_content' );
	delete_transient( 'parallax_frame_portfolio' );
	delete_transient( 'parallax_frame_logo_slider' );
	delete_transient( 'parallax_frame_custom_css' );
	delete_transient( 'parallax_frame_promotion_headline' );
	delete_transient( 'parallax_frame_social_icons' );
	delete_transient( 'parallax_frame_scrollup' );
	delete_transient( 'all_the_cool_cats' );
	delete_transient( 'parallax_frame_footer_content' );


	//Add Parallax Frame default themes if there i
	if ( !get_theme_mod('parallax_frame_theme_options') ) {
		set_theme_mod( 'parallax_frame_theme_options', parallax_frame_get_default_theme_options() );
	}
}
add_action( 'customize_save', 'parallax_frame_flush_transients' );

/**
 * Flush out category transients
 *
 * @uses delete_transient
 *
 * @action edit_category
 *
 * @since  Parallax Frame 0.1
 */
function parallax_frame_flush_category_transients(){
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'parallax_frame_flush_category_transients' );

/**
 * Flush out post related transients
 *
 * @uses delete_transient
 *
 * @action save_post
 *
 * @since  Parallax Frame 0.1
 */
function parallax_frame_flush_post_transients(){
	delete_transient( 'parallax_frame_header_highlight_content' );
	delete_transient( 'parallax_frame_featured_slider' );
	delete_transient( 'parallax_frame_hero_content' );
	delete_transient( 'parallax_frame_featured_content' );
	delete_transient( 'parallax_frame_portfolio' );
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'save_post', 'parallax_frame_flush_post_transients' );


if ( ! function_exists( 'parallax_frame_custom_css' ) ) :
	/**
	 * Enqueue Custon CSS
	 *
	 * @uses  set_transient, wp_head, wp_enqueue_style
	 *
	 * @action wp_enqueue_scripts
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_custom_css() {
		//parallax_frame_flush_transients();
		$options       = parallax_frame_get_theme_options();
		$defaults      = parallax_frame_get_default_theme_options();
		$defaults_temp = $defaults;
		if ( !$output = get_transient( 'parallax_frame_custom_css' ) ) {
			$output ='';

			//Change values of default colors if the scheme is dark
			if ( 'dark' == $options['color_scheme'] ) {
				$defaults = parallax_frame_default_dark_color_options();
			}

			$text_color = get_header_textcolor();

			if (  get_theme_support( 'custom-header', 'default-text-color' ) !== '#' . $text_color ) {
				$output .=  ".site-title a, .site-description { color: #".  $text_color ."; }". "\n";
			}

			$defaults = $defaults_temp;

			//Footer Background
			if ( '' == $options['footer_sidebar_area_background_image'] ) {
				$output .= "#supplementary { background-image: none; }" . "\n";
			}
			elseif ( $defaults['footer_sidebar_area_background_image'] != $options['footer_sidebar_area_background_image'] ) {
				$output .= "#supplementary { background-image: url(\"". esc_url( $options['footer_sidebar_area_background_image'] ) ."\"); }" . "\n";
			}

			// Featured Content Background Image Options
			if ( $defaults['featured_content_background_image'] != $options['featured_content_background_image'] || $defaults['featured_content_background_display_position'] != $options['featured_content_background_display_position'] || $defaults['featured_content_background_repeat'] != $options['featured_content_background_repeat'] || $defaults['featured_content_background_attachment'] != $options['featured_content_background_attachment'] ) {

				$output .= "#featured-content {". "\n";
				if ( $defaults['featured_content_background_image'] != $options['featured_content_background_image'] ) {
					$output	.=  "background-image: url(\"". esc_url( $options['featured_content_background_image'] ) ."\");". "\n";
				}

				if ( $defaults['featured_content_background_display_position'] != $options['featured_content_background_display_position'] ) {
					$output	.=  "background-position: center ". $options['featured_content_background_display_position'] .";". "\n";
				}

				if ( $defaults['featured_content_background_repeat'] != $options['featured_content_background_repeat'] ) {
					$output	.=  "background-repeat: ". $options['featured_content_background_repeat'] . ";\n";
					$output	.=  "background-size: inherit;\n";
				}

				if ( $defaults['featured_content_background_attachment'] != $options['featured_content_background_attachment'] ) {
					$output	.=  "background-attachment: ". $options['featured_content_background_attachment'] ."\n";
				}
				$output .= "}";
			}

			//Logo Slider Background
			if ( '' == $options['logo_slider_bg'] ) {
				$output .= "#logo-slider { background-image: none; }" . "\n";
			}
			elseif ( $defaults['logo_slider_bg'] != $options['logo_slider_bg'] ) {
				$output .= "#logo-slider { background-image: url(\"". esc_url( $options['logo_slider_bg'] ) ."\"); }" . "\n";
			}

			//Custom CSS Option
			if ( !empty( $options['custom_css'] ) ) {
				$output	.=  $options[ 'custom_css'] . "\n";
			}

			if ( '' != $output ){
				echo '<!-- refreshing cache -->' . "\n";

				$output = '<!-- '.get_bloginfo('name').' inline CSS Styles -->' . "\n" . '<style type="text/css" media="screen">' . "\n" . $output;

				$output .= '</style>' . "\n";

			}

			set_transient( 'parallax_frame_custom_css', htmlspecialchars_decode( $output ), 86940 );
		}

		echo $output;
	}
endif; //parallax_frame_custom_css
add_action( 'wp_head', 'parallax_frame_custom_css', 101  );

/**
 * Alter the query for the main loop in homepage
 *
 * @action pre_get_posts
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_alter_home( $query ) {
	if ( $query->is_main_query() && $query->is_home() ) {
		$options 	= parallax_frame_get_theme_options();

	    $cats 		= $options['front_page_category'];

	    if ( is_array( $cats ) && !in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] =  $cats;
		}
	}
}
add_action( 'pre_get_posts','parallax_frame_alter_home' );


if ( ! function_exists( 'parallax_frame_content_nav' ) ) :
	/**
	 * Display navigation to next/previous pages when applicable
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_content_nav( $nav_id ) {
		global $wp_query, $post;

		// Don't print empty markup on single pages if there's nowhere to navigate.
		if ( is_single() ) {
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
			$next = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous )
				return;
		}

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}

		$options			= parallax_frame_get_theme_options();

		$pagination_type	= $options['pagination_type'];

		$nav_class = ( is_single() ) ? 'site-navigation post-navigation' : 'site-navigation paging-navigation';

		/**
		 * Check if navigation type is Jetpack Infinite Scroll and if it is enabled, else goto default pagination
		 * if it's active then disable pagination
		 */
		if ( ( 'infinite-scroll-click' == $pagination_type || 'infinite-scroll-scroll' == $pagination_type ) && class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
			return false;
		}

		?>

		<div class="main-pagination clear">
			<?php
				/**
				 * Check if navigation type is numeric and if Wp-PageNavi Plugin is enabled
				 */
				if ( 'numeric' == $pagination_type && function_exists( 'wp_pagenavi' ) ) {
					echo '<nav id="nav-below" class="navigation pagination-pagenavi" role="navigation">';
						wp_pagenavi();
					echo '</nav><!-- .pagination-pagenavi -->';
	            }
	            elseif ( 'numeric' == $pagination_type && function_exists( 'the_posts_pagination' ) ) {
					// Previous/next page navigation.
					the_posts_pagination( array(
						'prev_text'          => esc_html__( 'Previous', 'parallax-frame' ),
						'next_text'          => esc_html__( 'Next', 'parallax-frame' ),
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'parallax-frame' ) . ' </span>',
					) );
				}
	            else {
					the_posts_navigation();
	            }
	        ?>
		</div><!-- .main-pagination -->

		<?php
	}
endif; // parallax_frame_content_nav


if ( ! function_exists( 'parallax_frame_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_comment( $comment, $args, $depth ) {
		if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php esc_html_e( 'Pingback:', 'parallax-frame' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'parallax-frame' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		<?php else : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
						<?php printf( __( '%s <span class="says">says:</span>', 'parallax-frame' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</div><!-- .comment-author -->

					<div class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'parallax-frame' ), get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php edit_comment_link( esc_html__( 'Edit', 'parallax-frame' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'parallax-frame' ); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->

				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

				<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="reply">',
						'after'     => '</div>',
					) ) );
				?>
			</article><!-- .comment-body -->

		<?php
		endif;
	}
endif; // parallax_frame_comment()


if ( ! function_exists( 'parallax_frame_the_attached_image' ) ) :
	/**
	 * Prints the attached image with a link to the next attached image.
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_the_attached_image() {
		$post                = get_post();
		$attachment_size     = apply_filters( 'parallax_frame_attachment_size', array( 1200, 1200 ) );
		$next_attachment_url = wp_get_attachment_url();

		/**
		 * Grab the IDs of all the image attachments in a gallery so we can get the
		 * URL of the next adjacent image in a gallery, or the first image (if
		 * we're looking at the last image in a gallery), or, in a gallery of one,
		 * just the link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => 1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID'
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id )
				$next_attachment_url = get_attachment_link( $next_id );

			// or get the URL of the first image attachment.
			else
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}

		printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
			esc_url( $next_attachment_url ),
			the_title_attribute( 'echo=0' ),
			wp_get_attachment_image( $post->ID, $attachment_size )
		);
	}
endif; //parallax_frame_the_attached_image


if ( ! function_exists( 'parallax_frame_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_entry_meta() {
		echo '<p class="entry-meta">';

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		printf( '<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
			sprintf( __( '<span class="screen-reader-text">Posted on</span>',  'parallax-frame' ) ),
			esc_url( get_permalink() ),
			$time_string
		);

		if ( is_singular() || is_multi_author() ) {
			printf( '<span class="byline"><span class="author vcard">%1$s<a class="url fn n" href="%2$s">%3$s</a></span></span>',
				sprintf( _x( '<span class="screen-reader-text">Author</span>', 'Used before post author name.', 'parallax-frame' ) ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_html( get_the_author() )
			);
		}

		if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'parallax-frame' ), esc_html__( '1 Comment', 'parallax-frame' ), esc_html__( '% Comments', 'parallax-frame' ) );
			echo '</span>';
		}

		edit_post_link( esc_html__( 'Edit', 'parallax-frame' ), '<span class="edit-link">', '</span>' );

		echo '</p><!-- .entry-meta -->';
	}
endif; //parallax_frame_entry_meta


if ( ! function_exists( 'parallax_frame_tag_category' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags.
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_tag_category() {
		echo '<p class="entry-meta">';

		if ( 'post' == get_post_type() ) {
			$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'parallax-frame' ) );
			if ( $categories_list && parallax_frame_categorized_blog() ) {
				printf( '<span class="cat-links">%1$s%2$s</span>',
					sprintf( _x( '<span class="screen-reader-text">Categories</span>', 'Used before category names.', 'parallax-frame' ) ),
					$categories_list
				);
			}

			$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'parallax-frame' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">%1$s%2$s</span>',
					sprintf( _x( '<span class="screen-reader-text">Tags</span>', 'Used before tag names.', 'parallax-frame' ) ),
					$tags_list
				);
			}
		}

		echo '</p><!-- .entry-meta -->';
	}
endif; //parallax_frame_tag_category

/**
 * Returns true if a blog has more than 1 category
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so parallax_frame_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so parallax_frame_categorized_blog should return false
		return false;
	}
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'parallax_frame_page_menu_args' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'parallax_frame_enhanced_image_navigation', 10, 2 );

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'footer-1' ) )
		$count++;

	if ( is_active_sidebar( 'footer-2' ) )
		$count++;

	if ( is_active_sidebar( 'footer-3' ) )
		$count++;

	if ( is_active_sidebar( 'footer-4' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}


if ( ! function_exists( 'parallax_frame_excerpt_length' ) ) :
	/**
	 * Sets the post excerpt length to n words.
	 *
	 * function tied to the excerpt_length filter hook.
	 * @uses filter excerpt_length
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_excerpt_length( $length ) {
		// Getting data from Customizer Options
		$options	= parallax_frame_get_theme_options();
		$length	= $options['excerpt_length'];
		return $length;
	}
endif; //parallax_frame_excerpt_length
add_filter( 'excerpt_length', 'parallax_frame_excerpt_length' );


if ( ! function_exists( 'parallax_frame_continue_reading' ) ) :
	/**
	 * Returns a "Custom Continue Reading" link for excerpts
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_continue_reading() {
		// Getting data from Customizer Options
		$options		=	parallax_frame_get_theme_options();
		$more_tag_text	= $options['excerpt_more_text'];

		return ' <span class="readmore"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . $more_tag_text . '</a></span>';
	}
endif; //parallax_frame_continue_reading
add_filter( 'excerpt_more', 'parallax_frame_continue_reading' );


if ( ! function_exists( 'parallax_frame_excerpt_more' ) ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with parallax_frame_continue_reading().
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_excerpt_more( $more ) {
		return parallax_frame_continue_reading();
	}
endif; //parallax_frame_excerpt_more
add_filter( 'excerpt_more', 'parallax_frame_excerpt_more' );


if ( ! function_exists( 'parallax_frame_custom_excerpt' ) ) :
	/**
	 * Adds Continue Reading link to more tag excerpts.
	 *
	 * function tied to the get_the_excerpt filter hook.
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_custom_excerpt( $output ) {
		if ( has_excerpt() && ! is_attachment() ) {
			$output .= parallax_frame_continue_reading();
		}
		return $output;
	}
endif; //parallax_frame_custom_excerpt
add_filter( 'get_the_excerpt', 'parallax_frame_custom_excerpt' );


if ( ! function_exists( 'parallax_frame_more_link' ) ) :
	/**
	 * Replacing Continue Reading link to the_content more.
	 *
	 * function tied to the the_content_more_link filter hook.
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_more_link( $more_link, $more_link_text ) {
	 	$options		=	parallax_frame_get_theme_options();
		$more_tag_text	= $options['excerpt_more_text'];

		return str_replace( $more_link_text, $more_tag_text, $more_link );
	}
endif; //parallax_frame_more_link
add_filter( 'the_content_more_link', 'parallax_frame_more_link', 10, 2 );


if ( ! function_exists( 'parallax_frame_body_classes' ) ) :
	/**
	 * Adds Parallax Frame layout classes to the array of body classes.
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_body_classes( $classes ) {
		global $wp_query;

		// Adds a class of group-blog to blogs with more than 1 published author
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		$options = parallax_frame_get_theme_options();

		$layout = parallax_frame_get_theme_layout();

		switch ( $layout ) {
			case 'left-sidebar':
				$classes[] = 'two-columns content-right';
			break;

			case 'right-sidebar':
				$classes[] = 'two-columns content-left';
			break;

			case 'no-sidebar':
				$classes[] = 'no-sidebar content-width';
			break;

			case 'no-sidebar-full-width':
				$classes[] = 'no-sidebar full-width';
			break;
		}

		$current_content_layout = $options['content_layout'];
		if ( "" != $current_content_layout ) {
			$classes[] = $current_content_layout;
		}

		$page_id        = $wp_query->get_queried_object_id();
		$page_for_posts = get_option('page_for_posts');

		//Check if header highlight content is inactive
		$enable_header_highlight   = $options['featured_slider_option'];
		$header_highlight_disabled = true;

		if ( 'entire-site' == $enable_header_highlight || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_header_highlight ) ) {
			$header_highlight_disabled = false;
		}

		//Check if slider is inactive
		$enable_slider   = $options['featured_slider_option'];
		$slider_disabled = true;

		if ( 'entire-site' == $enable_slider || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_slider ) ) {
			$slider_disabled = false;
		}

		//Check if header image is enabled
		$header_image_disabled = !parallax_frame_featured_image();

		if ( $header_highlight_disabled && $slider_disabled && $header_image_disabled ) {
			//Add class if all header highlight content, slider and header image is  disabled
			$classes[] = 'header-bg';
		}

		$classes[] = 'mobile-menu-one';

		$classes[] = 'primary-search-enabled';

		$classes 	= apply_filters( 'parallax_frame_body_classes', $classes );

		return $classes;
	}
endif; //parallax_frame_body_classes
add_filter( 'body_class', 'parallax_frame_body_classes' );


if ( ! function_exists( 'parallax_frame_post_classes' ) ) :
	/**
	 * Adds Parallax Frame post classes to the array of post classes.
	 * used for supporting different content layouts
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_post_classes( $classes ) {
		//Getting Ready to load data from Theme Options Panel
		$options 		= parallax_frame_get_theme_options();

		$contentlayout = $options['content_layout'];

		if ( is_archive() || is_home() ) {
			$classes[] = $contentlayout;
		}

		return $classes;
	}
endif; //parallax_frame_post_classes
add_filter( 'post_class', 'parallax_frame_post_classes' );


if ( ! function_exists( 'parallax_frame_get_theme_layout' ) ) :
	/**
	 * Returns Theme Layout prioritizing the meta box layouts
	 *
	 * @uses  get_theme_mod
	 *
	 * @action wp_head
	 *
	 * @since Parallax Frame 3.5
	 */
	function parallax_frame_get_theme_layout() {
		$id = '';

	    global $post, $wp_query;

		// Front page displays in Reading Settings
		$page_on_front  = get_option('page_on_front') ;
		$page_for_posts = get_option('page_for_posts');

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		// Blog Page or Front Page setting in Reading Settings
		if ( $page_id == $page_for_posts || $page_id == $page_on_front ) {
	        $id = $page_id;
	    }
	    elseif ( is_singular() ) {
	 		if ( is_attachment() ) {
				$id = $post->post_parent;
			}
			else {
				$id = $post->ID;
			}
		}

		//Get appropriate metabox value of layout
		if ( '' != $id ) {
			$layout = get_post_meta( $id, 'parallax-frame-layout-option', true );
		}
		else {
			$layout = 'default';
		}

		//Load options data
		$options = parallax_frame_get_theme_options();

		//check empty and load default
		if ( empty( $layout ) || 'default' == $layout ) {
			$layout = $options['theme_layout'];
		}

		return $layout;
	}
endif; //parallax_frame_get_theme_layout


if ( ! function_exists( 'parallax_frame_archive_content_image' ) ) :
	/**
	 * Template for Featured Image in Archive Content
	 *
	 * To override this in a child theme
	 * simply create your own parallax_frame_archive_content_image(), and that function will be used instead.
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_archive_content_image() {
		$options 			= parallax_frame_get_theme_options();

		$featured_image = $options['content_layout'];

		if ( has_post_thumbnail() && 'full-content' != $featured_image ) { ?>
			<figure class="featured-image">
	            <a rel="bookmark" href="<?php the_permalink(); ?>">
	                <?php
						if ( 'excerpt-image-left' == $featured_image  || 'excerpt-image-right' == $featured_image  ) {
		                     the_post_thumbnail( 'post-thumbnail' );
		                }
		                elseif ( 'excerpt-image-top' == $featured_image  ) {
		                     the_post_thumbnail( 'parallax-frame-featured' );
		                }
		               	elseif ( 'excerpt-full-image' == $featured_image  ) {
		                     the_post_thumbnail( 'full' );
		                }
					?>
				</a>
	        </figure>
	   	<?php
		}
	}
endif; //parallax_frame_archive_content_image
add_action( 'parallax_frame_before_entry_container', 'parallax_frame_archive_content_image', 10 );


if ( ! function_exists( 'parallax_frame_single_content_image' ) ) :
	/**
	 * Template for Featured Image in Single Post
	 *
	 * To override this in a child theme
	 * simply create your own parallax_frame_single_content_image(), and that function will be used instead.
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_single_content_image() {
		global $post, $wp_query;

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		if ( $post) {
	 		if ( is_attachment() ) {
				$parent = $post->post_parent;
				$metabox_feat_img = get_post_meta( $parent,'parallax-frame-featured-image', true );
			} else {
				$metabox_feat_img = get_post_meta( $page_id,'parallax-frame-featured-image', true );
			}
		}

		if ( empty( $metabox_feat_img ) || ( !is_page() && !is_single() ) ) {
			$metabox_feat_img = 'default';
		}

		// Getting data from Theme Options
	   	$options = parallax_frame_get_theme_options();

		$featured_image = $options['single_post_image_layout'];

		if ( ( 'disabled' == $metabox_feat_img  || '' == get_the_post_thumbnail() || ( $metabox_feat_img=='default' && 'disabled' == $featured_image ) ) ) {
			echo '<!-- Page/Post Single Image Disabled or No Image set in Post Thumbnail -->';
			return false;
		}
		else {
			$class = '';

			if ( 'default' == $metabox_feat_img ) {
				$class = $featured_image;
			}
			else {
				$class = 'from-metabox ' . $metabox_feat_img;
				$featured_image = $metabox_feat_img;
			}

			?>
			<figure class="featured-image <?php echo esc_attr( $class ); ?>">
                <?php the_post_thumbnail( $featured_image ); ?>
	        </figure>
	   	<?php
		}
	}
endif; //parallax_frame_single_content_image
add_action( 'parallax_frame_before_post_container', 'parallax_frame_single_content_image', 10 );
add_action( 'parallax_frame_before_page_container', 'parallax_frame_single_content_image', 10 );


if ( ! function_exists( 'parallax_frame_get_comment_section' ) ) :
	/**
	 * Comment Section
	 *
	 * @display comments_template
	 * @action parallax_frame_comment_section
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_get_comment_section() {
		if ( comments_open() || '0' != get_comments_number() ) {
			comments_template();
		}
}
endif;
add_action( 'parallax_frame_comment_section', 'parallax_frame_get_comment_section', 10 );


if ( ! function_exists( 'parallax_frame_promotion_headline' ) ) :
	/**
	 * Template for Promotion Headline
	 *
	 * To override this in a child theme
	 * simply create your own parallax_frame_promotion_headline(), and that function will be used instead.
	 *
	 * @uses parallax_frame_before_main action to add it in the header
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_promotion_headline() {
		//delete_transient( 'parallax_frame_promotion_headline' );

		global $post, $wp_query;
	   	$options 	= parallax_frame_get_theme_options();

		$promotion_headline        = $options['promotion_headline'];
		$promotion_subheadline     = $options['promotion_subheadline'];
		$promotion_headline_button = $options['promotion_headline_button'];
		$promotion_headline_target = $options['promotion_headline_target'];
		$enablepromotion           = $options['promotion_headline_option'];
		$promotion_headline_url    = $options['promotion_headline_url'];

		// Front page displays in Reading Settings
		$page_on_front = get_option( 'page_on_front' ) ;
		$page_for_posts = get_option('page_for_posts');

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		 if ( ( "" != $promotion_headline || "" != $promotion_subheadline || "" != $promotion_headline_url ) && ( 'entire-site' == $enablepromotion  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enablepromotion  ) ) ) {

			if ( !$parallax_frame_promotion_headline = get_transient( 'parallax_frame_promotion_headline' ) ) {

				echo '<!-- refreshing cache -->';

				$parallax_frame_promotion_headline = '
				<div id="promotion-message">
					<div class="wrapper">
						<div class="section left">';

						if ( "" != $promotion_headline ) {
							$parallax_frame_promotion_headline .= '<h2 class="section-title">' . $promotion_headline . '</h2>';
						}

						if ( "" != $promotion_subheadline ) {
							$parallax_frame_promotion_headline .= '<p>' . $promotion_subheadline . '</p>';
						}

						$parallax_frame_promotion_headline .= '
						</div><!-- .section.left -->';

						if ( "" != $promotion_headline_url ) {
							if ( "1" == $promotion_headline_target ) {
								$headlinetarget = '_blank';
							}
							else {
								$headlinetarget = '_self';
							}

							$parallax_frame_promotion_headline .= '
							<div class="section right">
								<a href="' . esc_url( $promotion_headline_url ) . '" target="' . $headlinetarget . '">' . esc_html( $promotion_headline_button ) . '
								</a>
							</div><!-- .section.right -->';
						}

				$parallax_frame_promotion_headline .= '
					</div><!-- .wrapper -->
				</div><!-- #promotion-message -->';

				set_transient( 'parallax_frame_promotion_headline', $parallax_frame_promotion_headline, 86940 );
			}
			echo $parallax_frame_promotion_headline;
		 }
	}
endif; // parallax_frame_promotion_featured_content
add_action( 'parallax_frame_before_content', 'parallax_frame_promotion_headline', 60 );

/**
 * Footer Text
 *
 * @get footer text from theme options and display them accordingly
 * @display footer_text
 * @action parallax_frame_footer
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_footer_content() {
	//parallax_frame_flush_transients();
	if ( ( !$output = get_transient( 'parallax_frame_footer_content' ) ) ) {
		echo '<!-- refreshing cache -->';

		$parallax_frame_content = parallax_frame_get_content();

		$output =  '
    	<div id="site-generator" class="two">
    		<div class="wrapper">
    			<div id="footer-left-content" class="copyright">' . $parallax_frame_content['top'] . '</div>

    			<div id="footer-right-content" class="powered">' . $parallax_frame_content['bottom'] . '</div>
			</div><!-- .wrapper -->
		</div><!-- #site-generator -->';

	    set_transient( 'parallax_frame_footer_content', $output, 86940 );
    }

    echo $output;
}
add_action( 'parallax_frame_footer', 'parallax_frame_footer_content', 50 );

/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since Parallax Frame 0.1
 */

function parallax_frame_get_first_image( $postID, $size, $attr ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field('post_content', $postID ) , $matches);

	if ( isset( $matches [1] [0] ) ) {
		//Get first image
		$first_img = $matches [1] [0];

		return '<img class="pngfix wp-post-image" src="'. $first_img .'">';
	}

	return false;
}


if ( ! function_exists( 'parallax_frame_scrollup' ) ) {
	/**
	 * This function loads Scroll Up Navigation
	 *
	 * @action parallax_frame_footer action
	 * @uses set_transient and delete_transient
	 */
	function parallax_frame_scrollup() {
		//parallax_frame_flush_transients();
		if ( !$parallax_frame_scrollup = get_transient( 'parallax_frame_scrollup' ) ) {

			// get the data value from theme options
			$options = parallax_frame_get_theme_options();
			echo '<!-- refreshing cache -->';

			//site stats, analytics header code
			if ( ! $options['disable_scrollup'] ) {
				$parallax_frame_scrollup =  '<a href="#masthead" id="scrollup" class="genericon"><span class="screen-reader-text">' . esc_html__( 'Scroll Up', 'parallax-frame' ) . '</span></a>' ;
			}

			set_transient( 'parallax_frame_scrollup', $parallax_frame_scrollup, 86940 );
		}
		echo $parallax_frame_scrollup;
	}
}
add_action( 'parallax_frame_after', 'parallax_frame_scrollup', 10 );


if ( ! function_exists( 'parallax_frame_page_post_meta' ) ) :
	/**
	 * Post/Page Meta for Google Structure Data
	 */
	function parallax_frame_page_post_meta() {
		$parallax_frame_author_url = esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) );

		$parallax_frame_page_post_meta = '<span class="post-time">' . esc_html__( 'Posted on', 'parallax-frame' ) . ' <time class="entry-date updated" datetime="' . esc_attr( get_the_date( 'c' ) ) . '" pubdate>' . esc_html( get_the_date() ) . '</time></span>';
	    $parallax_frame_page_post_meta .= '<span class="post-author">' . esc_html__( 'By', 'parallax-frame' ) . ' <span class="author vcard"><a class="url fn n" href="' . $parallax_frame_author_url . '" title="View all posts by ' . get_the_author() . '" rel="author">' .get_the_author() . '</a></span>';

		return $parallax_frame_page_post_meta;
	}
endif; //parallax_frame_page_post_meta


if ( ! function_exists( 'parallax_frame_truncate_phrase' ) ) :
	/**
	 * Return a phrase shortened in length to a maximum number of characters.
	 *
	 * Result will be truncated at the last white space in the original string. In this function the word separator is a
	 * single space. Other white space characters (like newlines and tabs) are ignored.
	 *
	 * If the first `$max_characters` of the string does not contain a space character, an empty string will be returned.
	 *
	 * @since 2.4.1
	 *
	 * @param string $text            A string to be shortened.
	 * @param integer $max_characters The maximum number of characters to return.
	 *
	 * @return string Truncated string
	 */
	function parallax_frame_truncate_phrase( $text, $max_characters ) {

		$text = trim( $text );

		if ( mb_strlen( $text ) > $max_characters ) {
			//* Truncate $text to $max_characters + 1
			$text = mb_substr( $text, 0, $max_characters + 1 );

			//* Truncate to the last space in the truncated string
			$text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
		}

		return $text;
	}
endif; //parallax_frame_truncate_phrase


if ( ! function_exists( 'parallax_frame_get_the_content_limit' ) ) :
	/**
	 * Return content stripped down and limited content.
	 *
	 * Strips out tags and shortcodes, limits the output to `$max_char` characters, and appends an ellipsis and more link to the end.
	 *
	 * @since 2.4.1
	 *
	 * @param integer $max_characters The maximum number of characters to return.
	 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)".
	 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
	 *
	 * @return string Limited content.
	 */
	function parallax_frame_get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

		$content = get_the_content( '', $stripteaser );

		//* Strip tags and shortcodes so the content truncation count is done correctly
		$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

		//* Remove inline styles / scripts
		$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

		//* Truncate $content to $max_char
		$content = parallax_frame_truncate_phrase( $content, $max_characters );

		//* More link?
		if ( $more_link_text ) {
			$link   = apply_filters( 'get_the_content_more_link', sprintf( '<span class="readmore"></span><a href="%s" class="more-link">%s</a></span>', esc_url ( get_permalink() ), $more_link_text ), $more_link_text );
			$output = sprintf( '<p>%s %s</p>', $content, $link );
		} else {
			$output = sprintf( '<p>%s</p>', $content );
			$link = '';
		}

		return apply_filters( 'parallax_frame_get_the_content_limit', $output, $content, $link, $max_characters );

	}
endif; //parallax_frame_get_the_content_limit


if ( ! function_exists( 'parallax_frame_post_navigation' ) ) :
	/**
	 * Displays Single post Navigation
	 *
	 * @uses  the_post_navigation
	 *
	 * @action parallax_frame_after_post
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_post_navigation() {
		$options	= parallax_frame_get_theme_options();

		$disable_single_post_navigation = isset($options['disable_single_post_navigation']) ? $options['disable_single_post_navigation'] : 0;

		if ( !$disable_single_post_navigation ) {
			// Previous/next post navigation.
			the_post_navigation( array(
				'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Next &rarr;', 'parallax-frame' ) . '</span> ' .
					'<span class="screen-reader-text">' . esc_html__( 'Next post:', 'parallax-frame' ) . '</span> ' .
					'<span class="post-title">%title</span>',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( '&larr; Previous', 'parallax-frame' ) . '</span> ' .
					'<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'parallax-frame' ) . '</span> ' .
					'<span class="post-title">%title</span>',
			) );
		}
	}
endif; //parallax_frame_post_navigation
add_action( 'parallax_frame_after_post', 'parallax_frame_post_navigation', 10 );

/**
 * Display Multiple Select type for and array of categories
 *
 * @param  [string] $name  [field name]
 * @param  [string] $id    [field_id]
 * @param  [array] $selected    [selected values]
 * @param  string $label [label of the field]
 */
function parallax_frame_dropdown_categories( $name, $id, $selected, $label = '' ) {
	$dropdown = wp_dropdown_categories(
		array(
			'name'             => $name,
			'echo'             => 0,
			'hide_empty'       => false,
			'show_option_none' => false,
			'hierarchical'       => 1,
		)
	);

	if ( '' != $label ) {
		echo '<label for="' . $id . '">
			'. $label .'
			</label>';
	}

	$dropdown = str_replace('<select', '<select multiple = "multiple" style = "height:120px; width: 100%" ', $dropdown );

	foreach( $selected as $selected ) {
		$dropdown = str_replace( 'value="'. $selected .'"', 'value="'. $selected .'" selected="selected"', $dropdown );
	}

	echo $dropdown;

	echo '<span class="description">'. esc_html__( 'Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.', 'parallax-frame' ) . '</span>';
}

/**
 * Return registered image sizes.
 *
 * Return a two-dimensional array of just the additionally registered image sizes, with width, height and crop sub-keys.
 *
 * @since 0.1.7
 *
 * @global array $_wp_additional_image_sizes Additionally registered image sizes.
 *
 * @return array Two-dimensional, with width, height and crop sub-keys.
 */
function parallax_frame_get_additional_image_sizes() {
	global $_wp_additional_image_sizes;

	if ( $_wp_additional_image_sizes )
		return $_wp_additional_image_sizes;

	return array();
}

if ( ! function_exists( 'parallax_frame_get_meta' ) ) :
	/**
	 * Returns HTML with meta information for the categories, tags, date and author.
	 *
	 * @param [boolean] $hide_category Adds screen-reader-text class to category meta if true
	 * @param [boolean] $hide_tags Adds screen-reader-text class to tag meta if true
	 * @param [boolean] $hide_posted_by Adds screen-reader-text class to date meta if true
	 * @param [boolean] $hide_author Adds screen-reader-text class to author meta if true
	 *
	 * @since Parallax Frame 0.1
	 */
	function parallax_frame_get_meta( $hide_category = false, $hide_tags = false, $hide_posted_by = false, $hide_author = false ) {
		$output = '<p class="entry-meta">';

		if ( 'post' == get_post_type() ) {

			$class = $hide_category ? 'screen-reader-text' : '';

			$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'parallax-frame' ) );
			if ( $categories_list && parallax_frame_categorized_blog() ) {
				$output .= sprintf( '<span class="cat-links ' . $class . '">%1$s%2$s</span>',
					sprintf( _x( '<span class="screen-reader-text">Categories</span>', 'Used before category names.', 'parallax-frame' ) ),
					$categories_list
				);
			}

			$class = $hide_tags ? 'screen-reader-text' : '';

			$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'parallax-frame' ) );
			if ( $tags_list ) {
				$output .= sprintf( '<span class="tags-links ' . $class . '">%1$s%2$s</span>',
					sprintf( _x( '<span class="screen-reader-text">Tags</span>', 'Used before tag names.', 'parallax-frame' ) ),
					$tags_list
				);
			}

			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

			$class = $hide_posted_by ? 'screen-reader-text' : '';

			$output .= sprintf( '<span class="posted-on ' . $class . '">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
				sprintf( _x( '<span class="screen-reader-text">Posted on</span>', 'Used before publish date.', 'parallax-frame' ) ),
				esc_url( get_permalink() ),
				$time_string
			);

			if ( is_singular() || is_multi_author() ) {
				$class = $hide_author ? 'screen-reader-text' : '';

				$output .= sprintf( '<span class="byline ' . $class . '"><span class="author vcard">%1$s<a class="url fn n" href="%2$s">%3$s</a></span></span>',
					sprintf( _x( '<span class="screen-reader-text">Author</span>', 'Used before post author name.', 'parallax-frame' ) ),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_html( get_the_author() )
				);
			}
		}

		$output .= '</p><!-- .entry-meta -->';

		return $output;
	}
endif; //parallax_frame_get_meta

/**
 * Migrate Custom CSS to WordPress core Custom CSS
 *
 * Runs if version number saved in theme_mod "custom_css_version" doesn't match current theme version.
 */
function parallax_frame_custom_css_migrate(){
	$ver = get_theme_mod( 'custom_css_version', false );

	// Return if update has already been run
	if ( version_compare( $ver, '4.7' ) >= 0 ) {
		return;
	}

	if ( function_exists( 'wp_update_custom_css_post' ) ) {
	    // Migrate any existing theme CSS to the core option added in WordPress 4.7.

	    /**
		 * Get Theme Options Values
		 */
	    $options = parallax_frame_get_theme_options();

	    if ( '' != $options['custom_css'] ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return   = wp_update_custom_css_post( $core_css . $options['custom_css'] );
	        if ( ! is_wp_error( $return ) ) {
	            // Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
	            unset( $options['custom_css'] );
	            set_theme_mod( 'parallax_frame_theme_options', $options );

	            // Update to match custom_css_version so that script is not executed continously
				set_theme_mod( 'custom_css_version', '4.7' );
	        }
	    }
	}
}
add_action( 'after_setup_theme', 'parallax_frame_custom_css_migrate' );

if ( ! function_exists( 'parallax_frame_blocks_support' ) ) :
	/**
	 * Create add default blocks support
	 */
	function parallax_frame_blocks_support() {
		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => esc_html__( 'Small', 'parallax-frame' ),
					'shortName' => esc_html__( 'S', 'parallax-frame' ),
					'size'      => 14,
					'slug'      => 'small',
				),
				array(
					'name'      => esc_html__( 'Normal', 'parallax-frame' ),
					'shortName' => esc_html__( 'M', 'parallax-frame' ),
					'size'      => 18,
					'slug'      => 'normal',
				),
				array(
					'name'      => esc_html__( 'Large', 'parallax-frame' ),
					'shortName' => esc_html__( 'L', 'parallax-frame' ),
					'size'      => 42,
					'slug'      => 'large',
				),
				array(
					'name'      => esc_html__( 'Huge', 'parallax-frame' ),
					'shortName' => esc_html__( 'XL', 'parallax-frame' ),
					'size'      => 54,
					'slug'      => 'huge',
				),
			)
		);

		// Add support for custom color scheme.
		add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => esc_html__( 'White', 'parallax-frame' ),
				'slug'  => 'white',
				'color' => '#ffffff',
			),
			array(
				'name'  => esc_html__( 'Black', 'parallax-frame' ),
				'slug'  => 'black',
				'color' => '#111111',
			),
			array(
				'name'  => esc_html__( 'Gray', 'parallax-frame' ),
				'slug'  => 'gray',
				'color' => '#f4f4f4',
			),
			array(
				'name'  => esc_html__( 'Blue', 'parallax-frame' ),
				'slug'  => 'blue',
				'color' => '00aeef',
			),
			array(
				'name'  => esc_html__( 'Orange', 'parallax-frame' ),
				'slug'  => 'orange',
				'color' => '#ffc300',
			),
			array(
				'name'  => esc_html__( 'Light Red', 'parallax-frame' ),
				'slug'  => 'light-red',
				'color' => '#e8554e',
			),
		) );
	}
	add_action( 'after_setup_theme', 'parallax_frame_blocks_support', 20 );
endif; //parallax_frame_blocks_support

if ( ! function_exists( 'parallax_frame_add_blocks_style' ) ) :
	/**
	 * Add Blocks Style
	 */
	function parallax_frame_add_blocks_style() {
		// Theme block stylesheet.
		wp_enqueue_style( 'parallax-frame-block-style', get_theme_file_uri( '/css/blocks.css' ), array( 'parallax-frame-style' ), date( 'Ymd-Gis', filemtime( get_template_directory() . '/css/blocks.css' ) ) );
	}
	add_action( 'wp_enqueue_scripts', 'parallax_frame_add_blocks_style' );
endif; //parallax_frame_add_blocks_style

if ( ! function_exists( 'parallax_frame_block_editor_styles' ) ) :
	/**
	 * Enqueue editor styles for Blocks
	 */
	function parallax_frame_block_editor_styles() {
		// Block styles.
		wp_enqueue_style( 'parallax-frame-block-editor-style', get_theme_file_uri( '/css/editor-blocks.css' ), null, date( 'Ymd-Gis', filemtime( get_template_directory() . '/css/editor-blocks.css' ) ) );

		// Add custom fonts.
		wp_enqueue_style( 'parallax-frame-fonts', parallax_frame_fonts_url(), array(), null );
	}
	add_action( 'enqueue_block_editor_assets', 'parallax_frame_block_editor_styles' );
endif; //parallax_frame_block_editor_styles

/**
 * Default Options.
 */
require trailingslashit( get_template_directory() ) . 'inc/default-options.php';

/**
 * Custom Header.
 */
require trailingslashit( get_template_directory() ) . 'inc/custom-header.php';

/**
 * Structure for parallaxframe
 */
require trailingslashit( get_template_directory() ) . 'inc/structure.php';

/**
 * Customizer additions.
 */
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/customizer.php';

/**
 * Custom Menus
 */
require trailingslashit( get_template_directory() ) . 'inc/menus.php';

/**
 * Load Header Highlight Content file.
 */
require trailingslashit( get_template_directory() ) . 'inc/header-highlight-content.php';

/**
 * Load Slider file.
 */
require trailingslashit( get_template_directory() ) . 'inc/featured-slider.php';

/**
 * Load Hero Content.
 */
require trailingslashit( get_template_directory() ) . 'inc/hero-content.php';

/**
 * Load Featured Content.
 */
require trailingslashit( get_template_directory() ) . 'inc/featured-content.php';

/**
 * Load Portfolio.
 */
require trailingslashit( get_template_directory() ) . 'inc/portfolio.php';

/**
 * Load Logo Slider file.
 */
require trailingslashit( get_template_directory() ) . 'inc/logo-slider.php';

/**
 * Load Breadcrumb file.
 */
require trailingslashit( get_template_directory() ) . 'inc/breadcrumb.php';

/**
 * Load Widgets and Sidebars
 */
require trailingslashit( get_template_directory() ) . 'inc/widgets/widgets.php';

/**
 * Load Social Icons
 */
require trailingslashit( get_template_directory() ) . 'inc/social-icons.php';

/**
 * Load Metaboxes
 */
require trailingslashit( get_template_directory() ) . 'inc/metabox.php';

/**
 * Load JSON_LD Breadcrumb file.
 */
require trailingslashit( get_template_directory() ) . 'inc/json-ld-schema.php';
