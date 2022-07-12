<?php
/**
 * The template for displaying the Featured Content
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */


if ( !function_exists( 'parallax_frame_header_highlight_content_display' ) ) :
/**
* Add Featured content.
*
* @uses action hook parallax_frame_before_content.
*
* @since Parallax Frame 0.1
*/
function parallax_frame_header_highlight_content_display() {
	//parallax_frame_flush_transients();
	global $post, $wp_query;

	// get data value from options
	$options        = parallax_frame_get_theme_options();
	$enable_content = $options['header_highlight_content_option'];
	$content_select = $options['header_highlight_content_type'];

	// Front page displays in Reading Settings
	$page_on_front 	= get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');


	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	if ( 'entire-site' == $enable_content  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_content  ) ) {
		if ( !$output = get_transient( 'parallax_frame_header_highlight_content' ) ) {

			echo '<!-- refreshing cache -->';
			$classes[] = $content_select;

			$content_number = $options['header_highlight_content_number'];
			$headline       = $options['header_highlight_content_headline'];
			$subheadline    = $options['header_highlight_content_subheadline'];

			$classes[] = ' layout-' . $content_number;

			$output ='
				<section id="header-highlights-content" class="' . esc_attr( implode( ' ', $classes ) ) . '">
					<div class="wrapper">';
						if ( !empty( $headline ) || !empty( $subheadline ) ) {
							$output .='
							<div class="header-highlight-heading-wrap">';
								if ( !empty( $headline ) ) {
									$output .='
									<h2 id="header-highlight-heading" class="section-title">'. wp_kses_post( $headline ) .'</h2>';
								}
								if ( !empty( $subheadline ) ) {
									$output .='
									<p>'. wp_kses_post( $subheadline ) .'</p>';
								}
							$output .='
							</div><!-- .header-highlight-heading-wrap -->';
						}

						$output .='
						<div class="header-highlight-content-wrap">';
							// Select content
							if ( 'demo-header-highlight-content' == $content_select ) {
								$output .= parallax_frame_demo_header_highlight_content( $options );
							}
							elseif ( 'header-highlight-page-content' == $content_select ) {
								$output .= parallax_frame_header_highlight_post_page_category_content( $options );
							}

			$output .='
						</div><!-- .header-highlight-content-wrap -->
					</div><!-- .wrapper -->
				</section><!-- #header-highlight-content -->';
			set_transient( 'parallax_frame_header_highlight_content', $output, 86940 );

		}
		echo $output;
	}
}
endif;
add_action( 'parallax_frame_before_content', 'parallax_frame_header_highlight_content_display', 30 );


if ( ! function_exists( 'parallax_frame_demo_content' ) ) :
/**
 * This function to display header highlight posts content
 *
 * @get the data value from customizer options
 *
 * @since Parallax Frame 0.1
 *
 */
