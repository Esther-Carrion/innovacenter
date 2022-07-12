<?php
/**
 * The template for displaying the Slider
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */



if ( !function_exists( 'parallax_frame_featured_slider' ) ) :
/**
 * Add slider.
 *
 * @uses action hook parallax_frame_before_content.
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_featured_slider() {
	//parallax_frame_flush_transients();
	global $wp_query;

	// get data value from options
	$options 		= parallax_frame_get_theme_options();
	$enable_slider 	= $options['featured_slider_option'];

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');

	if ( 'entire-site' == $enable_slider  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_slider  ) ) {
		if ( ( !$parallax_frame_featured_slider = get_transient( 'parallax_frame_featured_slider' ) ) ) {
			echo '<!-- refreshing cache -->';

			$parallax_frame_featured_slider = '
				<section id="feature-slider">
					<div class="wrapper">
						<div class="cycle-slideshow"
						    data-cycle-log="false"
						    data-cycle-pause-on-hover="true"
						    data-cycle-swipe="true"
						    data-cycle-fx="fadeout"
							data-cycle-speed="'. esc_attr( $options['featured_slider_transition_length'] ) * 1000 .'"
							data-cycle-timeout="'. esc_attr( $options['featured_slider_transition_delay'] ) * 1000 .'"
							data-cycle-loader="'. esc_attr( $options['featured_slider_image_loader'] ) .'"
							data-cycle-slides="> article"
							>

						    <!-- prev/next links -->
						    <div class="cycle-prev"></div>
						    <div class="cycle-next"></div>

						    <!-- empty element for pager links -->
	    					<div class="cycle-pager"></div>';

	    					$select_slider 	= $options['featured_slider_type'];

							// Select Slider
							if ( 'demo-featured-slider' == $select_slider ) {
								$parallax_frame_featured_slider .=  parallax_frame_demo_slider( $options );
							}
							elseif ( 'featured-page-slider' == $select_slider ) {
								$parallax_frame_featured_slider .=  parallax_frame_post_page_category_slider( $options );
							}

			$parallax_frame_featured_slider .= '
						</div><!-- .cycle-slideshow -->
					</div><!-- .wrapper -->
				</section><!-- #feature-slider -->';

			set_transient( 'parallax_frame_featured_slider', $parallax_frame_featured_slider, 86940 );
		}
		echo $parallax_frame_featured_slider;
	}
}
endif;
add_action( 'parallax_frame_before_content', 'parallax_frame_featured_slider', 20 );


if ( ! function_exists( 'parallax_frame_demo_slider' ) ) :
/**
 * This function to display featured posts slider
 *
 * @get the data value from customizer options
 *
 * @since Parallax Frame 0.1
 *
 */
function parallax_frame_demo_slider( $options ) {
	return '
	<article class="post demo-image-1 hentry slides displayblock">
		<figure class="slider-image">
			<a title="Slider Image 1" href="'. esc_url( home_url( '/' ) ) .'">
				<img src="'.esc_url( get_template_directory_uri() ).'/images/gallery/slider1-1920x1080.jpg" class="wp-post-image" alt="Slider Image 1" title="Slider Image 1">
			</a>
		</figure>
		<div class="entry-container">
			<header class="entry-header">
				<h2 class="entry-title">
					<a title="Slider Image 1" href="#"><span>Slider Image 1</span></a>
				</h2>
				<div class="screen-reader-text"><span class="post-time">Posted on <time pubdate="" datetime="2014-08-16T10:56:23+00:00" class="entry-date updated">16 August, 2014</time></span><span class="post-author">By <span class="author vcard"><a rel="author" title="View all posts by Catch Themes" href="#" class="url fn n">Catch Themes</a></span></span></div>
			</header>
			<div class="entry-content">
				<p>Slider Image 1 Content <span class="readmore"><a href="#" class="more-link">' . $options['excerpt_more_text'] . '</a></span></p>
			</div>
		</div>
	</article><!-- .slides -->

	<article class="post demo-image-2 hentry slides displaynone">
		<figure class="Slider Image 2">
			<a title="Slider Image 2" href="'. esc_url( home_url( '/' ) ) .'">
				<img src="'. trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1920x800.jpg" class="wp-post-image" alt="Slider Image 2" title="Slider Image 2">
			</a>
		</figure>
		<div class="entry-container">
			<header class="entry-header">
				<h2 class="entry-title">
					<a title="Slider Image 2" href="#"><span>Slider Image 2</span></a>
				</h2>
				<div class="screen-reader-text"><span class="post-time">Posted on <time pubdate="" datetime="2014-08-16T10:56:23+00:00" class="entry-date updated">16 August, 2014</time></span><span class="post-author">By <span class="author vcard"><a rel="author" title="View all posts by Catch Themes" href="#" class="url fn n">Catch Themes</a></span></span></div>
			</header>
			<div class="entry-content">
				<p>Slider Image 2 Content <span class="readmore"><a href="#" class="more-link">' . $options['excerpt_more_text'] . '</a></span></p>
			</div>
		</div>
	</article><!-- .slides --> ';
}
endif; // parallax_frame_demo_slider


