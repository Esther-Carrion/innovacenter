<?php
/**
 * The template for adding Featured Content Settings in Customizer
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */

$wp_customize->add_panel( 'parallax_frame_featured_content', array(
    'capability'     => 'edit_theme_options',
	'description'    => esc_html__( 'Featured Content Options', 'parallax-frame' ),
    'priority'       => 800,
    'title'    		 => esc_html__( 'Featured Content', 'parallax-frame' ),
) );

$wp_customize->add_section( 'parallax_frame_featured_content', array(
	'panel'			=> 'parallax_frame_featured_content',
	'priority'		=> 1,
	'title'			=> esc_html__( 'Featured Content Options', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_option]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_option'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$parallax_frame_featured_slider_content_options = parallax_frame_featured_slider_content_options();
$choices = array();
foreach ( $parallax_frame_featured_slider_content_options as $parallax_frame_featured_slider_content_option ) {
	$choices[$parallax_frame_featured_slider_content_option['value']] = $parallax_frame_featured_slider_content_option['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[featured_content_option]', array(
	'choices'  => $choices,
	'label'    => esc_html__( 'Enable Featured Content on', 'parallax-frame' ),
	'section'  => 'parallax_frame_featured_content',
	'settings' => 'parallax_frame_theme_options[featured_content_option]',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_layout]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_layout'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$parallax_frame_featured_content_layout_options = parallax_frame_featured_content_layout_options();
$choices = array();
foreach ( $parallax_frame_featured_content_layout_options as $parallax_frame_featured_content_layout_option ) {
	$choices[$parallax_frame_featured_content_layout_option['value']] = $parallax_frame_featured_content_layout_option['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[featured_content_layout]', array(
	'active_callback' => 'parallax_frame_is_featured_content_active',
	'choices'         => $choices,
	'label'           => esc_html__( 'Select Featured Content Layout', 'parallax-frame' ),
	'section'         => 'parallax_frame_featured_content',
	'settings'        => 'parallax_frame_theme_options[featured_content_layout]',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_position]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_position'],
	'sanitize_callback' => 'parallax_frame_sanitize_checkbox'
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_content_position]', array(
	'active_callback' => 'parallax_frame_is_featured_content_active',
	'label'           => esc_html__( 'Check to Move above Footer', 'parallax-frame' ),
	'section'         => 'parallax_frame_featured_content',
	'settings'        => 'parallax_frame_theme_options[featured_content_position]',
	'type'            => 'checkbox',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_slider]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['featured_content_slider'],
	'sanitize_callback' => 'parallax_frame_sanitize_checkbox'
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_content_slider]', array(
	'active_callback' => 'parallax_frame_is_featured_content_active',
	'label'           => esc_html__( 'Check to Enable Slider', 'parallax-frame' ),
	'section'         => 'parallax_frame_featured_content',
	'settings'        => 'parallax_frame_theme_options[featured_content_slider]',
	'type'            => 'checkbox',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_type]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['featured_content_type'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$parallax_frame_featured_content_types = parallax_frame_featured_content_types();
$choices = array();
foreach ( $parallax_frame_featured_content_types as $parallax_frame_featured_content_type ) {
	$choices[$parallax_frame_featured_content_type['value']] = $parallax_frame_featured_content_type['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[featured_content_type]', array(
	'active_callback' => 'parallax_frame_is_featured_content_active',
	'choices'         => $choices,
	'label'           => esc_html__( 'Select Content Type', 'parallax-frame' ),
	'section'         => 'parallax_frame_featured_content',
	'settings'        => 'parallax_frame_theme_options[featured_content_type]',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_headline]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['featured_content_headline'],
	'sanitize_callback' => 'wp_kses_post',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_content_headline]' , array(
	'active_callback' => 'parallax_frame_is_demo_featured_content_inactive',
	'description'     => esc_html__( 'Leave field empty if you want to remove Headline', 'parallax-frame' ),
	'label'           => esc_html__( 'Headline for Featured Content', 'parallax-frame' ),
	'section'         => 'parallax_frame_featured_content',
	'settings'        => 'parallax_frame_theme_options[featured_content_headline]',
	'type'            => 'text',
	)
);

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_subheadline]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['featured_content_subheadline'],
	'sanitize_callback' => 'wp_kses_post',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_content_subheadline]' , array(
	'active_callback' => 'parallax_frame_is_demo_featured_content_inactive',
	'description'     => esc_html__( 'Leave field empty if you want to remove Sub-headline', 'parallax-frame' ),
	'label'           => esc_html__( 'Sub-headline for Featured Content', 'parallax-frame' ),
	'section'         => 'parallax_frame_featured_content',
	'settings'        => 'parallax_frame_theme_options[featured_content_subheadline]',
	'type'            => 'text',
	)
);

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_number]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['featured_content_number'],
	'sanitize_callback' => 'parallax_frame_sanitize_number_range',
) );

$wp_customize->add_control( 'parallax_frame_theme_options[featured_content_number]' , array(
		'active_callback' => 'parallax_frame_is_demo_featured_content_inactive',
		'description'     => esc_html__( 'Save and refresh the page if No. of Featured Content is changed (Max no of Featured Content is 20)', 'parallax-frame' ),
		'input_attrs'     => array(
			'style' => 'width: 45px;',
			'min'   => 0,
			'max'   => 20,
			'step'  => 1,
		),
		'label'           => esc_html__( 'No of Featured Content', 'parallax-frame' ),
		'section'         => 'parallax_frame_featured_content',
		'settings'        => 'parallax_frame_theme_options[featured_content_number]',
		'type'            => 'number',
		)
);

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_enable_title]', array(
		'default'           => $defaults['featured_content_enable_title'],
		'sanitize_callback' => 'parallax_frame_sanitize_checkbox',
	) );