function parallax_frame_demo_header_highlight_content( $options ) {
	$parallax_frame_demo_content = '
		<article id="large-featured-image" class="post hentry post-demo">
			<figure class="header-highlight-content-image">
				<a rel="bookmark" href="#">
					<img alt="Photography" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1920x800.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a href="#">Photography</a>
					</h2>
				</header>
				<footer class="entry-footer">
					<p class="entry-meta">
						<span class="cat-links">
							<span class="screen-reader-text">Categories</span>
							<a rel="category tag" href="#">Music</a>
						</span>
						<span class="posted-on">
							<span class="screen-reader-text">Posted on</span>

							<a rel="bookmark" href="#">
								<time datetime="2016-05-15T04:29:55+00:00" class="entry-date published">May 7, 2016</time>

								<time datetime="2016-05-08T08:47:27+00:00" class="updated">May 7, 2016</time>
							</a>
						</span>
					</p><!-- .entry-meta -->
				</footer>
			</div><!-- .entry-container -->
		</article>

		<article id="header-highlight-post-1" class="post hentry post-demo">
			<figure class="header-highlight-content-image">
				<a rel="bookmark" href="#">
					<img alt="Female Rockstar" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a href="#">Female Rockstar</a>
					</h2>
				</header>
				<footer class="entry-footer">
					<p class="entry-meta">
						<span class="cat-links">
							<span class="screen-reader-text">Categories</span>
							<a rel="category tag" href="#">Concert</a>
						</span>
						<span class="posted-on">
							<span class="screen-reader-text">Posted on</span>

							<a rel="bookmark" href="#">
								<time datetime="2016-05-15T04:29:55+00:00" class="entry-date published">May 7, 2016</time>

								<time datetime="2016-05-08T08:47:27+00:00" class="updated">May 7, 2016</time>
							</a>
						</span>
					</p><!-- .entry-meta -->
				</footer>
			</div><!-- .entry-container -->
		</article>

		<article id="header-highlight-post-2" class="post hentry post-demo">
			<figure class="header-highlight-content-image">
				<a rel="bookmark" href="#">
					<img alt="iPhoneography" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a href="#">iPhoneography</a>
					</h2>
				</header>
				<footer class="entry-footer">
					<p class="entry-meta">
						<span class="cat-links">
							<span class="screen-reader-text">Categories</span>
							<a rel="category tag" href="#">Photography</a>
						</span>
						<span class="posted-on">
							<span class="screen-reader-text">Posted on</span>
							<a rel="bookmark" href="#">
								<time datetime="2016-05-15T04:29:55+00:00" class="entry-date published">May 7, 2016</time>
								<time datetime="2016-05-08T08:47:27+00:00" class="updated">May 7, 2016</time>
							</a>
						</span>
					</p><!-- .entry-meta -->
				</footer>
			</div><!-- .entry-container -->
		</article>

		<article id="header-highlight-post-3" class="post hentry post-demo">
			<figure class="header-highlight-content-image">
				<a href="#">
					<img alt="Wildlife Photography" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a href="#">Wildlife Photography</a>
					</h2>
				</header>
				<footer class="entry-footer">
					<p class="entry-meta">
						<span class="cat-links">
							<span class="screen-reader-text">Categories</span>
							<a rel="category tag" href="#">Photography</a>
						</span>
						<span class="posted-on">
							<span class="screen-reader-text">Posted on</span>
							<a rel="bookmark" href="#">
								<time datetime="2016-05-15T04:29:55+00:00" class="entry-date published">May 7, 2016</time>
								<time datetime="2016-05-08T08:47:27+00:00" class="updated">May 7, 2016</time>
							</a>
						</span>
					</p><!-- .entry-meta -->
				</footer>
			</div><!-- .entry-container -->
		</article>

		<article id="header-highlight-post-4" class="post hentry post-demo">
			<figure class="header-highlight-content-image">
				<a href="#">
					<img alt="Dirt Bike Ride" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
				</a>
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a title="Best Beaches" href="#">Dirt Bike Ride</a>
					</h2>
				</header>
				<footer class="entry-footer">
					<p class="entry-meta">
						<span class="cat-links">
							<span class="screen-reader-text">Categories</span>
							<a rel="category tag" href="#">Bike</a>
						</span>
						<span class="posted-on">
							<span class="screen-reader-text">Posted on</span>

							<a rel="bookmark" href="#">
								<time datetime="2016-05-15T04:29:55+00:00" class="entry-date published">May 7, 2016</time>

								<time datetime="2016-05-08T08:47:27+00:00" class="updated">May 7, 2016</time>
							</a>
						</span>
					</p><!-- .entry-meta -->
				</footer>
			</div><!-- .entry-container -->
		</article>
		';

	return $parallax_frame_demo_content;
}
endif; // parallax_frame_demo_header_highlight_content


