<?php
/**
 * The template for displaying the Featured Content
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */



if ( !function_exists( 'parallax_frame_portfolio_display' ) ) :
/**
* Add Featured content.
*
* @uses action hook parallax_frame_before_content.
*
* @since Parallax Frame 0.1
*/
function parallax_frame_portfolio_display() {
	// parallax_frame_flush_transients();
	global $post, $wp_query;

	// get data value from options
	$options        = parallax_frame_get_theme_options();
	$enable_content = $options['portfolio_option'];
	$content_select = $options['portfolio_type'];

	// Front page displays in Reading Settings
	$page_on_front 	= get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');


	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	if ( 'entire-site' == $enable_content  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_content  ) ) {
		if ( ( !$output = get_transient( 'parallax_frame_portfolio' ) ) ) {
			$layouts 	 = $options['portfolio_layout'];
			$headline 	 = $options['portfolio_headline'];
			$subheadline = $options['portfolio_subheadline'];

			echo '<!-- refreshing cache -->';

			if ( !empty( $layouts ) ) {
				$classes = $layouts ;
			}

			$classes .= ' ' . $content_select;

			if ( 'demo-portfolio' == $content_select  ) {
				$headline 		= esc_html__( 'Portfolio', 'parallax-frame' );
				$subheadline 	= esc_html__( 'Here you can showcase the x number of Portfolios.', 'parallax-frame' );
			}

			$output ='
			<section class="' . $classes . '" id="portfolio">
				<div class="wrapper">';
				if ( !empty( $headline ) || !empty( $subheadline ) ) {
					$output .='
					<div class="portfolio-heading-wrap">';
								if ( !empty( $headline ) ) {
									$output .='<h2 class="section-title">'.  wp_kses_post( $headline ) .'</h2>';
								}
								if ( !empty( $subheadline ) ) {
									$output .='<p>'. wp_kses_post( $subheadline ) .'</p>';
								}
							$output .='
					</div><!-- .portfolio-heading-wrap -->';
					}

					$output .='<div class="portfolio-content-wrap clear">';
						// Select portfolio
						if ( 'demo-portfolio' == $content_select ) {
							$output .= parallax_frame_demo_portfolio( $options );
						}
						elseif ( 'post-portfolio' == $content_select || 'page-portfolio' == $content_select || 'category-portfolio' == $content_select ) {
							$output .= parallax_frame_post_page_category_portfolio( $options );
						}
						elseif ( 'image-portfolio' == $content_select  ) {
							$output .= parallax_frame_image_portfolio( $options );
						}

			$output .='
					</div><!-- .portfolio-content-wrap -->
				</div><!-- .wrapper -->
			</section><!-- .demo-portfolio -->';

			set_transient( 'parallax_frame_portfolio', $output, 86940 );
		}

		echo $output;
	}
} //parallax_frame_portfolio_display
endif;
add_action( 'parallax_frame_before_content', 'parallax_frame_portfolio_display', 40 );


if ( ! function_exists( 'parallax_frame_demo_portfolio' ) ) :
/**
 * This function to display featured posts content
 *
 * @get the data value from customizer options
 *
 * @since Parallax Frame 0.1
 *
 */
