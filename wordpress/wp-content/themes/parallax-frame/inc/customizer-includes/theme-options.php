<?php
/**
* The template for adding additional theme options in Customizer
*
* @package Catch Themes
* @subpackage Parallax Frame
* @since Parallax Frame 0.1
*/

$wp_customize->add_panel( 'parallax_frame_theme_options', array(
    'description'    => esc_html__( 'Basic theme Options', 'parallax-frame' ),
    'capability'     => 'edit_theme_options',
    'priority'       => 200,
    'title'    		 => esc_html__( 'Theme Options', 'parallax-frame' ),
) );

// Breadcrumb Option
$wp_customize->add_section( 'parallax_frame_breadcumb_options', array(
	'description'	=> esc_html__( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance. You can enable/disable them on homepage and entire site.', 'parallax-frame' ),
	'panel'			=> 'parallax_frame_theme_options',
	'title'    		=> esc_html__( 'Breadcrumb Options', 'parallax-frame' ),
	'priority' 		=> 201,
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[breadcumb_option]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['breadcumb_option'],
	'sanitize_callback' => 'parallax_frame_sanitize_checkbox'
) );

$wp_customize->add_control( 'parallax_frame_theme_options[breadcumb_option]', array(
	'label'    => esc_html__( 'Check to enable Breadcrumb', 'parallax-frame' ),
	'section'  => 'parallax_frame_breadcumb_options',
	'settings' => 'parallax_frame_theme_options[breadcumb_option]',
	'type'     => 'checkbox',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[breadcumb_on_homepage]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['breadcumb_on_homepage'],
	'sanitize_callback' => 'parallax_frame_sanitize_checkbox'
) );

$wp_customize->add_control( 'parallax_frame_theme_options[breadcumb_on_homepage]', array(
	'label'    => esc_html__( 'Check to enable Breadcrumb on Homepage', 'parallax-frame' ),
	'section'  => 'parallax_frame_breadcumb_options',
	'settings' => 'parallax_frame_theme_options[breadcumb_on_homepage]',
	'type'     => 'checkbox',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[breadcumb_seperator]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['breadcumb_seperator'],
	'sanitize_callback'	=> 'sanitize_text_field',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[breadcumb_seperator]', array(
	'input_attrs' => array(
    		'style' => 'width: 40px;'
		),
	'label'    	=> esc_html__( 'Separator between Breadcrumbs', 'parallax-frame' ),
	'section' 	=> 'parallax_frame_breadcumb_options',
	'settings' 	=> 'parallax_frame_theme_options[breadcumb_seperator]',
	'type'     	=> 'text'
	)
);
// Breadcrumb Option End

/**
 *  Remove Custom CSS option from WordPress 4.7 onwards
 *  //@remove Remove if block and custom_css when WordPress 5.0 is released
 */
if ( !function_exists( 'wp_update_custom_css_post' ) ) {
	// Custom CSS Option
	$wp_customize->add_section( 'parallax_frame_custom_css', array(
		'description'	=> esc_html__( 'Custom/Inline CSS', 'parallax-frame'),
		'panel'  		=> 'parallax_frame_theme_options',
		'priority' 		=> 203,
		'title'    		=> esc_html__( 'Custom CSS Options', 'parallax-frame' ),
	) );

	$wp_customize->add_setting( 'parallax_frame_theme_options[custom_css]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['custom_css'],
		'sanitize_callback' => 'parallax_frame_sanitize_custom_css',
	) );

	$wp_customize->add_control( 'parallax_frame_theme_options[custom_css]', array(
			'label'		=> esc_html__( 'Enter Custom CSS', 'parallax-frame' ),
	        'priority'	=> 1,
			'section'   => 'parallax_frame_custom_css',
	        'settings'  => 'parallax_frame_theme_options[custom_css]',
			'type'		=> 'textarea',
	) );
	// Custom CSS End
}