if ( ! function_exists( 'parallax_frame_header_highlight_post_page_category_content' ) ) :
/**
 * This function to display header highlight posts content
 *
 * @param $options: parallax_frame_theme_options from customizer
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_header_highlight_post_page_category_content( $options ) {
	global $post;

	$quantity     = $options['header_highlight_content_number'];
	$no_of_post   = 0; // for number of posts
	$post_list    = array();// list of valid post/page ids
	$type         = $options['header_highlight_content_type'];
	$more_text    = $options['excerpt_more_text'];
	$show_content = $options['header_highlight_content_show'];
	$output       = '';

	$args = array(
		'post_type'           => 'any',
		'orderby'             => 'post__in',
		'ignore_sticky_posts' => 1 // ignore sticky posts
	);

	//Get valid number of posts
	if ( 'header-highlight-post-content' == $type || 'header-highlight-page-content' == $type  ) {
		for( $i = 1; $i <= $quantity; $i++ ){
			$post_id = '';

			if ( 'header-highlight-post-content' == $type ) {
				$post_id = isset( $options['header_highlight_content_post_' . $i] ) ? $options['header_highlight_content_post_' . $i] : false;
			}
			elseif ( 'header-highlight-page-content' == $type ) {
				$post_id = isset( $options['header_highlight_content_page_' . $i] ) ? $options['header_highlight_content_page_' . $i] : false;
			}

			if ( $post_id && '' != $post_id ) {
				$post_list = array_merge( $post_list, array( $post_id ) );
				$no_of_post++;
			}
		}

		$args['post__in'] = $post_list;
	}
	elseif ( 'header-highlight-category-content' == $type ) {
		$no_of_post = $quantity;

		$args['category__in'] = (array) $options['header_highlight_content_select_category'];
	}

	if ( 0 == $no_of_post ) {
		return;
	}

	$args['posts_per_page'] = $no_of_post;

	$loop = new WP_Query( $args );

	$i=0;

	while ( $loop->have_posts() ) {
		$loop->the_post();

		$title_attribute = the_title_attribute( array( 'before' => esc_html__( 'Permalink to: ', 'parallax-frame' ), 'echo' => false ) );

		$excerpt = get_the_excerpt();

		if ( 0 == $i ) {
			//Set image name to parallax-frame-slider 1920x800, if it is the first image
			$image_size = 'parallax-frame-slider';
			$article_id = 'large-featured-image';
		}
		else {
			//Set image name to post-thumbnail 480x320, if it is not the first image
			$image_size = 'post-thumbnail';
			$article_id = 'header-highlight-post-' . $i;
		}

		$output .= '
		<article id="' . $article_id . '" class="post hentry header-highlight-post-content">';
		if ( has_post_thumbnail() ) {
			//Pull post thunbnail if it is present
			$thumbnail = get_the_post_thumbnail(
				$post->ID,
				$image_size,
				array(
					'title' => $title_attribute,
					'alt' => $title_attribute
				)
			);
		}
		else {
			$first_image = parallax_frame_get_first_image(
				$post->ID,
				$image_size,
				array(
					'title' => $title_attribute,
					'alt' => $title_attribute
					)
				);

			if ( '' != $first_image ) {
				$thumbnail = $first_image;
			}
			else {
				$thumbnail = '<img class="wp-post-image" src="'.esc_url( get_template_directory_uri() ).'/images/gallery/no-featured-image-1920x800.jpg" >';
			}
		}

		$output .= '
			<figure class="header-highlight-homepage-image">
				<a href="' . esc_url( get_permalink() ) . '">
				'. $thumbnail .'
				</a>
			</figure>';

		$output .= '
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . the_title( '','', false ) . '</a>
					</h2>
				</header>';

				if ( 'excerpt' == $show_content ) {
					$output .= '<div class="entry-summary"><p>' . $excerpt . '</p></div><!-- .entry-summary -->';
				}
				elseif ( 'full-content' == $show_content ) {
					$content = apply_filters( 'the_content', get_the_content() );
					$content = str_replace( ']]>', ']]&gt;', $content );
					$output .= '<div class="entry-content">' . wp_kses_post( $content ). '</div><!-- .entry-content -->';
				}

				$footer_class = '';

				if ( $options['header_highlight_content_hide_category'] &&  $options['header_highlight_content_hide_tags'] && $options['header_highlight_content_hide_date'] && $options['header_highlight_content_hide_author'] ) {
					$footer_class = 'screen-reader-text';
				}

				$output .= '
				<footer class="entry-footer ' . $footer_class . '">
					' . parallax_frame_get_meta(
							$options['header_highlight_content_hide_category'],
							$options['header_highlight_content_hide_tags'],
							$options['header_highlight_content_hide_date'],
							$options['header_highlight_content_hide_author']
						) . '
				</footer><!-- .entry-footer -->';

			$output .= '
			</div><!-- .entry-container -->
		</article><!-- .header-highlight-post-'. $i .' -->';

		$i++;
	}

	wp_reset_postdata();

	return $output;
}
endif; // $parallax_frame_header_highlight_post_page_category_content
