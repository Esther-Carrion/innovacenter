<?php
/**
 * The Template for displaying all single posts
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'single' ); ?>

		<?php
			/**
			 * parallax_frame_after_post hook
			 *
			 * @hooked parallax_frame_post_navigation - 10
			 */
			do_action( 'parallax_frame_after_post' );

			/**
			 * parallax_frame_comment_section hook
			 *
			 * @hooked parallax_frame_get_comment_section - 10
			 */
			do_action( 'parallax_frame_comment_section' );
		?>
	<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>