$wp_customize->add_control(  'parallax_frame_theme_options[featured_content_enable_title]', array(
	'active_callback' => 'parallax_frame_is_demo_featured_content_inactive',
	'label'           => esc_html__( 'Check to Enable Title', 'parallax-frame' ),
	'section'         => 'parallax_frame_featured_content',
	'settings'        => 'parallax_frame_theme_options[featured_content_enable_title]',
	'type'            => 'checkbox',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_show]', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['featured_content_show'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$parallax_frame_featured_content_show = parallax_frame_featured_content_show();
$choices = array();
foreach ( $parallax_frame_featured_content_show as $parallax_frame_featured_content_shows ) {
	$choices[$parallax_frame_featured_content_shows['value']] = $parallax_frame_featured_content_shows['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[featured_content_show]', array(
	'active_callback' => 'parallax_frame_is_demo_featured_content_inactive',
	'choices'         => $choices,
	'label'           => esc_html__( 'Display Content', 'parallax-frame' ),
	'section'         => 'parallax_frame_featured_content',
	'settings'        => 'parallax_frame_theme_options[featured_content_show]',
	'type'            => 'select',
) );

$priority	=	7;

for ( $i=1; $i <=  $options['featured_content_number'] ; $i++ ) {
	$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_page_'. $i .']', array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback'	=> 'parallax_frame_sanitize_page',
	) );

	$wp_customize->add_control( 'parallax_frame_featured_content_page_'. $i, array(
		'active_callback' => 'parallax_frame_is_demo_featured_content_inactive',
		'label'           => esc_html__( 'Featured Page', 'parallax-frame' ) . ' ' . $i ,
		'section'         => 'parallax_frame_featured_content',
		'settings'        => 'parallax_frame_theme_options[featured_content_page_'. $i .']',
		'type'            => 'dropdown-pages',
	) );
}

$wp_customize->add_section( 'parallax_frame_featured_content_background_settings', array(
	'description'	=> esc_html__( 'Make sure Featured Content is enabled for these options to work', 'parallax-frame' ),
	'panel'			=> 'parallax_frame_featured_content',
	'title'			=> esc_html__( 'Featured Content Background Settings', 'parallax-frame' ),
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_background_image]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_background_image'],
		'sanitize_callback'	=> 'esc_url_raw',
	) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'parallax_frame_theme_options[featured_content_background_image]', array(
	'label'		=> esc_html__( 'Select/Add Background Image', 'parallax-frame' ),
	'default'   => $defaults['featured_content_background_image'],
	'section'   => 'parallax_frame_featured_content_background_settings',
    'settings'  => 'parallax_frame_theme_options[featured_content_background_image]',
) ) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_background_display_position]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_background_display_position'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$parallax_frame_featured_content_background_display_positions = parallax_frame_featured_content_background_display_positions();
$choices = array();
foreach ( $parallax_frame_featured_content_background_display_positions as $parallax_frame_featured_content_background_display_position ) {
	$choices[$parallax_frame_featured_content_background_display_position['value']] = $parallax_frame_featured_content_background_display_position['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[featured_content_background_display_position]', array(
	'choices'  	=> $choices,
	'label'    	=> esc_html__( 'Display Position', 'parallax-frame' ),
	'section'  	=> 'parallax_frame_featured_content_background_settings',
	'settings' 	=> 'parallax_frame_theme_options[featured_content_background_display_position]',
	'type'	  	=> 'radio',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_background_repeat]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_background_repeat'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$parallax_frame_featured_content_background_repeat_options = parallax_frame_featured_content_background_repeat_options();
$choices = array();
foreach ( $parallax_frame_featured_content_background_repeat_options as $parallax_frame_featured_content_background_repeat_option ) {
	$choices[$parallax_frame_featured_content_background_repeat_option['value']] = $parallax_frame_featured_content_background_repeat_option['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[featured_content_background_repeat]', array(
	'choices'  	=> $choices,
	'label'    	=> esc_html__( 'Repeat', 'parallax-frame' ),
	'section'  	=> 'parallax_frame_featured_content_background_settings',
	'settings' 	=> 'parallax_frame_theme_options[featured_content_background_repeat]',
	'type'	  	=> 'radio',
) );

$wp_customize->add_setting( 'parallax_frame_theme_options[featured_content_background_attachment]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_background_attachment'],
	'sanitize_callback' => 'parallax_frame_sanitize_select',
) );

$parallax_frame_featured_content_background_attachment_options = parallax_frame_featured_content_background_attachment_options();
$choices = array();
foreach ( $parallax_frame_featured_content_background_attachment_options as $parallax_frame_featured_content_background_attachment_option ) {
	$choices[$parallax_frame_featured_content_background_attachment_option['value']] = $parallax_frame_featured_content_background_attachment_option['label'];
}

$wp_customize->add_control( 'parallax_frame_theme_options[featured_content_background_attachment]', array(
	'choices'  	=> $choices,
	'label'    	=> esc_html__( 'Attachment', 'parallax-frame' ),
	'section'  	=> 'parallax_frame_featured_content_background_settings',
	'settings' 	=> 'parallax_frame_theme_options[featured_content_background_attachment]',
	'type'	  	=> 'radio',
) );