function parallax_frame_demo_portfolio( $options ) {
	return '
	<article id="portfolio-post-1" class="post hentry post-demo">
		<figure class="portfolio-content-image featured-image">
			<a rel="bookmark" href="#">
				<img alt="White Velvet Concert" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
			</a>
		</figure>
		<div class="entry-container">
			<header class="entry-header">
				<h2 class="entry-title">
					<a href="#">White Velvet Concert</a>
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

	<article id="portfolio-post-2" class="post hentry post-demo">
		<figure class="portfolio-content-image featured-image">
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

	<article id="portfolio-post-3" class="post hentry post-demo">
		<figure class="portfolio-content-image featured-image">
			<a href="#">
				<img alt="Great Vocalist" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
			</a>
		</figure>
		<div class="entry-container">
			<header class="entry-header">
				<h2 class="entry-title">
					<a href="#">Great Vocalist</a>
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

	<article id="portfolio-post-4" class="post hentry post-demo">
		<figure class="portfolio-content-image featured-image">
			<a href="#">
				<img alt="Best Rock Band" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
			</a>
		</figure>
		<div class="entry-container">
			<header class="entry-header">
				<h2 class="entry-title">
					<a title="Best Beaches" href="#">Best Rock Band</a>
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

	<article id="portfolio-post-5" class="post hentry post-demo">
		<figure class="portfolio-content-image featured-image">
			<a rel="bookmark" href="#">
				<img alt="White Velvet Concert" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
			</a>
		</figure>
		<div class="entry-container">
			<header class="entry-header">
				<h2 class="entry-title">
					<a href="#">White Velvet Concert</a>
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

	<article id="portfolio-post-6" class="post hentry post-demo">
		<figure class="portfolio-content-image featured-image">
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

	<article id="portfolio-post-7" class="post hentry post-demo">
		<figure class="portfolio-content-image featured-image">
			<a href="#">
				<img alt="Great Vocalist" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
			</a>
		</figure>
		<div class="entry-container">
			<header class="entry-header">
				<h2 class="entry-title">
					<a href="#">Great Vocalist</a>
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

	<article id="portfolio-post-8" class="post hentry post-demo">
		<figure class="portfolio-content-image featured-image">
			<a href="#">
				<img alt="Best Rock Band" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/no-featured-image-1680x720.jpg" />
			</a>
		</figure>
		<div class="entry-container">
			<header class="entry-header">
				<h2 class="entry-title">
					<a title="Best Beaches" href="#">Best Rock Band</a>
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
	</article>';
}
endif; // parallax_frame_demo_portfolio


if ( ! function_exists( 'parallax_frame_post_page_category_portfolio' ) ) :
/**
 * This function to display featured posts content
 *
 * @param $options: parallax_frame_theme_options from customizer
 *
 * @since Parallax Frame 0.1
 */
function parallax_frame_post_page_category_portfolio( $options ) {
	global $post;

	$quantity   = $options['portfolio_number'];
	$no_of_post = 0; // for number of posts
	$post_list  = array();// list of valid post/page ids
	$type       = $options['portfolio_type'];
	$more_text  = $options['excerpt_more_text'];
	$layouts    = 3;

	$output     = '<div class="portfolio_slider_wrap">';

	$args = array(
		'post_type'           => 'any',
		'orderby'             => 'post__in',
		'ignore_sticky_posts' => 1 // ignore sticky posts
	);

	//Get valid number of posts
	if ( 'post-portfolio' == $type || 'page-portfolio' == $type  ) {
		for( $i = 1; $i <= $quantity; $i++ ){
			if ( 'post-portfolio' == $type ) {
				$post_id = isset( $options['portfolio_post_' . $i] ) ? $options['portfolio_post_' . $i] : false;
			}
			elseif ( 'page-portfolio' == $type ) {
				$post_id = isset( $options['portfolio_page_' . $i] ) ? $options['portfolio_page_' . $i] : false;
			}

			if ( $post_id && '' != $post_id ) {
				$post_list = array_merge( $post_list, array( $post_id ) );

				$no_of_post++;
			}
		}

		$args['post__in'] = $post_list;
	}
	elseif ( 'category-portfolio' == $type ) {
		$no_of_post = $quantity;

		$args['category__in'] = (array) $options['portfolio_select_category'];
	}

	$args['posts_per_page'] = $no_of_post;

	if ( 0 == $no_of_post ) {
		return;
	}

	$loop = new WP_Query( $args );

	$i=0;
	while ( $loop->have_posts() ) {

		$loop->the_post();

		$i++;

		$title_attribute = the_title_attribute( array( 'before' => esc_html__( 'Permalink to:', 'parallax-frame' ), 'echo' => false ) );

		$output .= '
			<article id="portfolio-post-' . $i . '" class="post hentry">';

			//Default value if there is no first image
			$image = '<img class="wp-post-image" src="'.esc_url( get_template_directory_uri() ).'/images/gallery/no-featured-image-1680x720.jpg" >';

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
				<figure class="portfolio-content-image featured-image">
					<a href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">
					'. $image .'
					</a>
				</figure>';

			if ( $options['portfolio_enable_title'] || 'hide-content' != $options['portfolio_show'] ) {
			$output .= '
				<div class="entry-container">';
				if ( $options['portfolio_enable_title'] ) {
					$output .= '
						<header class="entry-header">
							<h2 class="entry-title">
								<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . the_title( '','', false ) . '</a>
							</h2>
						</header>';
				}

				$footer_class = '';

				if ( $options['portfolio_hide_category'] &&  $options['portfolio_hide_tags'] && $options['portfolio_hide_date'] && $options['portfolio_hide_author'] ) {
					$footer_class = 'screen-reader-text';
				}

				$output .= '
					<footer class="entry-footer ' . $footer_class . '">
						' . parallax_frame_get_meta(
								$options['portfolio_hide_category'],
								$options['portfolio_hide_tags'],
								$options['portfolio_hide_date'],
								$options['portfolio_hide_author']
							) . '
					</footer><!-- .entry-footer -->
				</div><!-- .entry-container -->';
			}
			$output .= '
			</article><!-- .post-'. $i .' -->';
		} //endwhile

	wp_reset_postdata();

	return $output;
}
endif; // parallax_frame_post_page_category_portfolio


