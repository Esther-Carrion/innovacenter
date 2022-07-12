<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */
?>

<?php
/**
 * parallax_frame_before_secondary hook
 */
do_action( 'parallax_frame_before_secondary' );

$parallax_frame_layout = parallax_frame_get_theme_layout();

//Bail early if no sidebar layout is selected
if ( 'no-sidebar' == $parallax_frame_layout ) {
	return;
}

do_action( 'parallax_frame_before_primary_sidebar' );
?>
	<aside class="sidebar sidebar-primary widget-area" role="complementary">
		<?php
		if ( is_active_sidebar( 'primary-sidebar' ) ) {
        	dynamic_sidebar( 'primary-sidebar' );
   		}
		else {
			//Helper Text
			if ( current_user_can( 'edit_theme_options' ) ) { ?>
				<section id="widget-default-text" class="widget widget_text">
					<div class="widget-wrap">
	                	<h4 class="widget-title"><?php esc_html_e( 'Primary Sidebar Widget Area', 'parallax-frame' ); ?></h4>

	           			<div class="textwidget">
	                   		<p><?php esc_html_e( 'This is the Primary Sidebar Widget Area if you are using a two column site layout option.', 'parallax-frame' ); ?></p>
	                   		<p><?php printf( esc_html__( 'By default it will load Search and Archives widgets as shown below. You can add widget to this area by visiting your %1$s Widgets Panel%2$s which will replace default widgets.', 'parallax-frame' ), '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">', '</a>' ); ?></p>
	                 	</div>
	           		</div><!-- .widget-wrap -->
	       		</section><!-- #widget-default-text -->
			<?php
			} ?>
			<section class="widget widget_search" id="default-search">
				<div class="widget-wrap">
					<?php get_search_form(); ?>
				</div><!-- .widget-wrap -->
			</section><!-- #default-search -->
			<section class="widget widget_archive" id="default-archives">
				<div class="widget-wrap">
					<h4 class="widget-title"><?php esc_html_e( 'Archives', 'parallax-frame' ); ?></h4>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</div><!-- .widget-wrap -->
			</section><!-- #default-archives -->
			<?php
		}
	?>
	</aside><!-- .sidebar sidebar-primary widget-area -->
<?php
/**
 * parallax_frame_after_primary_sidebar hook
 */
do_action( 'parallax_frame_after_primary_sidebar' );


/**
 * parallax_frame_after_secondary hook
 *
 */
do_action( 'parallax_frame_after_secondary' );
