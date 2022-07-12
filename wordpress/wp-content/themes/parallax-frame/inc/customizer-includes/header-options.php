<?php
/**
 * The template for adding Additional Header Option in Customizer
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */


$wp_customize->add_setting( 'parallax_frame_theme_options[enable_featured_header_image]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['enable_featured_header_image'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$parallax_frame_enable_featured_header_image_options = parallax_frame_enable_featured_header_image_options();
$choices = array();
foreach ( $parallax_frame_enable_featured_header_image_options as $parallax_frame_enable_featured_header_image_option ) {
	$choices[$parallax_frame_enable_featured_header_image_option['value']] = $parallax_frame_enable_featured_header_image_option['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[enable_featured_header_image]', array(
		'choices'  	=> $choices,
		'label'		=> esc_html__( 'Enable Featured Header Image on ', 'parallax-frame' ),
		'section'   => 'header_image',
        'settings'  => 'parallax_frame_theme_options[enable_featured_header_image]',
        'type'	  	=> 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_image_size]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_image_size'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_image_size]', array(
		'choices'  	=> parallax_frame_featured_image_size_options(),
		'label'		=> esc_html__( 'Page/Post Featured Image Size', 'parallax-frame' ),
		'section'   => 'header_image',
		'settings'  => 'parallax_frame_theme_options[featured_image_size]',
		'type'	  	=> 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_header_title]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_header_title'],
	'sanitize_callback' => 'wp_kses_post',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_header_title]', array(
		'label'		=> esc_html__( 'Title', 'parallax-frame' ),
		'section'   => 'header_image',
        'settings'  => 'parallax_frame_theme_options[featured_header_title]',
        'type'	  	=> 'text',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_header_content]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_header_content'],
	'sanitize_callback' => 'wp_kses_post',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_header_content]', array(
	'label'		=> esc_html__( 'Content', 'parallax-frame' ),
	'section'   => 'header_image',
    'settings'  => 'parallax_frame_theme_options[featured_header_content]',
    'type'	  	=> 'textarea',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_header_button_text]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_header_button_text'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_header_button_text]', array(
	'label'		=> esc_html__( 'Button Text', 'parallax-frame' ),
	'section'   => 'header_image',
    'settings'  => 'parallax_frame_theme_options[featured_header_button_text]',
    'type'	  	=> 'textarea',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_header_button_link]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_header_button_link'],
	'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_header_button_link]', array(
		'label'		=> esc_html__( 'Button Link', 'parallax-frame' ),
		'section'   => 'header_image',
        'settings'  => 'parallax_frame_theme_options[featured_header_button_link]',
        'type'	  	=> 'text',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_header_button_target]', array(
	'capability'		=> 'edit_theme_options',
	'sanitize_callback' => 'parallax_frame_sanitize_checkbox',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_header_button_target]', array(
	'label'    	=> esc_html__( 'Check to Open Link in New Window/Tab', 'parallax-frame' ),
	'section'  	=> 'header_image',
	'settings' 	=> 'parallax_frame_theme_options[featured_header_button_target]',
	'type'     	=> 'checkbox',
) );