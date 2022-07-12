<?php
/**
 * The template for displaying the Featured Content
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */



if ( !function_exists( 'parallax_frame_featured_content_display' ) ) :
/**
* Add Featured content.
*
* @uses action hook parallax_frame_before_content.
*
* @since Parallax Frame 0.1
*/
function parallax_frame_featured_content_display() {
	//parallax_frame_flush_transients();

	global $wp_query;

	// get data value from options
	$options        = parallax_frame_get_theme_options();
	$enable_content = $options['featured_content_option'];
	$content_select = $options['featured_content_type'];
	$slider_select  = $options['featured_content_slider'];

	// Front page displays in Reading Settings
	$page_on_front 	= get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');


	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	if ( 'entire-site' == $enable_content  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_content  ) ) {
		if ( ( !$output = get_transient( 'parallax_frame_featured_content' ) ) ) {
			$layouts 	 = $options['featured_content_layout'];
			$headline 	 = $options['featured_content_headline'];
			$subheadline = $options['featured_content_subheadline'];

			echo '<!-- refreshing cache -->';

			if ( !empty( $layouts ) ) {
				$classes = $layouts ;
			}

			$classes .= ' ' . $content_select ;

			if ( 'demo-featured-content' == $content_select ) {
				$headline    = esc_html__( 'Featured Content', 'parallax-frame' );
				$subheadline = esc_html__( 'Here you can showcase the x number of Featured Content. You can edit this Headline, Subheadline and Feaured Content from "Appearance -> Customize -> Featured Content Options".', 'parallax-frame' );
			}

			if ( '1' == $options['featured_content_position'] ) {
				$classes .= ' border-top' ;
			}

			$output ='
				<section id="featured-content" class="' . $classes . '">
					<div class="wrapper">';
						if ( !empty( $headline ) || !empty( $subheadline ) ) {
							$output .='<div class="featured-heading-wrap">';
								if ( !empty( $headline ) ) {
									$output .='<h2 id="featured-heading" class="section-title">'.  wp_kses_post ( $headline ) .'</h2>';
								}
								if ( !empty( $subheadline ) ) {
									$output .='<p>'. wp_kses_post ( $subheadline ) .'</p>';
								}
							$output .='</div><!-- .featured-heading-wrap -->';
						}
						$output .='
						<div class="featured-content-wrap">';

							if ( $slider_select ) {
								$output .='
								<!-- prev/next links -->
								<div id="content-controls">
									<div id="content-prev"></div>
									<div id="content-next"></div>
								</div>
								<div class="cycle-slideshow"
								    data-cycle-log="false"
								    data-cycle-pause-on-hover="true"
								    data-cycle-swipe="true"
								    data-cycle-auto-height=container
									data-cycle-slides=".featured_content_slider_wrap"
									data-cycle-fx="scrollHorz"
									data-cycle-prev="#content-prev"
        							data-cycle-next="#content-next"
									>';
							 }

							// Select content
							if ( 'demo-featured-content' == $content_select ) {
								$output .= parallax_frame_demo_content( $options );
							}
							elseif ( 'featured-page-content' == $content_select ) {
								$output .= parallax_frame_post_page_category_content( $options );
							}

							if ( $slider_select ) {
								$output .='
								</div><!-- .cycle-slideshow -->';
							}

			$output .='
						</div><!-- .featured-content-wrap -->
					</div><!-- .wrapper -->
				</section><!-- #featured-content -->';
		set_transient( 'parallax_frame_featured_content', $output, 86940 );
		}
	echo $output;
	}
}
endif;


if ( ! function_exists( 'parallax_frame_featured_content_display_position' ) ) :
/**
 * Homepage Featured Content Position
 *
 * @action parallax_frame_content, parallax_frame_after_secondary
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_featured_content_display_position() {
	// Getting data from Theme Options
	$options 		= parallax_frame_get_theme_options();

	if ( $options['featured_content_position'] ) {
		add_action( 'parallax_frame_after_content', 'parallax_frame_featured_content_display', 30 );
	}
	else {
		add_action( 'parallax_frame_before_content', 'parallax_frame_featured_content_display', 40 );
	}
}
endif; // parallax_frame_featured_content_display_position
add_action( 'parallax_frame_before', 'parallax_frame_featured_content_display_position' );


if ( ! function_exists( 'parallax_frame_demo_content' ) ) :
/**
 * This function to display featured posts content
 *
 * @get the data value from customizer options
 *
 * @since Parallax Frame 0.1
 *
 */