// Excerpt Options
$wp_customize->add_section( 'parallax_frame_excerpt_options', array(
	'panel'  	=> 'parallax_frame_theme_options',
	'priority' 	=> 204,
	'title'    	=> esc_html__( 'Excerpt Options', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[excerpt_length]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['excerpt_length'],
	'sanitize_callback' => 'parallax_frame_sanitize_number_range',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[excerpt_length]', array(
	'description' => esc_html__( 'Excerpt length. Default is 40 words', 'parallax-frame'),
	'input_attrs' => array(
        'min'   => 10,
        'max'   => 200,
        'step'  => 5,
        'style' => 'width: 60px;'
        ),
    'label'    => esc_html__( 'Excerpt Length (words)', 'parallax-frame' ),
	'section'  => 'parallax_frame_excerpt_options',
	'settings' => 'parallax_frame_theme_options[excerpt_length]',
	'type'	   => 'number',
	)
);

$wp_customize->add_setting( 'parallax_frame_theme_options[excerpt_more_text]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['excerpt_more_text'],
	'sanitize_callback'	=> 'sanitize_text_field',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[excerpt_more_text]', array(
	'label'    => esc_html__( 'Read More Text', 'parallax-frame' ),
	'section'  => 'parallax_frame_excerpt_options',
	'settings' => 'parallax_frame_theme_options[excerpt_more_text]',
	'type'	   => 'text',
) );
// Excerpt Options End

//Homepage / Frontpage Options
$wp_customize->add_section( 'parallax_frame_homepage_options', array(
	'description'	=> esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'parallax-frame' ),
	'panel'			=> 'parallax_frame_theme_options',
	'priority' 		=> 209,
	'title'   	 	=> esc_html__( 'Homepage / Frontpage Options', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[front_page_category]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['front_page_category'],
	'sanitize_callback'	=> 'parallax_frame_sanitize_category_list',
) );

$wp_customize->add_control( new parallax_frame_customize_dropdown_categories_control( $wp_customize, 'parallax_frame_theme_options[front_page_category]', array(
    'label'   	=> esc_html__( 'Select Categories', 'parallax-frame' ),
    'name'	 	=> 'parallax_frame_theme_options[front_page_category]',
	'priority'	=> '6',
    'section'  	=> 'parallax_frame_homepage_options',
    'settings' 	=> 'parallax_frame_theme_options[front_page_category]',
    'type'     	=> 'dropdown-categories',
) ) );
//Homepage / Frontpage Settings End

