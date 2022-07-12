<?php
/**
 * The main template for implementing Theme/Customzer Options
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */


/**
 * Implements Parallax Frame theme options into Theme Customizer.
 *
 * @param $wp_customize Theme Customizer object
 * @return void
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport			= 'postMessage';

	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$options  = parallax_frame_get_theme_options();

	$defaults = parallax_frame_get_default_theme_options();

	$wp_customize->add_setting( 'parallax_frame_theme_options[hide_tagline]', array(
		'default'			=> $defaults['hide_tagline'],
		'sanitize_callback' => 'parallax_frame_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'parallax_frame_theme_options[hide_tagline]', array(
		'label'    => esc_html__( 'Check to Hide Site Description/Tagline', 'parallax-frame' ),
		'priority' => 50,
		'section'  => 'title_tagline',
		'settings' => 'parallax_frame_theme_options[hide_tagline]',
		'type'     => 'checkbox',
	) );

	//Custom Controls
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/custom-controls.php';

	$wp_customize->add_setting( 'parallax_frame_theme_options[move_title_tagline]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['move_title_tagline'],
		'sanitize_callback' => 'parallax_frame_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'parallax_frame_theme_options[move_title_tagline]', array(
		'label'    => esc_html__( 'Check to move Site Title and Tagline before logo', 'parallax-frame' ),
		'priority' => 10,
		'section'  => 'title_tagline',
		'settings' => 'parallax_frame_theme_options[move_title_tagline]',
		'type'     => 'checkbox',
	) );

	// Header Options (added to Header section in Theme Customizer)
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/header-options.php';

	//Theme Options
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/theme-options.php';

	// Color Options
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/color-options.php';

	//Header Highlight Content
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/header-highlight-content.php';

	//Featured Slider
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/featured-slider.php';

	//Hero Content
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/hero-content.php';

	//Featured Content
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/featured-content.php';

	//Portfolio
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/portfolio.php';

	//Logo Slider
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/logo-slider.php';

	//Social Links
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/social-icons.php';

	// Reset all settings to default
	$wp_customize->add_section( 'parallax_frame_reset_all_settings', array(
		'description'	=> esc_html__( 'Caution: Reset all settings to default. Refresh the page after save to view full effects.', 'parallax-frame' ),
		'priority' 		=> 1100,
		'title'    		=> esc_html__( 'Reset all settings', 'parallax-frame' ),
	) );

	$wp_customize->add_setting( 'parallax_frame_theme_options[reset_all_settings]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['reset_all_settings'],
		'sanitize_callback' => 'parallax_frame_sanitize_checkbox',
		'transport'			=> 'postMessage',
	) );

	$wp_customize->add_control( 'parallax_frame_theme_options[reset_all_settings]', array(
		'label'    => esc_html__( 'Check to reset all settings to default', 'parallax-frame' ),
		'section'  => 'parallax_frame_reset_all_settings',
		'settings' => 'parallax_frame_theme_options[reset_all_settings]',
		'type'     => 'checkbox',
	) );
	// Reset all settings to default end


	//Important Links
	$wp_customize->add_section( 'important_links', array(
		'priority' 		=> 9999,
		'title'   	 	=> esc_html__( 'Important Links', 'parallax-frame' ),
	) );

	/**
	 * Has dummy Sanitizaition function as it contains no value to be sanitized
	 */
	$wp_customize->add_setting( 'important_links', array(
		'sanitize_callback'	=> 'sanitize_text_field',
	) );

	$wp_customize->add_control( new parallax_frame_important_links( $wp_customize, 'important_links', array(
        'label'   	=> esc_html__( 'Important Links', 'parallax-frame' ),
         'section'  	=> 'important_links',
        'settings' 	=> 'important_links',
        'type'     	=> 'important_links',
    ) ) );
    //Important Links End
}
add_action( 'customize_register', 'parallax_frame_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously for parallaxframe.
 * And flushes out all transient data on preview
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_customize_preview() {
	wp_enqueue_script( 'parallax_frame_customizer', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/customizer.min.js', array( 'customize-preview' ), '20120827', true );

	//Flush transients
	parallax_frame_flush_transients();
}
add_action( 'customize_preview_init', 'parallax_frame_customize_preview' );


/**
 * Custom scripts and styles on customize.php for parallaxframe.
 *
 * @since Catch Base Pro 1.0
 */
function parallax_frame_customize_scripts() {
	wp_enqueue_script( 'parallax_frame_customizer_custom', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/customizer-custom-scripts.min.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20150630', true );

	$parallax_frame_data = array(
		'parallax_frame_color_list' => parallax_frame_color_list(),
		'reset_message'             => esc_html__( 'Refresh the customizer page after saving to view reset effects', 'parallax-frame' )
	);

	// Send list of color variables as object to custom customizer js
	wp_localize_script( 'parallax_frame_customizer_custom', 'parallax_frame_data', $parallax_frame_data );
}
add_action( 'customize_controls_enqueue_scripts', 'parallax_frame_customize_scripts');



/**
 * Returns list of color keys of array with default values for each color scheme as index
 *
 * @since Parallax Frame 0.1.1
 */
function parallax_frame_color_list() {
	// Get default color scheme values
	$default      = parallax_frame_get_default_theme_options();
	// Get default dark color scheme valies
	$default_dark = parallax_frame_default_dark_color_options();

	$color_list['background_color']['light'] = $default['background_color'];
	$color_list['background_color']['dark']  = $default_dark['background_color'];

	$color_list['header_textcolor']['light'] = $default['header_textcolor'];
	$color_list['header_textcolor']['dark']  = $default_dark['header_textcolor'];

	return $color_list;
}


/**
 * Function to reset date with respect to condition
 */
function parallax_frame_reset_data() {
	$options  = parallax_frame_get_theme_options();
    if ( $options['reset_all_settings'] ) {
    	remove_theme_mods();

        // Flush out all transients	on reset
        parallax_frame_flush_transients();

        return;
    }
}
add_action( 'customize_save_after', 'parallax_frame_reset_data' );

//Active callbacks for customizer
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/active-callbacks.php';


//Sanitize functions for customizer
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/sanitize-functions.php';

// Add Upgrade to Pro Button.
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/upgrade-button/class-customize.php';
