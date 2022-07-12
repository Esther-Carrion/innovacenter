<?php
/**
 * The template for adding color options in Customizer
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */

$wp_customize->add_setting( 'parallax_frame_theme_options[color_scheme]', array(
	'capability' 		=> 'edit_theme_options',
	'default'    		=> $defaults['color_scheme'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$schemes = parallax_frame_color_schemes();

$choices = array();

foreach ( $schemes as $scheme ) {
	$choices[ $scheme['value'] ] = $scheme['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[color_scheme]', array(
	'choices'  => $choices,
	'label'    => esc_html__( 'Color Scheme', 'parallax-frame' ),
	'priority' => 1,
	'section'  => 'colors',
	'settings' => 'parallax_frame_theme_options[color_scheme]',
	'type'     => 'radio',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[footer_sidebar_area_background_image]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['footer_sidebar_area_background_image'],
	'sanitize_callback' => 'parallax_frame_sanitize_image',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'parallax_frame_theme_options[footer_sidebar_area_background_image]', array(
	'label'    => esc_html__( 'Footer Sidebar Area Background Image', 'parallax-frame' ),
	'priority' => 45,
	'section'  => 'background_image',
	'settings' => 'parallax_frame_theme_options[footer_sidebar_area_background_image]',
) ) );