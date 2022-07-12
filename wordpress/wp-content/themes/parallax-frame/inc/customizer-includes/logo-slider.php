<?php
/**
 * The template for adding Logo Slider Options in Customizer
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */

$wp_customize->add_section( 'parallax_frame_logo_slider', array(
	'priority' => 900,
	'title'    => esc_html__( 'Logo Slider', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[logo_slider_option]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_option'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$logo_slider_options = parallax_frame_featured_slider_content_options();
$choices = array();
foreach ( $logo_slider_options as $logo_slider_option ) {
	$choices[$logo_slider_option['value']] = $logo_slider_option['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[logo_slider_option]', array(
	'choices'  => $choices,
	'label'    => esc_html__( 'Enable Logo Slider on', 'parallax-frame' ),
	'section'  => 'parallax_frame_logo_slider',
	'settings' => 'parallax_frame_theme_options[logo_slider_option]',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[logo_slider_bg]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['logo_slider_bg'],
	'sanitize_callback' => 'parallax_frame_sanitize_image',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'parallax_frame_theme_options[logo_slider_bg]', array(
	'active_callback' => 'parallax_frame_is_logo_slider_active',
	'label'           => esc_html__( 'Logo Slider Background Image', 'parallax-frame' ),
	'section'         => 'parallax_frame_logo_slider',
	'settings'        => 'parallax_frame_theme_options[logo_slider_bg]',
) ) );

$wp_customize->add_setting( 'parallax_frame_theme_options[logo_slider_type]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_type'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$logo_slider_types = parallax_frame_logo_slider_types();
$choices = array();
foreach ( $logo_slider_types as $logo_slider_type ) {
	$choices[$logo_slider_type['value']] = $logo_slider_type['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[logo_slider_type]', array(
	'active_callback' => 'parallax_frame_is_logo_slider_active',
	'choices'         => $choices,
	'label'           => esc_html__( 'Logo Slider Type', 'parallax-frame' ),
	'section'         => 'parallax_frame_logo_slider',
	'settings'        => 'parallax_frame_theme_options[logo_slider_type]',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[logo_slider_transition_delay]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_transition_delay'],
	'sanitize_callback'	=> 'parallax_frame_sanitize_number_range',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[logo_slider_transition_delay]' , array(
	'active_callback' => 'parallax_frame_is_logo_slider_active',
	'description'     => esc_html__( 'seconds(s)', 'parallax-frame' ),
	'input_attrs'     => array(
		'style' => 'width: 40px;'
		),
	'label'           => esc_html__( 'Transition Delay', 'parallax-frame' ),
	'section'         => 'parallax_frame_logo_slider',
	'settings'        => 'parallax_frame_theme_options[logo_slider_transition_delay]',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[logo_slider_transition_length]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_transition_length'],
	'sanitize_callback'	=> 'parallax_frame_sanitize_number_range',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[logo_slider_transition_length]' , array(
		'active_callback' => 'parallax_frame_is_logo_slider_active',
		'description'     => esc_html__( 'seconds(s)', 'parallax-frame' ),
		'input_attrs'     => array(
			'style' => 'width: 40px;'
		),
		'label'           => esc_html__( 'Transition Length', 'parallax-frame' ),
		'section'         => 'parallax_frame_logo_slider',
		'settings'        => 'parallax_frame_theme_options[logo_slider_transition_length]',
	)
);

$wp_customize->add_setting( 'parallax_frame_theme_options[logo_slider_title]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_title'],
	'sanitize_callback'	=> 'sanitize_text_field',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[logo_slider_title]' , array(
	'active_callback' => 'parallax_frame_is_demo_logo_slider_inactive',
	'label'           => esc_html__( 'Title', 'parallax-frame' ),
	'section'         => 'parallax_frame_logo_slider',
	'settings'        => 'parallax_frame_theme_options[logo_slider_title]',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[logo_slider_number]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_number'],
	'sanitize_callback'	=> 'parallax_frame_sanitize_number_range',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[logo_slider_number]' , array(
	'active_callback' => 'parallax_frame_is_demo_logo_slider_inactive',
	'description'     => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'parallax-frame' ),
	'input_attrs'     => array(
	'style'           => 'width: 45px;',
		'min'  => 0,
		'max'  => 20,
		'step' => 1,
	),
	'label'           => esc_html__( 'No of Items', 'parallax-frame' ),
	'section'         => 'parallax_frame_logo_slider',
	'settings'        => 'parallax_frame_theme_options[logo_slider_number]',
	'type'            => 'number',
	)
);

$wp_customize->add_setting( 'parallax_frame_theme_options[logo_slider_visible_items]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['logo_slider_visible_items'],
	'sanitize_callback' => 'parallax_frame_sanitize_number_range',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[logo_slider_visible_items]', array(
	'active_callback' => 'parallax_frame_is_demo_logo_slider_inactive',
	'input_attrs'     => array(
	'style'           => 'width: 45px;',
		'min'  => 0,
		'max'  => 5,
		'step' => 1,
	),
	'label'           => esc_html__( 'No of visible items', 'parallax-frame' ),
	'section'         => 'parallax_frame_logo_slider',
	'settings'        => 'parallax_frame_theme_options[logo_slider_visible_items]',
	'type'            => 'number',
) );

//loop for featured post sliders
for ( $i=1; $i <=  $options['logo_slider_number'] ; $i++ ) {
	//page content
	$wp_customize->add_setting( 'parallax_frame_theme_options[logo_slider_page_'. $i .']', array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback'	=> 'parallax_frame_sanitize_page',
	) );

	$wp_customize->add_control( 'parallax_frame_logo_slider_page_'. $i, array(
		'active_callback' => 'parallax_frame_is_demo_logo_slider_inactive',
		'label'           => esc_html__( 'Page ', 'parallax-frame' ) . ' ' . $i ,
		'section'         => 'parallax_frame_logo_slider',
		'settings'        => 'parallax_frame_theme_options[logo_slider_page_'. $i .']',
		'type'            => 'dropdown-pages',
	) );
}