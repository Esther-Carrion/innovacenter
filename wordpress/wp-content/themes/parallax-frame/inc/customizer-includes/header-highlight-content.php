<?php
/**
* The template for adding Header Highlight Content in Customizer
*
* @package Catch Themes
* @subpackage Parallax Frame
* @since Parallax Frame 0.1
*/

$wp_customize->add_section( 'parallax_frame_header_highlight_content', array(
	'priority' => 600,
	'title'    => esc_html__( 'Header Highlight Content', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[header_highlight_content_option]', array(
	'capability'        => 'edit_theme_options',
	'default'			=> $defaults['header_highlight_content_option'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$parallax_frame_featured_slider_content_options = parallax_frame_featured_slider_content_options();
$choices = array();
foreach ( $parallax_frame_featured_slider_content_options as $parallax_frame_featured_slider_content_option ) {
	$choices[$parallax_frame_featured_slider_content_option['value']] = $parallax_frame_featured_slider_content_option['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[header_highlight_content_option]', array(
	'choices'  	=> $choices,
	'label'    	=> esc_html__( 'Enable Header Highlight Content on', 'parallax-frame' ),
	'priority'	=> '1',
	'section'  	=> 'parallax_frame_header_highlight_content',
	'settings' 	=> 'parallax_frame_theme_options[header_highlight_content_option]',
	'type'	  	=> 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[header_highlight_content_type]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['header_highlight_content_type'],
	'sanitize_callback'	=> 'parallax_frame_sanitize_select',
) );

$parallax_frame_header_highlight_content_types = parallax_frame_header_highlight_content_types();
$choices = array();
foreach ( $parallax_frame_header_highlight_content_types as $parallax_frame_header_highlight_content_type ) {
	$choices[$parallax_frame_header_highlight_content_type['value']] = $parallax_frame_header_highlight_content_type['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[header_highlight_content_type]', array(
	'active_callback' => 'parallax_frame_is_header_highlight_content_active',
	'choices'         => $choices,
	'label'           => esc_html__( 'Select Content Type', 'parallax-frame' ),
	'priority'        => '3',
	'section'         => 'parallax_frame_header_highlight_content',
	'settings'        => 'parallax_frame_theme_options[header_highlight_content_type]',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[header_highlight_content_headline]', array(
	'capability'		=> 'edit_theme_options',
	'sanitize_callback'	=> 'wp_kses_post',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[header_highlight_content_headline]' , array(
	'active_callback'	=> 'parallax_frame_is_header_highlight_content_active',
	'description'	=> esc_html__( 'Leave field empty if you want to remove Headline', 'parallax-frame' ),
	'label'    		=> esc_html__( 'Headline for Header Highlight Content', 'parallax-frame' ),
	'priority'		=> '4',
	'section'  		=> 'parallax_frame_header_highlight_content',
	'settings' 		=> 'parallax_frame_theme_options[header_highlight_content_headline]',
	'type'	   		=> 'text',
	)
);

$wp_customize->add_setting( 'parallax_frame_theme_options[header_highlight_content_subheadline]', array(
	'capability'		=> 'edit_theme_options',
	'sanitize_callback'	=> 'wp_kses_post',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[header_highlight_content_subheadline]' , array(
	'active_callback'	=> 'parallax_frame_is_header_highlight_content_active',
	'description'	=> esc_html__( 'Leave field empty if you want to remove Sub-headline', 'parallax-frame' ),
	'label'    		=> esc_html__( 'Sub-headline for Header Highlight Content', 'parallax-frame' ),
	'priority'		=> '5',
	'section'  		=> 'parallax_frame_header_highlight_content',
	'settings' 		=> 'parallax_frame_theme_options[header_highlight_content_subheadline]',
	'type'	   		=> 'text',
	)
);

$wp_customize->add_setting( 'parallax_frame_theme_options[header_highlight_content_show]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['header_highlight_content_show'],
	'sanitize_callback'	=> 'parallax_frame_sanitize_select',
) );

$parallax_frame_header_highlight_content_show = parallax_frame_featured_content_show();
$choices = array();
foreach ( $parallax_frame_header_highlight_content_show as $parallax_frame_header_highlight_content_shows ) {
	$choices[$parallax_frame_header_highlight_content_shows['value']] = $parallax_frame_header_highlight_content_shows['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[header_highlight_content_show]', array(
	'active_callback' => 'parallax_frame_is_demo_header_highlight_content_inactive',
	'choices'         => $choices,
	'label'           => esc_html__( 'Display Content', 'parallax-frame' ),
	'section'         => 'parallax_frame_header_highlight_content',
	'settings'        => 'parallax_frame_theme_options[header_highlight_content_show]',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[header_highlight_content_number]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['header_highlight_content_number'],
	'sanitize_callback'	=> 'parallax_frame_sanitize_number_range',
	'transport'			=> 'postMessage'
) );

$wp_customize->add_control( 'parallax_frame_theme_options[header_highlight_content_number]' , array(
		'active_callback' => 'parallax_frame_is_demo_header_highlight_content_inactive',
		'description'     => esc_html__( 'Save and refresh the page if No. of Header Highlight Content is changed (Max no of Header Highlight Content is 21)', 'parallax-frame' ),
		'input_attrs'     => array(
			'style' => 'width: 45px;',
			'min'   => 1,
		),
		'label'           => esc_html__( 'No of Header Highlight Content', 'parallax-frame' ),
		'priority'        => '6',
		'section'         => 'parallax_frame_header_highlight_content',
		'type'            => 'number',
	)
);

//loop for content types
for ( $i=1; $i <=  $options['header_highlight_content_number'] ; $i++ ) {
	//Page Content
	$wp_customize->add_setting( 'parallax_frame_theme_options[header_highlight_content_page_'. $i .']', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback'	=> 'parallax_frame_sanitize_page',
	) );

	$wp_customize->add_control( 'parallax_frame_theme_options[header_highlight_content_page_'. $i .']', array(
		'active_callback' => 'parallax_frame_is_demo_header_highlight_content_inactive',
		'label'           => esc_html__( 'Page', 'parallax-frame' ) . ' ' . $i ,
		'section'         => 'parallax_frame_header_highlight_content',
		'settings'        => 'parallax_frame_theme_options[header_highlight_content_page_'. $i .']',
		'type'            => 'dropdown-pages',
	) );
}
