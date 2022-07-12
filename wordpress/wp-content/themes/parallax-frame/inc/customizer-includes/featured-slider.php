<?php
/**
 * The template for adding Featured Slider Options in Customizer
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */

//Featured Slider
$wp_customize->add_section( 'parallax_frame_featured_slider', array(
	'priority'		=> 400,
	'title'			=> esc_html__( 'Featured Slider', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_slider_option]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_option'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$featured_slider_content_options = parallax_frame_featured_slider_content_options();
$choices = array();
foreach ( $featured_slider_content_options as $featured_slider_content_option ) {
	$choices[$featured_slider_content_option['value']] = $featured_slider_content_option['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[featured_slider_option]', array(
	'choices'  => $choices,
	'label'    => esc_html__( 'Enable Slider on', 'parallax-frame' ),
	'section'  => 'parallax_frame_featured_slider',
	'settings' => 'parallax_frame_theme_options[featured_slider_option]',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_slider_transition_delay]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_transition_delay'],
	'sanitize_callback'	=> 'parallax_frame_sanitize_number_range',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_slider_transition_delay]' , array(
	'active_callback' => 'parallax_frame_is_slider_active',
	'description'     => esc_html__( 'seconds(s)', 'parallax-frame' ),
	'input_attrs'     => array(
		'style' => 'width: 40px;'
		),
	'label'           => esc_html__( 'Transition Delay', 'parallax-frame' ),
	'section'         => 'parallax_frame_featured_slider',
	'settings'        => 'parallax_frame_theme_options[featured_slider_transition_delay]',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_slider_transition_length]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_transition_length'],
	'sanitize_callback'	=> 'parallax_frame_sanitize_number_range',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_slider_transition_length]' , array(
		'active_callback' => 'parallax_frame_is_slider_active',
		'description'     => esc_html__( 'seconds(s)', 'parallax-frame' ),
		'input_attrs'     => array(
			'style' => 'width: 40px;'
		),
		'label'           => esc_html__( 'Transition Length', 'parallax-frame' ),
		'section'         => 'parallax_frame_featured_slider',
		'settings'        => 'parallax_frame_theme_options[featured_slider_transition_length]',
	)
);

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_slider_image_loader]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['featured_slider_image_loader'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$featured_slider_image_loader_options = parallax_frame_featured_slider_image_loader();
$choices = array();
foreach ( $featured_slider_image_loader_options as $featured_slider_image_loader_option ) {
	$choices[$featured_slider_image_loader_option['value']] = $featured_slider_image_loader_option['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[featured_slider_image_loader]', array(
	'active_callback' => 'parallax_frame_is_slider_active',
	'description'     => esc_html__( 'True: Fixes the height overlap issue. Slideshow will start as soon as two slider are available. Slide may display in random, as image is fetch. Wait: Fixes the height overlap issue. Slideshow will start only after all images are available.', 'parallax-frame' ),
	'choices'         => $choices,
	'label'           => esc_html__( 'Image Loader', 'parallax-frame' ),
	'section'         => 'parallax_frame_featured_slider',
	'settings'        => 'parallax_frame_theme_options[featured_slider_image_loader]',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_slider_type]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_type'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$featured_slider_types = parallax_frame_featured_slider_types();
$choices = array();
foreach ( $featured_slider_types as $featured_slider_type ) {
	$choices[$featured_slider_type['value']] = $featured_slider_type['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[featured_slider_type]', array(
	'active_callback' => 'parallax_frame_is_slider_active',
	'choices'         => $choices,
	'label'           => esc_html__( 'Select Slider Type', 'parallax-frame' ),
	'section'         => 'parallax_frame_featured_slider',
	'settings'        => 'parallax_frame_theme_options[featured_slider_type]',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_slider_number]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_number'],
	'sanitize_callback'	=> 'parallax_frame_sanitize_number_range',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_slider_number]' , array(
	'active_callback' => 'parallax_frame_is_demo_slider_inactive',
	'description'     => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'parallax-frame' ),
	'input_attrs'     => array(
	'style'           => 'width: 45px;',
		'min'  => 0,
		'max'  => 20,
		'step' => 1,
	),
	'label'           => esc_html__( 'No of Slides', 'parallax-frame' ),
	'section'         => 'parallax_frame_featured_slider',
	'settings'        => 'parallax_frame_theme_options[featured_slider_number]',
	'type'            => 'number',
	)
);

//loop for featured post sliders
for ( $i=1; $i <=  $options['featured_slider_number'] ; $i++ ) {
	$wp_customize->add_setting( 'parallax_frame_theme_options[featured_slider_page_'. $i .']', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback'	=> 'parallax_frame_sanitize_page',
	) );

	$wp_customize->add_control( 'parallax_frame_theme_options[featured_slider_page_'. $i .']', array(
		'active_callback' => 'parallax_frame_is_demo_slider_inactive',
		'label'           => esc_html__( 'Featured Page', 'parallax-frame' ) . ' # ' . $i ,
		'section'         => 'parallax_frame_featured_slider',
		'settings'        => 'parallax_frame_theme_options[featured_slider_page_'. $i .']',
		'type'            => 'dropdown-pages',
	) );
}
// Featured Slider End
