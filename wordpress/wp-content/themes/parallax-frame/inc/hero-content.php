<?php
/**
 * The template for displaying the Featured Content
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */



if ( !function_exists( 'parallax_frame_hero_content_display' ) ) :
/**
* Add Featured content.
*
* @uses action hook parallax_frame_before_content.
*
* @since Parallax Frame 0.1
*/
function parallax_frame_hero_content_display() {
	//parallax_frame_flush_transients();

	global $wp_query;

	// get data value from options
	$options        = parallax_frame_get_theme_options();
	$enable_content = $options['hero_content_option'];
	$content_select = $options['hero_content_type'];

	// Front page displays in Reading Settings
	$page_on_front 	= get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');


	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	if ( 'entire-site' == $enable_content  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_content  ) ) {
		if ( ( !$output = get_transient( 'parallax_frame_hero_content' ) ) ) {
			echo '<!-- refreshing cache -->';

			$classes[] = $content_select ;

			$output ='
				<section id="hero-section" class="' . implode( ' ', $classes ) . '">
					<div class="wrapper">';
						// Select content
						if ( 'demo-hero-content' == $content_select ) {
							$output .= parallax_frame_demo_hero_content();
						}
						elseif ( 'hero-page-content' == $content_select ) {
							$output .= parallax_frame_post_page_category_hero_content( $options );
						}
				$output .='
					</div><!-- .wrapper -->
				</section><!-- #hero-section -->';

			set_transient( 'parallax_frame_hero_content', $output, 86940 );
		}
	echo $output;
	}
}
endif;
add_action( 'parallax_frame_before_content', 'parallax_frame_hero_content_display', 20 );


if ( ! function_exists( 'parallax_frame_demo_hero_content' ) ) :
/**
 * This function to display hero posts content
 *
 * @get the data value from customizer options
 *
 * @since Parallax Frame 0.1
 *
 */
function parallax_frame_demo_hero_content() {
	return '
	<article class="post-11 page type-page status-publish has-post-thumbnail hentry" id="post-11">
		<figure class="featured-image">
	    	<a href="#" rel="bookmark">
	        	<img width="600" height="400" alt="" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/about-600x400.jpg">
	        </a>
		</figure>
		<div class="entry-container">
			<header class="entry-header">
				<h2 class="entry-title">About</h2>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<p>This site is using the standard WordPress Theme Unit Test Data for <strong>content</strong>.</p>
				<p>The Theme Unit Test is a series of posts and pages that match up with a checklist on the WordPress codex.</p>
				<p>This site is using the standard WordPress Theme Unit Test Data for content. The Theme Unit Test is a series of posts and pages that match up with a checklist on the WordPress codex.</p>
				<p>You can use the data and checklist together to test your theme.</p>
			</div><!-- .entry-content -->
		</div><!-- .entry-container -->
	</article>';
}
endif; // parallax_frame_demo_hero_content


if ( ! function_exists( 'parallax_frame_post_page_category_hero_content' ) ) :
/**
 * This function to display hero posts content
 *
 * @param $options: parallax_frame_theme_options from customizer
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_post_page_category_hero_content( $options ) {
	global $post;

	$quantity   = $options['hero_content_number'];
	$no_of_post = 0; // for number of posts
	$post_list  = array();// list of valid post/page ids
	$type       = $options['hero_content_type'];
	$output     = '';

	$args = array(
		'post_type'           => 'any',
		'orderby'             => 'post__in',
		'ignore_sticky_posts' => 1 // ignore sticky posts
	);

	//Get valid number of posts
	if ( 'hero-post-content' == $type || 'hero-page-content' == $type ) {
		for( $i = 1; $i <= $quantity; $i++ ){
			$post_id = '';

			if ( 'hero-post-content' == $type ) {
				$post_id = isset( $options['hero_content_post_' . $i] ) ? $options['hero_content_post_' . $i] : false;
			}
			elseif ( 'hero-page-content' == $type ) {
				$post_id = isset( $options['hero_content_page_' . $i] ) ? $options['hero_content_page_' . $i] : false;
			}

			if ( $post_id && '' != $post_id ) {
				$post_list = array_merge( $post_list, array( $post_id ) );

				$no_of_post++;
			}
		}

		$args['post__in'] = $post_list;
	}
	elseif ( 'hero-category-content' == $type ) {
		$no_of_post           = $quantity;
		$args['category__in'] = (array) $options['hero_content_select_category'];
	}

	if ( 0 == $no_of_post ) {
		return;
	}

	$args['posts_per_page'] = $no_of_post;

	$get_hero_posts         = new WP_Query( $args );

	$i=0;
	while ( $get_hero_posts->have_posts() ) {
		$get_hero_posts->the_post();

		$i++;

		$title_attribute = the_title_attribute( array( 'before' => esc_html__( 'Permalink to:', 'parallax-frame' ), 'echo' => false ) );

		$output .= '
			<article id="post-' . $i . '" class="post-' . $i . ' hentry has-post-thumbnail">';

			//Default value if there is no first image
			$image = '<img class="pngfix wp-post-image" src="'.esc_url( get_template_directory_uri() ).'/images/gallery/no-featured-image-1680x720.jpg" >';

			if ( has_post_thumbnail() ) {
				$image = get_the_post_thumbnail( $post->ID, 'parallax-frame-featured-content', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );
			}
			else {
				//Get the first image in page, returns false if there is no image
				$first_image = parallax_frame_get_first_image( $post->ID, 'parallax-frame-hero-content', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );

				//Set value of image as first image if there is an image present in the page
				if ( '' != $first_image ) {
					$image = $first_image;
				}
			}

			$output .= '
				<figure class="featured-image">
					<a href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">
					'. $image .'
					</a>
				</figure>';

			if ( $options['hero_content_enable_title'] || 'hide-content' != $options['hero_content_show'] ) {
			$output .= '
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . the_title( '','', false ) . '</a>
						</h2>
					</header>';

				if ( 'excerpt' == $options['hero_content_show'] ) {
					//Show Excerpt
					$output .= '
					<div class="entry-content">
						<p>' . get_the_excerpt() . '</p>
					</div><!-- .entry-content -->';
				}
				elseif ( 'full-content' == $options['hero_content_show'] ) {
					//Show Content
					$content = apply_filters( 'the_content', get_the_content() );
					$content = str_replace( ']]>', ']]&gt;', $content );
					$output .= '<div class="entry-content">' . wp_kses_post( $content ) . '</div><!-- .entry-content -->';
				}
			}
			$output .= '
				</div><!-- .entry-container -->
			</article><!-- .post-'. $i .' -->';
		} //endwhile

	wp_reset_postdata();

	return $output;
}
endif; // parallax_frame_post_page_category_hero_content