// Layout Options
$wp_customize->add_section( 'parallax_frame_layout', array(
	'capability'=> 'edit_theme_options',
	'panel'		=> 'parallax_frame_theme_options',
	'priority'	=> 211,
	'title'		=> esc_html__( 'Layout Options', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[theme_layout]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['theme_layout'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$layouts = parallax_frame_layouts();
$choices = array();
foreach ( $layouts as $layout ) {
	$choices[ $layout['value'] ] = $layout['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[theme_layout]', array(
	'choices'	=> $choices,
	'label'		=> esc_html__( 'Default Layout', 'parallax-frame' ),
	'section'	=> 'parallax_frame_layout',
	'settings'   => 'parallax_frame_theme_options[theme_layout]',
	'type'		=> 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[content_layout]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['content_layout'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$layouts = parallax_frame_get_archive_content_layout();
$choices = array();
foreach ( $layouts as $layout ) {
	$choices[ $layout['value'] ] = $layout['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[content_layout]', array(
	'choices'   => $choices,
	'label'		=> esc_html__( 'Archive Content Layout', 'parallax-frame' ),
	'section'   => 'parallax_frame_layout',
	'settings'  => 'parallax_frame_theme_options[content_layout]',
	'type'      => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[single_post_image_layout]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['single_post_image_layout'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );


$wp_customize->add_control( 'parallax_frame_theme_options[single_post_image_layout]', array(
		'label'		=> esc_html__( 'Single Page/Post Image Layout ', 'parallax-frame' ),
		'section'   => 'parallax_frame_layout',
        'settings'  => 'parallax_frame_theme_options[single_post_image_layout]',
        'type'	  	=> 'select',
		'choices'  	=> parallax_frame_single_post_image_layout_options(),
) );
// Layout Options End

// Pagination Options
$pagination_type	= $options['pagination_type'];

$nav_desc = sprintf(
	wp_kses(
		__( '<a target="_blank" href="%1$s">WP-PageNavi Plugin</a> is recommended for Numeric Option(But will work without it).<br/>Infinite Scroll Options requires <a target="_blank" href="%2$s">JetPack Plugin</a> with Infinite Scroll module Enabled.', 'parallax-frame' ),
		array(
			'a' => array(
				'href' => array(),
				'target' => array(),
			),
			'br'=> array()
		)
	),
	esc_url( 'https://wordpress.org/plugins/wp-pagenavi' ),
	esc_url( 'https://wordpress.org/plugins/jetpack/' )
);

/**
* Check if navigation type is Jetpack Infinite Scroll and if it is enabled
*/
if ( ( 'infinite-scroll-click' == $pagination_type || 'infinite-scroll-scroll' == $pagination_type ) ) {
if ( ! (class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) ) {
	$nav_desc = sprintf(
		wp_kses(
			__( 'Infinite Scroll Options requires <a target="_blank" href="%s">JetPack Plugin</a> with Infinite Scroll module Enabled.', 'parallax-frame' ),
			array(
				'a' => array(
					'href' => array(),
					'target' => array()
				)
			)
		),
		esc_url( 'https://wordpress.org/plugins/jetpack/' )
	);
}
else {
	$nav_desc = '';
}
}

$wp_customize->add_section( 'parallax_frame_pagination_options', array(
	'description'	=> $nav_desc,
	'panel'  		=> 'parallax_frame_theme_options',
	'priority'		=> 212,
	'title'    		=> esc_html__( 'Pagination Options', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[pagination_type]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['pagination_type'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$pagination_types = parallax_frame_get_pagination_types();
$choices = array();
foreach ( $pagination_types as $pagination_type ) {
	$choices[$pagination_type['value']] = $pagination_type['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[pagination_type]', array(
	'choices'  => $choices,
	'label'    => esc_html__( 'Pagination type', 'parallax-frame' ),
	'section'  => 'parallax_frame_pagination_options',
	'settings' => 'parallax_frame_theme_options[pagination_type]',
	'type'	   => 'select',
) );
// Pagination Options End

//Promotion Headline Options
$wp_customize->add_section( 'parallax_frame_promotion_headline_options', array(
	'description'	=> esc_html__( 'To disable the fields, simply leave them empty.', 'parallax-frame' ),
	'panel'			=> 'parallax_frame_theme_options',
	'priority' 		=> 213,
	'title'   	 	=> esc_html__( 'Promotion Headline Options', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[promotion_headline_option]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['promotion_headline_option'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$parallax_frame_featured_slider_content_options = parallax_frame_featured_slider_content_options();
$choices = array();
foreach ( $parallax_frame_featured_slider_content_options as $parallax_frame_featured_slider_content_option ) {
	$choices[$parallax_frame_featured_slider_content_option['value']] = $parallax_frame_featured_slider_content_option['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[promotion_headline_option]', array(
	'choices'  	=> $choices,
	'label'    	=> esc_html__( 'Enable Promotion Headline on', 'parallax-frame' ),
	'priority'	=> '0.5',
	'section'  	=> 'parallax_frame_promotion_headline_options',
	'settings' 	=> 'parallax_frame_theme_options[promotion_headline_option]',
	'type'	  	=> 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[promotion_headline]', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_headline'],
	'sanitize_callback'	=> 'wp_kses_post'
) );

$wp_customize->add_control( 'parallax_frame_theme_options[promotion_headline]', array(
	'description'	=> esc_html__( 'Appropriate Words: 10', 'parallax-frame' ),
	'label'    	=> esc_html__( 'Promotion Headline Text', 'parallax-frame' ),
	'priority'	=> '1',
	'section' 	=> 'parallax_frame_promotion_headline_options',
	'settings'	=> 'parallax_frame_theme_options[promotion_headline]',
	'active_callback' => 'parallax_frame_is_promotional_headline_enabled',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[promotion_subheadline]', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_subheadline'],
	'sanitize_callback'	=> 'wp_kses_post'
) );

$wp_customize->add_control( 'parallax_frame_theme_options[promotion_subheadline]', array(
	'description'	=> esc_html__( 'Appropriate Words: 15', 'parallax-frame' ),
	'label'    	=> esc_html__( 'Promotion Subheadline Text', 'parallax-frame' ),
	'priority'	=> '2',
	'section' 	=> 'parallax_frame_promotion_headline_options',
	'settings'	=> 'parallax_frame_theme_options[promotion_subheadline]',
	'active_callback' => 'parallax_frame_is_promotional_headline_enabled',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[promotion_headline_button]', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_headline_button'],
	'sanitize_callback'	=> 'sanitize_text_field'
) );

$wp_customize->add_control( 'parallax_frame_theme_options[promotion_headline_button]', array(
	'description'	=> esc_html__( 'Appropriate Words: 3', 'parallax-frame' ),
	'label'    	=> esc_html__( 'Promotion Headline Button Text ', 'parallax-frame' ),
	'priority'	=> '3',
	'section' 	=> 'parallax_frame_promotion_headline_options',
	'settings'	=> 'parallax_frame_theme_options[promotion_headline_button]',
	'type'		=> 'text',
	'active_callback' => 'parallax_frame_is_promotional_headline_enabled',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[promotion_headline_url]', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_headline_url'],
	'sanitize_callback'	=> 'esc_url_raw'
) );

$wp_customize->add_control( 'parallax_frame_theme_options[promotion_headline_url]', array(
	'label'    	=> esc_html__( 'Promotion Headline Link', 'parallax-frame' ),
	'priority'	=> '4',
	'section' 	=> 'parallax_frame_promotion_headline_options',
	'settings'	=> 'parallax_frame_theme_options[promotion_headline_url]',
	'type'		=> 'text',
	'active_callback' => 'parallax_frame_is_promotional_headline_enabled',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[promotion_headline_target]', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_headline_target'],
	'sanitize_callback' => 'parallax_frame_sanitize_checkbox',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[promotion_headline_target]', array(
	'label'    	=> esc_html__( 'Check to Open Link in New Window/Tab', 'parallax-frame' ),
	'priority'	=> '5',
	'section'  	=> 'parallax_frame_promotion_headline_options',
	'settings' 	=> 'parallax_frame_theme_options[promotion_headline_target]',
	'type'     	=> 'checkbox',
	'active_callback' => 'parallax_frame_is_promotional_headline_enabled',
) );
// Promotion Headline Options End

// Scrollup
$wp_customize->add_section( 'parallax_frame_scrollup', array(
	'panel'    => 'parallax_frame_theme_options',
	'priority' => 215,
	'title'    => esc_html__( 'Scrollup Options', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[disable_scrollup]', array(
	'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['disable_scrollup'],
	'sanitize_callback' => 'parallax_frame_sanitize_checkbox',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[disable_scrollup]', array(
	'label'		=> esc_html__( 'Check to disable Scroll Up', 'parallax-frame' ),
	'section'   => 'parallax_frame_scrollup',
    'settings'  => 'parallax_frame_theme_options[disable_scrollup]',
	'type'		=> 'checkbox',
) );
// Scrollup End

// Search Options
$wp_customize->add_section( 'parallax_frame_search_options', array(
	'description'=> esc_html__( 'Change default placeholder text in Search.', 'parallax-frame'),
	'panel'  => 'parallax_frame_theme_options',
	'priority' => 216,
	'title'    => esc_html__( 'Search Options', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[search_text]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['search_text'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[search_text]', array(
	'label'		=> esc_html__( 'Default Display Text in Search', 'parallax-frame' ),
	'section'   => 'parallax_frame_search_options',
    'settings'  => 'parallax_frame_theme_options[search_text]',
	'type'		=> 'text',
) );
// Search Options End

// Single Post Navigation
$wp_customize->add_section( 'parallax_frame_single_post_navigation', array(
	'panel'  => 'parallax_frame_theme_options',
	'priority' => 217,
	'title'    => esc_html__( 'Single Post Navigation', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[disable_single_post_navigation]', array(
	'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['disable_single_post_navigation'],
	'sanitize_callback' => 'parallax_frame_sanitize_checkbox',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[disable_single_post_navigation]', array(
	'label'		=> esc_html__( 'Check to disable Single Post Navigation', 'parallax-frame' ),
	'section'   => 'parallax_frame_single_post_navigation',
    'settings'  => 'parallax_frame_theme_options[disable_single_post_navigation]',
	'type'		=> 'checkbox',
) );
// Single Post Navigation End