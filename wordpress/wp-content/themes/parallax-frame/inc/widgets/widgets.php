<?php
/**
 * The template for adding Custom Sidebars and Widgets
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */

/**
 * Register widgetized area
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_widgets_init() {
	//Primary Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'parallax-frame' ),
		'id'            => 'primary-sidebar',
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
		'after_widget'  => '</div><!-- .widget-wrap --></section><!-- #widget-default-search -->',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
		'description'	=> esc_html__( 'This is the primary sidebar if you are using a two column site layout option.', 'parallax-frame' ),
	) );

	$footer_sidebar_number = 3; //Number of footer sidebars

	for( $i=1; $i <= $footer_sidebar_number; $i++ ) {
		register_sidebar( array(
			'name'          => sprintf( esc_html__( 'Footer Area %d', 'parallax-frame' ), $i ),
			'id'            => sprintf( 'footer-%d', $i ),
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'after_widget'  => '</div><!-- .widget-wrap --></section><!-- #widget-default-search -->',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
			'description'	=> sprintf( esc_html__( 'Footer %d widget area.', 'parallax-frame' ), $i ),
		) );
	}
}
add_action( 'widgets_init', 'parallax_frame_widgets_init' );

/**
 * Loads up Necessary JS Scripts for widgets
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_widgets_scripts( $hook) {
	if ( 'widgets.php' == $hook ) {
		wp_enqueue_style( 'parallax-frame-widgets-styles', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/widgets.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'parallax_frame_widgets_scripts' );

// Load Featured Post Widget
include get_template_directory() . '/inc/widgets/featured-posts.php';

// Load Social Icon Widget
include get_template_directory() . '/inc/widgets/social-icons.php';

// Load Newsletter Widget
include get_template_directory() . '/inc/widgets/tag-cloud.php';
