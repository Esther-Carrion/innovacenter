<?php
/**
 * Custom Tag Cloud Widget
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */


/**
 * Custom Tag Cloud Widget
 */
class parallax_frame_tag_cloud_widget extends WP_Widget {

	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	function __construct() {

		$this->defaults = array(
			'title'           => '',
			'no_of_tags'      => 30,
			'skins'           => 'box',
			'sequence'        => 'random',
			'smallest'        => 14,
			'largest'         => 14,
			'unit'            => 'px',
			'post_tag'        => 1,
			'category'        => 0,
			'link_category'   => 0,
			'custom_taxonomy' => '',
		);

		$widget_ops = array(
			'classname'   => 'ct-tag-cloud cttagcloud',
			'description' => esc_html__( 'Displays Custom Tag Cloud with selected layout', 'parallax-frame' ),
		);

		$control_ops = array(
			'id_base' => 'ct-tag-cloud'
		);

		parent::__construct(
			'ct-tag-cloud', // Base ID
			__( 'CT: Tag Cloud', 'parallax-frame' ), // Name
			$widget_ops,
			$control_ops
		);
	}

	function form($instance) {
		//* Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title', 'parallax-frame' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'no_of_tags' ); ?>"><?php esc_html_e( 'No. of Items', 'parallax-frame' ); ?>:</label>
			<input type="number" id="<?php echo $this->get_field_id( 'no_of_tags' ); ?>" name="<?php echo $this->get_field_name( 'no_of_tags' ); ?>" value="<?php echo absint( $instance['no_of_tags'] ); ?>" class="small-text" min="1" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'skins' ); ?>"><?php esc_html_e( 'Skins(Theme)', 'parallax-frame' ); ?>:</label>
			<select class="ct_feat_post_post_type widefat" id="<?php echo $this->get_field_id( 'skins' ); ?>" name="<?php echo $this->get_field_name( 'skins' ); ?>">
				<?php
					$post_type_choices = array(
						'default'         => esc_html__( 'Default', 'parallax-frame' ),
						'box'             => esc_html__( 'Box', 'parallax-frame' ),
						'rounded-corners' => esc_html__( 'Rounded Corners', 'parallax-frame' ),
					);

				foreach ( $post_type_choices as $key => $value ) {
					echo '<option value="' . $key . '" '. selected( $key, $instance['skins'], false ) .'>' . $value .'</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'sequence' ); ?>"><?php esc_html_e( 'Sequence', 'parallax-frame' ); ?>:</label>
			<select class="ct_feat_post_post_type widefat" id="<?php echo $this->get_field_id( 'sequence' ); ?>" name="<?php echo $this->get_field_name( 'sequence' ); ?>">
				<?php
					$post_type_choices = array(
						'RAND' => esc_html__( 'Random', 'parallax-frame' ),
						'ASC'  => esc_html__( 'Ascending', 'parallax-frame' ),
						'DESC' => esc_html__( 'Descending', 'parallax-frame' ),
					);

				foreach ( $post_type_choices as $key => $value ) {
					echo '<option value="' . $key . '" '. selected( $key, $instance['sequence'], false ) .'>' . $value .'</option>';
				}
				?>
			</select>
		</p>

		<h4><?php esc_html_e( 'Taxonomies to be used', 'parallax-frame' ); ?></h4>
		<p>
        	<input class="checkbox" type="checkbox" <?php checked($instance['post_tag'], true) ?> id="<?php echo $this->get_field_id( 'post_tag' ); ?>" name="<?php echo $this->get_field_name( 'post_tag' ); ?>" />
        	<label for="<?php echo $this->get_field_id('post_tag'); ?>"><?php esc_html_e( 'Post Tags', 'parallax-frame' ); ?></label><br />
        </p>
        <p>
        	<input class="checkbox" type="checkbox" <?php checked($instance['category'], true) ?> id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" />
        	<label for="<?php echo $this->get_field_id('category'); ?>"><?php esc_html_e( 'Category', 'parallax-frame' ); ?></label><br />
        </p>
        <p>
        	<input class="checkbox" type="checkbox" <?php checked($instance['link_category'], true) ?> id="<?php echo $this->get_field_id( 'link_category' ); ?>" name="<?php echo $this->get_field_name( 'link_category' ); ?>" />
        	<label for="<?php echo $this->get_field_id('link_category'); ?>"><?php esc_html_e( 'Link Category', 'parallax-frame' ); ?></label><br />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'custom_taxonomy' ); ?>"><?php esc_html_e( 'Custom Taxnomy', 'parallax-frame' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'custom_taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'custom_taxonomy' ); ?>" value="<?php echo esc_attr( $instance['custom_taxonomy'] ); ?>" class="widefat" />
			<span class="description"><?php esc_html_e( 'Use Custom Taxonomy Slug separated by comma(,)', 'parallax-frame' ); ?></span>
        </p>

		<h2><?php esc_html_e( 'Additional Options', 'parallax-frame' ); ?></h2>
		<hr>