function parallax_frame_demo_content( $options ) {
	// Getting data from Theme Options
	$options 		= parallax_frame_get_theme_options();

	$output = '
	<div class="featured_content_slider_wrap">
		<article id="featured-post-1" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a href="#" rel="bookmark">Photo Shoot</a>
					</h2>
				</header>
				<div class="entry-content">
					A photo shoot is generally used in the fashion or glamour industry, whereby a model poses for a photographer at a studio or an outdoor location where multiple photos are taken.
				</div>
			</div><!-- .entry-container -->
		</article>

		<article id="featured-post-2" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a href="#" rel="bookmark">iPhoneography</a>
					</h2>
				</header>
				<div class="entry-content">
					iPhoneography is the art of creating photos with an iPhone. This is a style differs from all other forms of digital photography in that images are both shot and processed on the iOS device.
				</div>
			</div><!-- .entry-container -->
		</article>

		<article id="featured-post-3" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a href="#" rel="bookmark">Wildlife Photography</a>
					</h2>
				</header>
				<div class="entry-content">
					Wildlife photography is a genre of photography concerned with documenting various forms of wildlife in their natural habitat. It is one of the more challenging forms of photography.
				</div>
			</div><!-- .entry-container -->
		</article>';

	if ( 'layout-four' == $options['featured_content_layout']) {
		$output .= '
		<article id="featured-post-4" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a href="#" rel="bookmark">Sports photography</a>
					</h2>
				</header>
				<div class="entry-content">
					Sports photography refers to the genre of photography that covers all types of sports. In the majority of cases, professional sports photography is a branch of photojournalism.
				</div>
			</div><!-- .entry-container -->
		</article>';
	}
	$output .= '</div><!-- .featured_content_slider_wrap -->';

	if ( '1' == $options['featured_content_slider'] ) {
		$output .= '
		<div class="featured_content_slider_wrap">
			<article id="featured-post-5" class="post hentry post-demo">
				<figure class="featured-content-image">
					<img class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
				</figure>
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#" rel="bookmark">Photo Shoot</a>
						</h2>
					</header>
					<div class="entry-content">
						A photo shoot is generally used in the fashion or glamour industry, whereby a model poses for a photographer at a studio or an outdoor location where multiple photos are taken.
					</div>
				</div><!-- .entry-container -->
			</article>

			<article id="featured-post-6" class="post hentry post-demo">
				<figure class="featured-content-image">
					<img class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
				</figure>
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#" rel="bookmark">iPhoneography</a>
						</h2>
					</header>
					<div class="entry-content">
						iPhoneography is the art of creating photos with an iPhone. This is a style differs from all other forms of digital photography in that images are both shot and processed on the iOS device.
					</div>
				</div><!-- .entry-container -->
			</article>

			<article id="featured-post-7" class="post hentry post-demo">
				<figure class="featured-content-image">
					<img class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
				</figure>
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#" rel="bookmark">Wildlife Photography</a>
						</h2>
					</header>
					<div class="entry-content">
						Wildlife photography is a genre of photography concerned with documenting various forms of wildlife in their natural habitat. It is one of the more challenging forms of photography.
					</div>
				</div><!-- .entry-container -->
			</article>';

		if ( 'layout-four' == $options['featured_content_layout']) {
			$output .= '
			<article id="featured-post-8" class="post hentry post-demo">
				<figure class="featured-content-image">
					<img class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
				</figure>
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="#" rel="bookmark">Sports photography</a>
						</h2>
					</header>
					<div class="entry-content">
						Sports photography refers to the genre of photography that covers all types of sports. In the majority of cases, professional sports photography is a branch of photojournalism.
					</div>
				</div><!-- .entry-container -->
			</article>';
		}
		$output .= '</div><!-- .featured_content_slider_wrap -->';
	}

	return $output;
}
endif; // parallax_frame_demo_content