if ( ! function_exists( 'parallax_frame_image_portfolio' ) ) :
/**
 * This function to display featured posts content
 *
 * @get the data value from theme options
 * @displays on the index
 *
 * @useage Featured Image, Title and Excerpt of Post
 *
 * @uses set_transient
 *
 * @since Parallax Frame 0.1v
 */
function parallax_frame_image_portfolio( $options ) {
	$quantity = $options['portfolio_number'];
	$output   = '';

	for ( $i = 1; $i <= $quantity; $i++ ) {
		if ( !empty ( $options[ 'portfolio_target_' . $i ] ) ) {
			$target = '_blank';
		} else {
			$target = '_self';
		}

		//Checking Link
		if ( !empty ( $options[ 'portfolio_link_' . $i ] ) ) {
			$link =  esc_url( $options[ 'portfolio_link_' . $i ] );
		}
		else {
			$link = '#';
		}

		//Checking Title
		if ( !empty ( $options[ 'portfolio_title_'. $i ] ) ) {
			$title = esc_attr( $options[ 'portfolio_title_'. $i ] );
		}
		else {
			$title = '';
		}

		//Checking Content
		if ( !empty ( $options[ 'portfolio_content_'. $i ] ) ) {
			$content = $options[ 'portfolio_content_'. $i ];
		}
		else {
			$content = '';
		}
		$output .= '
			<article id="portfolio-post-1'.$i.'" class="post hentry image-content">';
				if ( !empty ( $options[ 'portfolio_image_' . $i ] ) ) {
					$output .= '
					<figure class="portfolio-content-image featured-image">
						<a title="' . esc_attr( $title ) . '" href="' . esc_url( $link ) . '" target="' . $target . '">
							<img src="' . esc_url( $options[ 'portfolio_image_' . $i ] ) . '" class="wp-post-image" alt="' . esc_attr( $title ) . '" title="' . esc_attr( $title ) . '">
						</a>
					</figure>';
				}
				if ( '' != $title || '' != $content ) {
					$output .= '
					<div class="entry-container">';
						if ( '' != $title  ) {
							$output .= '
							<header class="entry-header">
								<h2 class="entry-title">
									<a title="' . esc_attr( $title ) . '" href="' . esc_url( $link ) . '" target="' . $target . '">' . $title . '</a>
								</h2>
							</header>';
						}
						if (  $content!='' ) {
							$output .= '
							<div class="entry-content">
								' . $content . '
							</div>';
						}
					$output .= '
					</div><!-- .entry-container -->';
				}
		$output .= '
			</article><!-- .portfolio-post-'.$i.' -->';
	}

	return $output;
}
endif; //parallax_frame_image_portfolio
