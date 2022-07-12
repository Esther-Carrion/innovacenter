<?php
/**
 * The template for adding Portfolio Settings in Customizer
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */

$wp_customize->add_section( 'parallax_frame_portfolio', array(
	'priority' => 700,
	'title'    => esc_html__( 'Portfolio', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[portfolio_option]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['portfolio_option'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$parallax_frame_featured_slider_content_options = parallax_frame_featured_slider_content_options();
$choices = array();
foreach ( $parallax_frame_featured_slider_content_options as $parallax_frame_featured_slider_content_option ) {
	$choices[$parallax_frame_featured_slider_content_option['value']] = $parallax_frame_featured_slider_content_option['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[portfolio_option]', array(
	'choices'  => $choices,
	'label'    => esc_html__( 'Enable Portfolio on', 'parallax-frame' ),
	'section'  => 'parallax_frame_portfolio',
	'settings' => 'parallax_frame_theme_options[portfolio_option]',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[portfolio_layout]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['portfolio_layout'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$portfolio_layout_options = parallax_frame_featured_content_layout_options();
$choices = array();
foreach ( $portfolio_layout_options as $portfolio_layout_option ) {
	$choices[$portfolio_layout_option['value']] = $portfolio_layout_option['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[portfolio_layout]', array(
	'active_callback' => 'parallax_frame_is_portfolio_active',
	'choices'         => $choices,
	'label'           => esc_html__( 'Select Portfolio Layout', 'parallax-frame' ),
	'section'         => 'parallax_frame_portfolio',
	'settings'        => 'parallax_frame_theme_options[portfolio_layout]',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[portfolio_headline]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['portfolio_headline'],
	'sanitize_callback' => 'wp_kses_post',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[portfolio_headline]' , array(
	'active_callback' => 'parallax_frame_is_portfolio_active',
	'description'     => esc_html__( 'Leave field empty if you want to remove Headline', 'parallax-frame' ),
	'label'           => esc_html__( 'Headline for Portfolio', 'parallax-frame' ),
	'section'         => 'parallax_frame_portfolio',
	'settings'        => 'parallax_frame_theme_options[portfolio_headline]',
	'type'            => 'text',
	)
);

$wp_customize->add_setting( 'parallax_frame_theme_options[portfolio_subheadline]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['portfolio_subheadline'],
	'sanitize_callback' => 'wp_kses_post',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[portfolio_subheadline]' , array(
	'active_callback' => 'parallax_frame_is_portfolio_active',
	'description'     => esc_html__( 'Leave field empty if you want to remove Sub-headline', 'parallax-frame' ),
	'label'           => esc_html__( 'Sub-headline for Portfolio', 'parallax-frame' ),
	'section'         => 'parallax_frame_portfolio',
	'settings'        => 'parallax_frame_theme_options[portfolio_subheadline]',
	'type'            => 'text',
	)
);

$wp_customize->add_setting( 'parallax_frame_theme_options[portfolio_type]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['portfolio_type'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$parallax_frame_portfolio_types = parallax_frame_portfolio_types();
$choices = array();
foreach ( $parallax_frame_portfolio_types as $parallax_frame_portfolio_type ) {
	$choices[$parallax_frame_portfolio_type['value']] = $parallax_frame_portfolio_type['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[portfolio_type]', array(
	'active_callback' => 'parallax_frame_is_portfolio_active',
	'choices'         => $choices,
	'label'           => esc_html__( 'Select Portfolio Type', 'parallax-frame' ),
	'section'         => 'parallax_frame_portfolio',
	'settings'        => 'parallax_frame_theme_options[portfolio_type]',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[portfolio_number]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['portfolio_number'],
	'sanitize_callback' => 'parallax_frame_sanitize_number_range',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[portfolio_number]' , array(
	'active_callback' => 'parallax_frame_is_demo_portfolio_inactive',
	'description'     => esc_html__( 'Save and refresh the page if No. of Portfolio is changed (Max no of Portfolio is 20)', 'parallax-frame' ),
	'input_attrs'     => array(
		'style' => 'width: 45px;',
		'min'   => 0,
		'max'   => 20,
		'step'  => 1,
	),
	'label'           => esc_html__( 'No of Portfolio', 'parallax-frame' ),
	'section'         => 'parallax_frame_portfolio',
	'settings'        => 'parallax_frame_theme_options[portfolio_number]',
	'type'            => 'number',
	)
);

for ( $i=1; $i <=  $options['portfolio_number'] ; $i++ ) {
	$wp_customize->add_setting( 'parallax_frame_theme_options[portfolio_page_'. $i .']', array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback'	=> 'parallax_frame_sanitize_page',
	) );

	$wp_customize->add_control( 'parallax_frame_portfolio_page_'. $i, array(
		'active_callback' => 'parallax_frame_is_demo_portfolio_inactive',
		'label'           => esc_html__( 'Featured Page', 'parallax-frame' ) . ' ' . $i ,
		'section'         => 'parallax_frame_portfolio',
		'settings'        => 'parallax_frame_theme_options[portfolio_page_'. $i .']',
		'type'            => 'dropdown-pages',
	) );
}