if ( ! function_exists( 'parallax_frame_post_page_category_slider' ) ) :
/**
 * This function to display featured post, page or category slider
 *
 * @param $options: parallax_frame_theme_options from customizer
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_post_page_category_slider( $options ) {
	global $post;

	$quantity   = $options['featured_slider_number'];
	$no_of_post = 0; // for number of posts
	$post_list  = array();// list of valid post/page ids
	$type       = $options['featured_slider_type'];
	$more_text  = $options['excerpt_more_text'];
	$output     = '';

	$args = array(
		'post_type'           => 'any',
		'orderby'             => 'post__in',
		'ignore_sticky_posts' => 1 // ignore sticky posts
	);

	//Get valid number of posts
	if ( 'featured-post-slider' == $type || 'featured-page-slider' == $type  ) {
		for( $i = 1; $i <= $quantity; $i++ ){
			$post_id = '';

			if ( 'featured-post-slider' == $type ) {
				$post_id = isset( $options['featured_slider_post_' . $i] ) ? $options['featured_slider_post_' . $i] : false;
			}
			elseif ( 'featured-page-slider' == $type ) {
				$post_id = isset( $options['featured_slider_page_' . $i] ) ? $options['featured_slider_page_' . $i] : false;
			}

			if ( $post_id && '' != $post_id ) {
				$post_list = array_merge( $post_list, array( $post_id ) );

				$no_of_post++;
			}
		}

		$args['post__in'] = $post_list;
	}
	elseif ( 'featured-category-slider' == $type ) {
		$no_of_post = $quantity;

		$args['category__in'] = (array) $options['featured_slider_select_category'];
	}

	if ( 0 == $no_of_post ) {
		return;
	}

	$args['posts_per_page'] = $no_of_post;

	$loop = new WP_Query( $args );

	$i=0;
	while ( $loop->have_posts()) : $loop->the_post(); $i++;

		$title_attribute = the_title_attribute( array( 'before' => esc_html__( 'Permalink to: ', 'parallax-frame' ), 'echo' => false ) );
		$excerpt = get_the_excerpt();
		if ( $i == 1 ) { $classes = 'post post-'.$post->ID.' hentry slides displayblock'; } else { $classes = 'post post-'.$post->ID.' hentry slides displaynone'; }

		$output .= '
		<article class="'.$classes.'">
			<figure class="slider-image">';
			if ( has_post_thumbnail() ) {
				$output .= '<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">
					'. get_the_post_thumbnail( $post->ID, 'parallax-frame-slider', array( 'title' => $title_attribute, 'alt' => $title_attribute, 'class' => 'attached-post-image', 'loading' => false ) ).'
				</a>';
			}
			else {
				//Default value if there is no first image
				$image = '<img class="pngfix wp-post-image" src="'.esc_url( get_template_directory_uri() ).'/images/gallery/no-featured-image-1680x720.jpg" >';

				//Get the first image in page, returns false if there is no image
				$first_image = parallax_frame_get_first_image( $post->ID, 'parallax-frame-slider', array( 'title' => $title_attribute, 'alt' => $title_attribute, 'class' => 'attached-post-image' ) );

				//Set value of image as first image if there is an image present in the page
				if ( '' != $first_image ) {
					$image =	$first_image;
				}

				$output .= '<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">
					'. $image .'
				</a>';
			}

			$output .= '
			</figure><!-- .slider-image -->
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">'.the_title( '<span>','</span>', false ).'</a>
					</h2>
					<div class="screen-reader-text">'. parallax_frame_page_post_meta().'</div>
				</header>';
				if ( $excerpt !='') {
					$output .= '<div class="entry-content"><p>'. $excerpt.'</p></div>';
				}
				$output .= '
			</div><!-- .entry-container -->
		</article><!-- .slides -->';
	endwhile;

	wp_reset_postdata();

	return $output;
}
endif; // parallax_frame_post_slider
