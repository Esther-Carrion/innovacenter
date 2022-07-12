<?php
/**
* The template for Social Links in Customizer
*
* @package Catch Themes
* @subpackage Parallax Frame
* @since Parallax Frame 0.1
*/


$wp_customize->add_panel( 'parallax_frame_social_links', array(
    'capability'     => 'edit_theme_options',
    'description'	=> esc_html__( 'Note: Enter the url for correponding social networking website', 'parallax-frame' ),
    'priority'       => 1000,
	'title'    		 => esc_html__( 'Social Links', 'parallax-frame' ),
) );

$wp_customize->add_section( 'parallax_frame_social_links', array(
	'panel'			=> 'parallax_frame_social_links',
	'priority' 		=> 1,
	'title'   	 	=> esc_html__( 'Social Links', 'parallax-frame' ),
) );

$parallax_frame_social_icons 	=	parallax_frame_get_social_icons_list();

foreach ( $parallax_frame_social_icons as $key => $value ){
	if ( 'skype_link' == $key ){
		$wp_customize->add_setting( 'parallax_frame_theme_options['. $key .']', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback' => 'esc_attr',
			) );

		$wp_customize->add_control( 'parallax_frame_theme_options['. $key .']', array(
			'description'	=> esc_html__( 'Skype link can be of formats:<br>callto://+{number}<br> skype:{username}?{action}. More Information in readme file', 'parallax-frame' ),
			'label'    		=> $value['label'],
			'section'  		=> 'parallax_frame_social_links',
			'settings' 		=> 'parallax_frame_theme_options['. $key .']',
			'type'	   		=> 'url',
		) );
	}
	else {
		if ( 'email_link' == $key ){
			$wp_customize->add_setting( 'parallax_frame_theme_options['. $key .']', array(
					'capability'		=> 'edit_theme_options',
					'sanitize_callback' => 'sanitize_email',
				) );
		}
		elseif ( 'handset_link' == $key || 'phone_link' == $key ){
			$wp_customize->add_setting( 'parallax_frame_theme_options['. $key .']', array(
					'capability'		=> 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				) );
		}
		else {
			$wp_customize->add_setting( 'parallax_frame_theme_options['. $key .']', array(
					'capability'		=> 'edit_theme_options',
					'sanitize_callback' => 'esc_url_raw',
				) );
		}

		$wp_customize->add_control( 'parallax_frame_theme_options['. $key .']', array(
			'label'    => $value['label'],
			'section'  => 'parallax_frame_social_links',
			'settings' => 'parallax_frame_theme_options['. $key .']',
			'type'	   => 'url',
		) );
	}
}