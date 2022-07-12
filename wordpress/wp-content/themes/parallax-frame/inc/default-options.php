<?php
/**
 * Implement Default Theme/Customizer Options
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */


/**
 * Returns the default options for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_get_default_theme_options() {
	$theme_data = wp_get_theme();

	$default_theme_options = array(
		//Site Title an Tagline
		'hide_tagline'                                     => 1,
		'move_title_tagline'                               => 0,

		//Layout
		'theme_layout'                                     => 'right-sidebar',
		'content_layout'                                   => 'excerpt-image-left',
		'single_post_image_layout'                         => 'disabled',

		//Header Image
		'enable_featured_header_image'                     => 'exclude-home-page-post',
		'featured_image_size'                              => 'full',
		'featured_header_title'                            => esc_html( get_bloginfo( 'name') ),
		'featured_header_content'                          => esc_html( get_bloginfo( 'description' ) ),
		'featured_header_button_text'                      => esc_html__( 'View More', 'parallax-frame' ),
		'featured_header_button_link'                      => '#',
		'featured_header_button_target'                    => 0,

		//Breadcrumb Options
		'breadcumb_option'                                 => 0,
		'breadcumb_on_homepage'                            => 0,
		'breadcumb_seperator'                              => '&raquo;',

		//Custom CSS
		'custom_css'                                       => '',

		//Scrollup Options
		'disable_scrollup'                                 => 0,

		//Excerpt Options
		'excerpt_length'                                   => '40',
		'excerpt_more_text'                                => esc_html__( 'Read More ...', 'parallax-frame' ),

		//Homepage / Frontpage Settings
		'front_page_category'                              => '0',

		//Pagination Options
		'pagination_type'                                  => 'default',

		//Promotion Headline Options
		'promotion_headline_option'                        => 'homepage',
		'promotion_headline'                               => esc_html__( 'Parallax Frame WordPress Theme', 'parallax-frame' ),
		'promotion_subheadline'                            => esc_html__( 'This is promotion headline. You can edit this from Appearance -> Customize -> Theme Options -> Promotion Headline Options', 'parallax-frame' ),
		'promotion_headline_button'                        => esc_html__( 'Buy Now', 'parallax-frame' ),
		'promotion_headline_url'                           => '#',
		'promotion_headline_target'                        => 1,

		//Search Options
		'search_text'                                      => esc_html__( 'Search...', 'parallax-frame' ),

		//Single Post Navigation
		'disable_single_post_navigation'                   => 0,

		//Basic Color Options
		'color_scheme'                                     => 'light',
		'background_color'                                 => '#ffffff',
		'header_textcolor'                                 => '#ffffff',

		//Footer Sidebar area bg
		'footer_sidebar_area_background_image'			   => '',

		//Header Highlight Content Options
		'header_highlight_content_option'                  => 'disabled',
		'header_highlight_content_type'                    => 'demo-header-highlight-content',
		'header_highlight_content_headline'                => '',
		'header_highlight_content_subheadline'             => '',
		'header_highlight_content_number'                  => '5',
		'header_highlight_content_show'                    => 'hide-content',
		'header_highlight_content_hide_category'           => 0,
		'header_highlight_content_hide_tags'               => 1,
		'header_highlight_content_hide_author'             => 1,
		'header_highlight_content_hide_date'               => 0,

		//Featured Slider Options
		'featured_slider_option'                           => 'disabled',
		'featured_slider_image_loader'                     => 'true',
		'featured_slider_transition_delay'                 => '4',
		'featured_slider_transition_length'                => '1',
		'featured_slider_type'                             => 'demo-featured-slider',
		'featured_slider_number'                           => '4',

		//Hero Content Options
		'hero_content_option'                              => 'disabled',
		'hero_content_type'                                => 'demo-hero-content',
		'hero_content_number'                              => '1',
		'hero_content_enable_title'                        => 1,
		'hero_content_show'                                => 'excerpt',
		'disable_read_more'                                => 0,

		//Featured Content Options
		'featured_content_option'                          => 'disabled',
		'featured_content_layout'                          => 'layout-three',
		'featured_content_position'                        => 0,
		'featured_content_slider'                          => 1,
		'featured_content_headline'                        => '',
		'featured_content_subheadline'                     => '',
		'featured_content_type'                            => 'demo-featured-content',
		'featured_content_number'                          => '4',
		'featured_content_enable_title'                    => 1,
		'featured_content_show'                            => 'hide-content',

		'featured_content_background_image'                => '',
		'featured_content_background_display_position'     => 'bottom',
		'featured_content_background_repeat'               => 'no-repeat',
		'featured_content_background_attachment'           => 'fixed',

		//Portfolio
		'portfolio_option'                                 => 'disabled',
		'portfolio_layout'                                 => 'layout-four',
		'portfolio_position'                               => 0,
		'portfolio_slider'                                 => 1,
		'portfolio_headline'                               => '',
		'portfolio_subheadline'                            => '',
		'portfolio_type'                                   => 'demo-portfolio',
		'portfolio_number'                                 => '4',
		'portfolio_enable_title'                           => 1,
		'portfolio_hide_category'                          => 0,
		'portfolio_hide_tags'                              => 1,
		'portfolio_hide_author'                            => 1,
		'portfolio_hide_date'                              => 0,

		//Logo Slider
		'logo_slider_option'                               => 'disabled',
		'logo_slider_type'                                 => 'demo',
		'logo_slider_visible_items'                        => '4',
		'logo_slider_transition_delay'                     => '4',
		'logo_slider_transition_length'                    => '1',
		'logo_slider_title'                                => '',
		'logo_slider_number'                               => '5',
		'logo_slider_bg'                                   => '',

		//Reset all settings
		'reset_all_settings'                               => 0,
	);

	return apply_filters( 'parallax_frame_default_theme_options', $default_theme_options );
}



/**
 * Returns an array of color schemes registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_color_schemes() {
	$options = array(
		'light' => array(
			'value' 				=> 'light',
			'label' 				=> esc_html__( 'Light', 'parallax-frame' ),
		),
		'dark' => array(
			'value' 				=> 'dark',
			'label' 				=> esc_html__( 'Dark', 'parallax-frame' ),
		),
	);

	return apply_filters( 'parallax_frame_color_schemes', $options );
}


/**
 * Returns an array of layout options registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_layouts() {
	$options = array(
		'left-sidebar' 	=> array(
			'value' => 'left-sidebar',
			'label' => esc_html__( 'Primary Sidebar, Content', 'parallax-frame' ),
		),
		'right-sidebar' => array(
			'value' => 'right-sidebar',
			'label' => esc_html__( 'Content, Primary Sidebar', 'parallax-frame' ),
		),
		'no-sidebar'	=> array(
			'value' => 'no-sidebar',
			'label' => esc_html__( 'No Sidebar ( Content Width )', 'parallax-frame' ),
		),
	);
	return apply_filters( 'parallax_frame_layouts', $options );
}


/**
 * Returns an array of content layout options registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_get_archive_content_layout() {
	$options = array(
		'excerpt-image-left' => array(
			'value' => 'excerpt-image-left',
			'label' => esc_html__( 'Show Excerpt (Image Left)', 'parallax-frame' ),
		),
		'full-content' => array(
			'value' => 'full-content',
			'label' => esc_html__( 'Show Full Content (No Featured Image)', 'parallax-frame' ),
		),
	);
	return apply_filters( 'parallax_frame_get_archive_content_layout', $options );
}


/**
 * Returns an array of feature header enable options
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_enable_featured_header_image_options() {
	$options = array(
		'homepage' 		=> array(
			'value'	=> 'homepage',
			'label' => esc_html__( 'Homepage / Frontpage', 'parallax-frame' ),
		),
		'exclude-home' 		=> array(
			'value'	=> 'exclude-home',
			'label' => esc_html__( 'Excluding Homepage', 'parallax-frame' ),
		),
		'exclude-home-page-post' 	=> array(
			'value' => 'exclude-home-page-post',
			'label' => esc_html__( 'Excluding Homepage, Page/Post Featured Image', 'parallax-frame' ),
		),
		'entire-site' 	=> array(
			'value' => 'entire-site',
			'label' => esc_html__( 'Entire Site', 'parallax-frame' ),
		),
		'entire-site-page-post' 	=> array(
			'value' => 'entire-site-page-post',
			'label' => esc_html__( 'Entire Site, Page/Post Featured Image', 'parallax-frame' ),
		),
		'pages-posts' 	=> array(
			'value' => 'pages-posts',
			'label' => esc_html__( 'Pages and Posts', 'parallax-frame' ),
		),
		'disabled'		=> array(
			'value' => 'disabled',
			'label' => esc_html__( 'Disabled', 'parallax-frame' ),
		),
	);

	return apply_filters( 'parallax_frame_enable_featured_header_image_options', $options );
}


/**
 * Returns an array of feature image size
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_featured_image_size_options() {
	$all_sizes = parallax_frame_get_additional_image_sizes();

	foreach ($all_sizes as $key => $value) {
		$options[$key] = esc_html( $key ).' ('.$value['width'].'x'.$value['height'].')';
	}

	$options['full'] = esc_html__( 'Full size', 'parallax-frame' );

	return apply_filters( 'parallax_frame_featured_image_size_options', $options );
}


/**
 * Returns an array of content and slider layout options registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_featured_slider_content_options() {
	$options = array(
		'homepage'    => array(
			'value'	=> 'homepage',
			'label' => esc_html__( 'Homepage / Frontpage', 'parallax-frame' ),
		),
		'entire-site' => array(
			'value' => 'entire-site',
			'label' => esc_html__( 'Entire Site', 'parallax-frame' ),
		),
		'disabled'	  => array(
			'value' => 'disabled',
			'label' => esc_html__( 'Disabled', 'parallax-frame' ),
		),
	);

	return apply_filters( 'parallax_frame_featured_slider_content_options', $options );
}


/**
 * Returns an array of hero content types registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_hero_content_types() {
	$options = array(
		'demo-hero-content' => array(
			'value' => 'demo-hero-content',
			'label' => esc_html__( 'Demo', 'parallax-frame' ),
		),
		'hero-page-content' => array(
			'value' => 'hero-page-content',
			'label' => esc_html__( 'Page', 'parallax-frame' ),
		),
	);

	return apply_filters( 'parallax_frame_hero_content_types', $options );
}


/**
 * Returns an array of feature content types registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_featured_content_types() {
	$options = array(
		'demo-featured-content' => array(
			'value' => 'demo-featured-content',
			'label' => esc_html__( 'Demo', 'parallax-frame' ),
		),
		'featured-page-content' => array(
			'value' => 'featured-page-content',
			'label' => esc_html__( 'Page', 'parallax-frame' ),
		),
	);

	return apply_filters( 'parallax_frame_featured_content_types', $options );
}


/**
 * Returns an array of featured content options registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_featured_content_layout_options() {
	$options = array(
		'layout-three' => array(
			'value'	=> 'layout-three',
			'label' => esc_html__( '3 columns', 'parallax-frame' ),
		),
		'layout-four'  => array(
			'value' => 'layout-four',
			'label' => esc_html__( '4 columns', 'parallax-frame' ),
		),
	);

	return apply_filters( 'parallax_frame_featured_content_layout_options', $options );
}


/**
 * Returns an array of featured content show registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_featured_content_show() {
	$options = array(
		'excerpt'      => array(
			'value'	=> 'excerpt',
			'label' => esc_html__( 'Show Excerpt', 'parallax-frame' ),
		),
		'full-content' => array(
			'value' => 'full-content',
			'label' => esc_html__( 'Show Full Content', 'parallax-frame' ),
		),
		'hide-content' => array(
			'value' => 'hide-content',
			'label' => esc_html__( 'Hide Content', 'parallax-frame' ),
		),
	);

	return apply_filters( 'parallax_frame_featured_content_show', $options );
}


/**
 * Returns an array of header highlight content types registered for Parallax Frame.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_header_highlight_content_types() {
	$options = array(
		'demo-header-highlight-content' => array(
			'value' => 'demo-header-highlight-content',
			'label' => __( 'Demo', 'parallax-frame' ),
		),
		'header-highlight-page-content' => array(
			'value' => 'header-highlight-page-content',
			'label' => __( 'Page', 'parallax-frame' ),
		),
	);

	return apply_filters( 'parallax_frame_header_highlight_content_types', $options );
}


/**
 * Returns an array of feature slider types registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_featured_slider_types() {
	$options = array(
		'demo-featured-slider' => array(
			'value' => 'demo-featured-slider',
			'label' => esc_html__( 'Demo', 'parallax-frame' ),
		),
		'featured-page-slider' => array(
			'value' => 'featured-page-slider',
			'label' => esc_html__( 'Page', 'parallax-frame' ),
		),
	);

	return apply_filters( 'parallax_frame_featured_slider_types', $options );
}

/**
 * Returns an array of featured slider image loader options
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_featured_slider_image_loader() {
	$options = array(
		'true' => array(
			'value' 				=> 'true',
			'label' 				=> esc_html__( 'True', 'parallax-frame' ),
		),
		'wait' => array(
			'value' 				=> 'wait',
			'label' 				=> esc_html__( 'Wait', 'parallax-frame' ),
		),
		'false' => array(
			'value' 				=> 'false',
			'label' 				=> esc_html__( 'False', 'parallax-frame' ),
		),
	);

	return apply_filters( 'parallax_frame_featured_slider_image_loader', $options );
}


/**
 * Returns an array of portfolio types registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_portfolio_types() {
	$options = array(
		'demo-portfolio' => array(
			'value' => 'demo-portfolio',
			'label' => esc_html__( 'Demo', 'parallax-frame' ),
		),
		'page-portfolio' => array(
			'value' => 'page-portfolio',
			'label' => esc_html__( 'Page', 'parallax-frame' ),
		),
	);

	return apply_filters( 'parallax_frame_portfolio_types', $options );
}


/**
 * Returns an array of feature content types registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_logo_slider_types() {
	$options = array(
		'demo' => array(
			'value' => 'demo',
			'label' => esc_html__( 'Demo', 'parallax-frame' ),
		),
		'page' => array(
			'value' => 'page',
			'label' => esc_html__( 'Page', 'parallax-frame' ),
		),
	);

	return apply_filters( 'parallax_frame_logo_slider_types', $options );
}


/**
 * Returns an array of color schemes registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_get_pagination_types() {
	$options = array(
		'default' => array(
			'value' => 'default',
			'label' => esc_html__( 'Default(Older Posts/Newer Posts)', 'parallax-frame' ),
		),
		'numeric' => array(
			'value' => 'numeric',
			'label' => esc_html__( 'Numeric', 'parallax-frame' ),
		),
		'infinite-scroll-click' => array(
			'value' => 'infinite-scroll-click',
			'label' => esc_html__( 'Infinite Scroll (Click)', 'parallax-frame' ),
		),
		'infinite-scroll-scroll' => array(
			'value' => 'infinite-scroll-scroll',
			'label' => esc_html__( 'Infinite Scroll (Scroll)', 'parallax-frame' ),
		),
	);

	return apply_filters( 'parallax_frame_get_pagination_types', $options );
}


/**
 * Returns an array of content featured image size.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_single_post_image_layout_options() {
	$all_sizes = parallax_frame_get_additional_image_sizes();

	foreach ($all_sizes as $key => $value) {
		$options[$key] = esc_html( $key ).' ('.$value['width'].'x'.$value['height'].')';
	}

	$options['disabled'] = esc_html__( 'Disabled', 'parallax-frame' );
	$options['full']     = esc_html__( 'Full size', 'parallax-frame' );

	return apply_filters( 'parallax_frame_single_post_image_layout_options', $options );
}


/**
 * Returns list of social icons currently supported
 *
 * @since Parallax Frame 0.1
*/
function parallax_frame_get_social_icons_list() {
	$options = array(
		'facebook_link'		=> array(
			'genericon_class' 	=> 'facebook-alt',
			'label' 			=> esc_html__( 'Facebook', 'parallax-frame' )
			),
		'twitter_link'		=> array(
			'genericon_class' 	=> 'twitter',
			'label' 			=> esc_html__( 'Twitter', 'parallax-frame' )
			),
		'googleplus_link'	=> array(
			'genericon_class' 	=> 'googleplus-alt',
			'label' 			=> esc_html__( 'Googleplus', 'parallax-frame' )
			),
		'email_link'		=> array(
			'genericon_class' 	=> 'mail',
			'label' 			=> esc_html__( 'Email', 'parallax-frame' )
			),
		'feed_link'			=> array(
			'genericon_class' 	=> 'feed',
			'label' 			=> esc_html__( 'Feed', 'parallax-frame' )
			),
		'wordpress_link'	=> array(
			'genericon_class' 	=> 'wordpress',
			'label' 			=> esc_html__( 'WordPress', 'parallax-frame' )
			),
		'github_link'		=> array(
			'genericon_class' 	=> 'github',
			'label' 			=> esc_html__( 'GitHub', 'parallax-frame' )
			),
		'linkedin_link'		=> array(
			'genericon_class' 	=> 'linkedin',
			'label' 			=> esc_html__( 'LinkedIn', 'parallax-frame' )
			),
		'pinterest_link'	=> array(
			'genericon_class' 	=> 'pinterest',
			'label' 			=> esc_html__( 'Pinterest', 'parallax-frame' )
			),
		'flickr_link'		=> array(
			'genericon_class' 	=> 'flickr',
			'label' 			=> esc_html__( 'Flickr', 'parallax-frame' )
			),
		'vimeo_link'		=> array(
			'genericon_class' 	=> 'vimeo',
			'label' 			=> esc_html__( 'Vimeo', 'parallax-frame' )
			),
		'youtube_link'		=> array(
			'genericon_class' 	=> 'youtube',
			'label' 			=> esc_html__( 'YouTube', 'parallax-frame' )
			),
		'tumblr_link'		=> array(
			'genericon_class' 	=> 'tumblr',
			'label' 			=> esc_html__( 'Tumblr', 'parallax-frame' )
			),
		'instagram_link'	=> array(
			'genericon_class' 	=> 'instagram',
			'label' 			=> esc_html__( 'Instagram', 'parallax-frame' )
			),
		'polldaddy_link'	=> array(
			'genericon_class' 	=> 'polldaddy',
			'label' 			=> esc_html__( 'PollDaddy', 'parallax-frame' )
			),
		'codepen_link'		=> array(
			'genericon_class' 	=> 'codepen',
			'label' 			=> esc_html__( 'CodePen', 'parallax-frame' )
			),
		'path_link'			=> array(
			'genericon_class' 	=> 'path',
			'label' 			=> esc_html__( 'Path', 'parallax-frame' )
			),
		'dribbble_link'		=> array(
			'genericon_class' 	=> 'dribbble',
			'label' 			=> esc_html__( 'Dribbble', 'parallax-frame' )
			),
		'skype_link'		=> array(
			'genericon_class' 	=> 'skype',
			'label' 			=> esc_html__( 'Skype', 'parallax-frame' )
			),
		'digg_link'			=> array(
			'genericon_class' 	=> 'digg',
			'label' 			=> esc_html__( 'Digg', 'parallax-frame' )
			),
		'reddit_link'		=> array(
			'genericon_class' 	=> 'reddit',
			'label' 			=> esc_html__( 'Reddit', 'parallax-frame' )
			),
		'stumbleupon_link'	=> array(
			'genericon_class' 	=> 'stumbleupon',
			'label' 			=> esc_html__( 'Stumbleupon', 'parallax-frame' )
			),
		'pocket_link'		=> array(
			'genericon_class' 	=> 'pocket',
			'label' 			=> esc_html__( 'Pocket', 'parallax-frame' ),
			),
		'dropbox_link'		=> array(
			'genericon_class' 	=> 'dropbox',
			'label' 			=> esc_html__( 'DropBox', 'parallax-frame' ),
			),
		'spotify_link'		=> array(
			'genericon_class' 	=> 'spotify',
			'label' 			=> esc_html__( 'Spotify', 'parallax-frame' ),
			),
		'foursquare_link'	=> array(
			'genericon_class' 	=> 'foursquare',
			'label' 			=> esc_html__( 'Foursquare', 'parallax-frame' ),
			),
		'twitch_link'		=> array(
			'genericon_class' 	=> 'twitch',
			'label' 			=> esc_html__( 'Twitch', 'parallax-frame' ),
			),
		'website_link'		=> array(
			'genericon_class' 	=> 'website',
			'label' 			=> esc_html__( 'Website', 'parallax-frame' ),
			),
		'phone_link'		=> array(
			'genericon_class' 	=> 'phone',
			'label' 			=> esc_html__( 'Phone', 'parallax-frame' ),
			),
		'handset_link'		=> array(
			'genericon_class' 	=> 'handset',
			'label' 			=> esc_html__( 'Handset', 'parallax-frame' ),
			),
		'cart_link'			=> array(
			'genericon_class' 	=> 'cart',
			'label' 			=> esc_html__( 'Cart', 'parallax-frame' ),
			),
		'cloud_link'		=> array(
			'genericon_class' 	=> 'cloud',
			'label' 			=> esc_html__( 'Cloud', 'parallax-frame' ),
			),
		'link_link'		=> array(
			'genericon_class' 	=> 'link',
			'label' 			=> esc_html__( 'Link', 'parallax-frame' ),
			),
	);

	return apply_filters( 'parallax_frame_social_icons_list', $options );
}