if ( ! function_exists( 'parallax_frame_post_page_category_content' ) ) :
/**
 * This function to display featured posts content
 *
 * @param $options: parallax_frame_theme_options from customizer
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_post_page_category_content( $options ) {
	global $post;

	$quantity   = $options['featured_content_number'];
	$no_of_post = 0; // for number of posts
	$post_list  = array();// list of valid post/page ids
	$type       = $options['featured_content_type'];
	$more_text  = $options['excerpt_more_text'];
	$layouts    = 3;

	$output     = '<div class="featured_content_slider_wrap">';

	if ( 'layout-four' == $options['featured_content_layout'] ) {
		$layouts = 4;
	}

	$args = array(
		'post_type'           => 'any',
		'orderby'             => 'post__in',
		'ignore_sticky_posts' => 1 // ignore sticky posts
	);

	//Get valid number of posts
	if ( 'featured-post-content' == $type || 'featured-page-content' == $type  ) {
		for( $i = 1; $i <= $quantity; $i++ ){
			$post_id = '';

			if ( 'featured-post-content' == $type ) {
				$post_id = isset( $options['featured_content_post_' . $i] ) ? $options['featured_content_post_' . $i] : false;
			}
			elseif ( 'featured-page-content' == $type ) {
				$post_id = isset( $options['featured_content_page_' . $i] ) ? $options['featured_content_page_' . $i] : false;
			}

			if ( $post_id && '' != $post_id ) {
				$post_list = array_merge( $post_list, array( $post_id ) );

				$no_of_post++;
			}
		}

		$args['post__in'] = $post_list;
	}
	elseif ( 'featured-category-content' == $type ) {
		$no_of_post = $quantity;

		$args['category__in'] = (array) $options['featured_content_select_category'];
	}

	if ( 0 == $no_of_post ) {
		return;
	}

	$args['posts_per_page'] = $no_of_post;

	$loop = new WP_Query( $args );

	$i=0;
	while ( $loop->have_posts() ) {

		$loop->the_post();

		$i++;

		$title_attribute = the_title_attribute( array( 'before' => esc_html__( 'Permalink to:', 'parallax-frame' ), 'echo' => false ) );

		$output .= '
			<article id="featured-post-' . $i . '" class="post hentry featured-post-content">';

			//Default value if there is no first image
			$image = '<img class="pngfix wp-post-image" src="'.esc_url( get_template_directory_uri() ).'/images/gallery/no-featured-image-1680x720.jpg" >';

			if ( has_post_thumbnail() ) {
				$image = get_the_post_thumbnail( $post->ID, 'parallax-frame-featured-content', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );
			}
			else {
				//Get the first image in page, returns false if there is no image
				$first_image = parallax_frame_get_first_image( $post->ID, 'parallax-frame-featured-content', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );

				//Set value of image as first image if there is an image present in the page
				if ( '' != $first_image ) {
					$image = $first_image;
				}
			}

			$output .= '
				<figure class="featured-homepage-image">
					<a href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">
					'. $image .'
					</a>
				</figure>';

			if ( $options['featured_content_enable_title'] || 'hide-content' != $options['featured_content_show'] ) {
			$output .= '
				<div class="entry-container">';
				if ( $options['featured_content_enable_title'] ) {
					$output .= '
						<header class="entry-header">
							<h2 class="entry-title">
								<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . the_title( '','', false ) . '</a>
							</h2>
						</header>';
				}

				if ( 'excerpt' == $options['featured_content_show'] ) {
					//Show Excerpt
					$output .= '<div class="entry-excerpt"><p>' . get_the_excerpt() . '</p></div><!-- .entry-excerpt -->';
				}
				elseif ( 'full-content' == $options['featured_content_show'] ) {
					//Show Content
					$content = apply_filters( 'the_content', get_the_content() );
					$content = str_replace( ']]>', ']]&gt;', $content );
					$output .= '<div class="entry-content">' . wp_kses_post( $content ) . '</div><!-- .entry-content -->';
				}
			}
			$output .= '
			</article><!-- .featured-post-'. $i .' -->';

			if ( 0 == ( $i % $layouts ) && $i < $no_of_post ) {
				//end and start featured_content_slider_wrap div based on logic
				$output .= '
			</div><!-- .featured_content_slider_wrap -->

			<div class="featured_content_slider_wrap">';
			}
		} //endwhile

	wp_reset_postdata();

	$output .= '</div><!-- .featured_content_slider_wrap -->';

	return $output;
}
endif; // parallax_frame_post_page_category_content