		<p>
			<label for="<?php echo $this->get_field_id( 'smallest' ); ?>"><?php esc_html_e( 'Smallest', 'parallax-frame' ); ?>:</label>
			<input type="number" id="<?php echo $this->get_field_id( 'smallest' ); ?>" name="<?php echo $this->get_field_name( 'smallest' ); ?>" value="<?php echo absint( $instance['smallest'] ); ?>" class="small-text"/>
			<br/>
			<span class="description"><?php esc_html_e( 'The text size of the tag with the smallest count value (units given by unit parameter). ', 'parallax-frame' ); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'largest' ); ?>"><?php esc_html_e( 'Largest', 'parallax-frame' ); ?>:</label>
			<input type="number" id="<?php echo $this->get_field_id( 'largest' ); ?>" name="<?php echo $this->get_field_name( 'largest' ); ?>" value="<?php echo absint( $instance['largest'] ); ?>" class="small-text"/>
			<br/>
			<span class="description"><?php esc_html_e( 'The text size of the tag with the largest count value (units given by unit parameter). ', 'parallax-frame' ); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'unit' ); ?>"><?php esc_html_e( 'Unit', 'parallax-frame' ); ?>:</label>
			<select class="small-text" id="<?php echo $this->get_field_id( 'unit' ); ?>" name="<?php echo $this->get_field_name( 'unit' ); ?>">
				<?php
					$post_type_choices = array(
						'pt' => esc_html__( 'pt', 'parallax-frame' ),
						'px' => esc_html__( 'px', 'parallax-frame' ),
						'em' => esc_html__( 'em', 'parallax-frame' ),
						'%'  => esc_html__( '%', 'parallax-frame' ),
					);

				foreach ( $post_type_choices as $key => $value ) {
					echo '<option value="' . $key . '" '. selected( $key, $instance['unit'], false ) .'>' . $value .'</option>';
				}
				?>
			</select>
			<br/>
			<span class="description"><?php esc_html_e( 'Unit of measure as pertains to the smallest and largest values. This can be any CSS length value.', 'parallax-frame' ); ?></span>
		</p>


		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']      = sanitize_text_field( $new_instance['title'] );
		$instance['no_of_tags'] = absint( $new_instance['no_of_tags'] );
		$instance['skins']      = sanitize_key( $new_instance['skins'] );
		$instance['sequence']   = strip_tags( $new_instance['sequence'] );

		$instance['smallest'] = absint( $new_instance['smallest'] );
		$instance['largest']  = absint( $new_instance['largest'] );
		$instance['unit']     = sanitize_key( $new_instance['unit'] );

		$instance['post_tag']        = parallax_frame_sanitize_checkbox( $new_instance['post_tag'] );
		$instance['category']        = parallax_frame_sanitize_checkbox( $new_instance['category'] );
		$instance['link_category']   = parallax_frame_sanitize_checkbox( $new_instance['link_category'] );
		$instance['custom_taxonomy'] = sanitize_text_field( $new_instance['custom_taxonomy'] );

		return $instance;
	}

	function widget( $args, $instance ) {
		$output ='';

		// Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$output .= $args['before_widget'];

		// Set up the author bio
		if ( ! empty( $instance['title'] ) ) {
			$output .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];
		}

		$taxonomy = array();

		if ( $instance['post_tag'] ) {
			$taxonomy []= 'post_tag';
		}

		if ( $instance['category'] ) {
			$taxonomy []= 'category';
		}

		if ( $instance['link_category'] ) {
			$taxonomy []= 'link_category';
		}

		if ( '' != $instance['custom_taxonomy'] ) {
			$custom_taxonomy = array_map( 'trim', explode( ',', $instance['custom_taxonomy'] ) );

			$taxonomy = wp_parse_args( $taxonomy, $custom_taxonomy );
		}

		$tag_cloud_args = array(
			'smallest'                  => absint( $instance['smallest'] ),
			'largest'                   => absint( $instance['largest'] ),
			'unit'                      => $instance['unit'],
			'number'                    => absint( $instance['no_of_tags'] ),
			'format'                    => 'flat',
			'separator'                 => "\n",
			'orderby'                   => 'name',
			'order'                     => $instance['sequence'],
			'exclude'                   => null,
			'link'                      => 'view',
			'taxonomy'                  => $taxonomy,
			'echo'                      => false,
			'child_of'                  => null, // see Note!
		);

		$output .='<div class="ct-tag-cloud-wrap ' . esc_attr( $instance['skins'] ) .'">' . wp_tag_cloud( $tag_cloud_args ) . '</div>';

		$output .= $args['after_widget'];

		echo $output;
	}
}// end parallax_frame_tagcloud_widget class

/**
 * Initialize Widget
 */
function parallax_frame_tag_cloud_init() {
	register_widget( 'parallax_frame_tag_cloud_widget' );
}
add_action( 'widgets_init', 'parallax_frame_tag_cloud_init' );