/**
 * Returns an array of metabox layout options registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_metabox_layouts() {
	$options = array(
		'default' 	=> array(
			'id' 	=> 'parallax-frame-layout-option',
			'value' => 'default',
			'label' => esc_html__( 'Default', 'parallax-frame' ),
		),
		'left-sidebar' 	=> array(
			'id' 	=> 'parallax-frame-layout-option',
			'value' => 'left-sidebar',
			'label' => esc_html__( 'Primary Sidebar, Content', 'parallax-frame' ),
		),
		'right-sidebar' => array(
			'id' 	=> 'parallax-frame-layout-option',
			'value' => 'right-sidebar',
			'label' => esc_html__( 'Content, Primary Sidebar', 'parallax-frame' ),
		),
		'no-sidebar'	=> array(
			'id' 	=> 'parallax-frame-layout-option',
			'value' => 'no-sidebar',
			'label' => esc_html__( 'No Sidebar ( Content Width )', 'parallax-frame' ),
		),
	);
	return apply_filters( 'parallax_frame_layouts', $options );
}

/**
 * Returns an array of metabox header featured image options registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_metabox_header_featured_image_options() {
	$options = array(
		'default' => array(
			'id'		=> 'parallax-frame-header-image',
			'value' 	=> 'default',
			'label' 	=> esc_html__( 'Default', 'parallax-frame' ),
		),
		'enabled' => array(
			'id'		=> 'parallax-frame-header-image',
			'value' 	=> 'enabled',
			'label' 	=> esc_html__( 'Enable', 'parallax-frame' ),
		),
		'disabled' => array(
			'id'		=> 'parallax-frame-header-image',
			'value' 	=> 'disabled',
			'label' 	=> esc_html__( 'Disable', 'parallax-frame' )
		)
	);
	return apply_filters( 'header_featured_image_options', $options );
}


/**
 * Returns an array of metabox featured image options registered for parallaxframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_metabox_featured_image_options() {
	$options['default'] = array(
		'id'	=> 'parallax-frame-featured-image',
		'value' => 'default',
		'label' => esc_html__( 'Default', 'parallax-frame' ),
	);

	$all_sizes = parallax_frame_get_additional_image_sizes();

	foreach ($all_sizes as $key => $value) {
		$options[$key] = array(
			'id'	=> 'parallax-frame-featured-image',
			'value' => $key,
			'label' => esc_html( $key ).' ('.$value['width'].'x'.$value['height'].')'
		);

	}

	$options['full'] = array(
		'id'	=> 'parallax-frame-featured-image',
		'value'	=> 'full',
		'label' => esc_html__( 'Full Image', 'parallax-frame' ),
	);

	$options['disabled'] = array(
		'id' 	=> 'parallax-frame-featured-image',
		'value' => 'disabled',
		'label' => esc_html__( 'Disable Image', 'parallax-frame' )
	);

	return apply_filters( 'parallax_frame_metabox_featured_image_options', $options );
}


/**
 * Returns an array of featured content background image positions
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_featured_content_background_display_positions() {
	$options = array(
		'top' => array(
			'value' => 'top',
			'label' => esc_html__( 'Top', 'parallax-frame' ),
		),
		'bottom' => array(
			'value' => 'bottom',
			'label' => esc_html__( 'Bottom', 'parallax-frame' ),
		),
	);
	return apply_filters( 'parallax_frame_featured_content_background_display_positions', $options );
}


/**
 * Returns an array of featured content background repeat options
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_featured_content_background_repeat_options() {
	 $options = array(
		'no-repeat' => array(
			'value' => 'no-repeat',
			'label' => esc_html__( 'No repeat', 'parallax-frame' ),
		),
		'tile' => array(
			'value' => 'repeat',
			'label' => esc_html__( 'Tile', 'parallax-frame' ),
		)
	);
	return apply_filters( 'parallax_frame_featured_content_background_repeat_options', $options );
}


/**
 * Returns an array of featured content background attachment options
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_featured_content_background_attachment_options() {
	$options = array(
		'scroll' => array(
			'value' => 'scroll',
			'label' => esc_html__( 'Scroll', 'parallax-frame' ),
		),
		'fixed' => array(
			'value' => 'fixed',
			'label' => esc_html__( 'Fixed', 'parallax-frame' ),
		),
	);
	return apply_filters( 'parallax_frame_featured_content_background_attachment_options', $options );
}


/**
 * Returns the default options for parallaxframe dark theme.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_default_dark_color_options() {
	$default_dark_color_options = array(
		//Basic Color Options
		'background_color'                                 => '#111111',
		'header_textcolor'                                 => '#bebebe',
	);

	return apply_filters( 'parallax_frame_default_dark_color_options', $default_dark_color_options );
}


/**
 * Returns parallax_frame_contents registered for fullframe.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_get_content() {
	$theme_data = wp_get_theme();

	$parallax_frame_content['top'] 	= sprintf( _x( 'Copyright &copy; %1$s %2$s. All Rights Reserved. %3$s', '1: Year, 2: Site Title with home URL 3: Privacy Policy Link', 'parallax-frame' ), esc_attr( date_i18n( __( 'Y', 'parallax-frame' ) ) ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>', get_the_privacy_policy_link() );

	$parallax_frame_content['bottom']	= esc_attr( $theme_data->get( 'Name') ) . '&nbsp;' . __( 'by', 'parallax-frame' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_attr( $theme_data->get( 'Author' ) ) .'</a>';

	return apply_filters( 'parallax_frame_get_content', $parallax_frame_content );
}
