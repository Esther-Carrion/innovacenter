<?php
/**
 * The template for adding Hero Content Settings in Customizer
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */

$wp_customize->add_section( 'parallax_frame_hero_content', array(
	'priority' => 500,
	'title'    => esc_html__( 'Hero Content', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[hero_content_option]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['hero_content_option'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$hero_content_options = parallax_frame_featured_slider_content_options();
$choices = array();
foreach ( $hero_content_options as $hero_content_option ) {
	$choices[$hero_content_option['value']] = $hero_content_option['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[hero_content_option]', array(
	'choices'  => $choices,
	'label'    => esc_html__( 'Enable Hero Content on', 'parallax-frame' ),
	'section'  => 'parallax_frame_hero_content',
	'settings' => 'parallax_frame_theme_options[hero_content_option]',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[hero_content_type]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['hero_content_type'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$hero_content_types = parallax_frame_hero_content_types();
$choices = array();
foreach ( $hero_content_types as $hero_content_type ) {
	$choices[$hero_content_type['value']] = $hero_content_type['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[hero_content_type]', array(
	'active_callback' => 'parallax_frame_is_hero_content_active',
	'choices'         => $choices,
	'label'           => esc_html__( 'Select Content Type', 'parallax-frame' ),
	'section'         => 'parallax_frame_hero_content',
	'settings'        => 'parallax_frame_theme_options[hero_content_type]',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[hero_content_number]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['hero_content_number'],
	'sanitize_callback' => 'parallax_frame_sanitize_number_range',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[hero_content_number]' , array(
		'active_callback' => 'parallax_frame_is_demo_hero_content_inactive',
		'description'     => esc_html__( 'Save and refresh the page if No. of Hero Content is changed (Max no of Hero Content is 20)', 'parallax-frame' ),
		'input_attrs'     => array(
			'style' => 'width: 45px;',
			'min'   => 0,
			'max'   => 20,
			'step'  => 1,
		),
		'label'           => esc_html__( 'No of Hero Content', 'parallax-frame' ),
		'section'         => 'parallax_frame_hero_content',
		'settings'        => 'parallax_frame_theme_options[hero_content_number]',
		'type'            => 'number',
		)
);

$wp_customize->add_setting( 'parallax_frame_theme_options[hero_content_enable_title]', array(
		'default'           => $defaults['hero_content_enable_title'],
		'sanitize_callback' => 'parallax_frame_sanitize_checkbox',
	) );

$wp_customize->add_control(  'parallax_frame_theme_options[hero_content_enable_title]', array(
	'active_callback' => 'parallax_frame_is_demo_hero_content_inactive',
	'label'           => esc_html__( 'Check to Enable Title', 'parallax-frame' ),
	'section'         => 'parallax_frame_hero_content',
	'settings'        => 'parallax_frame_theme_options[hero_content_enable_title]',
	'type'            => 'checkbox',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[hero_content_show]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['hero_content_show'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$hero_content_shows = parallax_frame_featured_content_show();
$choices = array();
foreach ( $hero_content_shows as $hero_content_show ) {
	$choices[$hero_content_show['value']] = $hero_content_show['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[hero_content_show]', array(
	'active_callback' => 'parallax_frame_is_demo_hero_content_inactive',
	'choices'         => $choices,
	'label'           => esc_html__( 'Display Content', 'parallax-frame' ),
	'section'         => 'parallax_frame_hero_content',
	'settings'        => 'parallax_frame_theme_options[hero_content_show]',
	'type'            => 'select',
) );

for ( $i=1; $i <=  $options['hero_content_number'] ; $i++ ) {
	//page content
	$wp_customize->add_setting( 'parallax_frame_theme_options[hero_content_page_'. $i .']', array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback'	=> 'parallax_frame_sanitize_page',
	) );

	$wp_customize->add_control( 'parallax_frame_hero_content_page_'. $i, array(
		'active_callback' => 'parallax_frame_is_demo_hero_content_inactive',
		'label'           => esc_html__( 'Page', 'parallax-frame' ) . ' ' . $i ,
		'section'         => 'parallax_frame_hero_content',
		'settings'        => 'parallax_frame_theme_options[hero_content_page_'. $i .']',
		'type'            => 'dropdown-pages',
	) );
}