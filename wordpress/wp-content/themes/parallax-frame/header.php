<?php
/**
 * The default template for displaying header
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */

	/**
	 * parallax_frame_doctype hook
	 *
	 * @hooked parallax_frame_doctype -  10
	 *
	 */
	do_action( 'parallax_frame_doctype' );?>

<head>
<?php
	/**
	 * parallax_frame_before_wp_head hook
	 *
	 * @hooked parallax_frame_head -  10
	 *
	 */
	do_action( 'parallax_frame_before_wp_head' );

	wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'wp_body_open' );  ?>

<?php
	/**
     * parallax_frame_before_header hook
     *
     * @hooked parallax_frame_masthead -  10
     *
     */
    do_action( 'parallax_frame_before' );

	/**
	 * parallax_frame_site_branding hook
	 *
	 * @hooked parallax_frame_page_start -  10
	 * @hooked parallax_frame_header_start - 20
	 * @hooked parallax_frame_site_branding - 30
	 * @hooked parallax_frame_primary_menu - 40
	 * @hooked parallax_frame_header_end - 50
	 *
	 */
	do_action( 'parallax_frame_header' );

	/**
     * parallax_frame_after_header hook
     *
     * @hooked parallax_frame_header_div - 10
     */
	do_action( 'parallax_frame_after_header' );

	/**
	 * parallax_frame_before_content hook
	 *
	 * @hooked parallax_frame_featured_slider - 10
	 * @hooked parallax_frame_hero_content_display - 20
	 * @hooked parallax_frame_header_highlight_content_display - 30
	 * @hooked parallax_frame_featured_content_display (featured content - default position) - 40
	 * @hooked parallax_frame_add_breadcrumb - 50
	 * @hooked parallax_frame_promotion_headline - 60
	 * @hooled parallax_frame_logo_slider -70
	 */
	do_action( 'parallax_frame_before_content' );

	/**
     * parallax_frame_main hook
     *
     * @hooked parallax_frame_content_start - 20
     *
     */
	do_action( 'parallax_frame_content' );