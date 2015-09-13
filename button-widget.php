<?php
/** 
 * This document defines the new button widget.
 * 
 */

namespace magicdust;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );





class Button_Widget extends \WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'magicdust_button_widget', // Base ID
			__( 'Magicdust Button', 'magicdust-button' ), // Name
			array( 'description' => __( 'Adds a button which links to an internal or external webpage.', 'magicdust-button-description' ), ) // Args
		);
	}



	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		// Output appropriate link type.

		if ( $instance['link_type'] == 'custom-url' ) {
			// If it is a custom URL:
			echo('<a class="magic-button" href="' . esc_url( $instance['link'] ) . '">' . $instance['label'] . '</a>');
		} else if ( in_array( $instance['link_type'], get_post_types( array( 'show_in_nav_menus' => true ) ) ) ) {
			// If it is a post type:
			echo('<a class="magic-button" href="' . esc_url( get_permalink($instance['link']) ) . '">' . $instance['label'] . '</a>');
		} else {
			// If it is a taxonomy:
			echo('<a class="magic-button" href="' . esc_url( get_term_link( $instance['link'], $instance['link_type'] ) ) . '">' . $instance['label'] . '</a>');
		}

		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {

		/* Initialize variables to store the user's settings for each widget instance. */

		// The label of the link that will eventually be output.
		$label = ! empty( $instance['label'] ) ? $instance['label'] : __( 'New Label', 'magicdust-button-label-placeholder' );
		
		// The type of link target: can be a post type, taxonomy or text link.
		$link_type = ! empty( $instance['link_type'] ) ? $instance['link_type'] : __( 'page', 'magicdust-button-link_type-placeholder' );
		
		// The post or taxonomy ID, or the raw text hyperlink.
		$link = ! empty( $instance['link'] ) ? $instance['link'] : __( '#', 'magicdust-button-link-placeholder' );
		?>

	
		<!-- Output the form controls below! -->

		<!-- Simple text entry for the button text. -->
		<p>
			<label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e( 'Label:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" type="text" value="<?php echo esc_attr( $label ); ?>">
		</p>


		<!--
		Output a select option for all valid post types and taxonomies.
		(This list should match the options available in WordPress menu creation.)
		-->
		<p data-control-group="link-type">
			<?php
			// Fetch arrays of the post types and taxonomies currently enabled in menu creation.
			$post_types = get_post_types( array( 'show_in_nav_menus' => true ), 'objects' );
			$taxonomies = get_taxonomies( array( 'show_in_nav_menus' => true ), 'objects' );
			?>

			<label for="<?php echo $this->get_field_id( 'link_type' ); ?>"><?php _e( 'Link Type:' ); ?></label> 
			<select class="widefat" data-select="link-type" name="<?php echo $this->get_field_name( 'link_type' ); ?>">';
				<?php foreach($post_types as $post_type) : ?>
					<option value="<?php echo $post_type->name; ?>" <?php if ($post_type->name == $link_type) { echo 'selected="selected"'; } ?>><?php echo $post_type->labels->name; ?></option>
				<?php endforeach; ?>
				<?php foreach($taxonomies as $taxonomy) : ?>
					<option value="<?php echo $taxonomy->name; ?>" <?php if ($taxonomy->name == $link_type) { echo 'selected="selected"'; } ?>><?php echo $taxonomy->labels->name; ?></option>
				<?php endforeach; ?>
				<option value="custom-url" <?php if ('custom-url' == $link_type) { echo 'selected="selected"'; } ?>>Custom Link</option>
			</select>
		</p>


		<!--
		Output one dropdown for EACH available post type and taxonomy.
		We will filter these on the front end with javascript.
		-->

		<!-- Post Types -->
		<?php foreach ($post_types as $post_type) : ?>
	 		<p data-control-group="<?php echo $post_type->name; ?>">
				<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:' ); ?></label> 
				<?php
				echo get_post_dropdown($this->get_field_name( 'link' ), $post_type->name, $link);
				?>
			</p>
		<?php endforeach; ?>

		<!-- Taxonomies -->
		<?php foreach ($taxonomies as $taxonomy) : ?>
	 		<p data-control-group="<?php echo $taxonomy->name; ?>">
				<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:' ); ?></label> 
				<?php
				echo get_taxonomy_term_dropdown($this->get_field_name( 'link' ), $taxonomy->name, $link);
				?>
			</p>
		<?php endforeach; ?>


		<!-- Output a text field for manual link entry. -->
 		<p data-control-group="custom-url">
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
		</p>

		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['label'] = ( ! empty( $new_instance['label'] ) ) ? strip_tags( $new_instance['label'] ) : 'Unlabeled';
		$instance['link_type'] = ( ! empty( $new_instance['link_type'] ) ) ? strip_tags( $new_instance['link_type'] ) : 'page';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '#';

		return $instance;
	}
		
}





/**
 * Utility function.
 * Create a dropdown of posts, given a post_type.
 * 
 * @param $select_id The id attribute output to the select element.
 * @param $post_type The slug of the post type you wish to filter by as a strong.
 * @param $selected  The ID (as an integer) of the currently selected post.
 */
function get_post_dropdown($select_name, $post_type, $selected = 0) {

	// Get raw array of all published post objects corresponding to the $post_type.
    $posts = get_posts(array('post_type'=> $post_type, 'post_status' => 'publish', 'suppress_filters' => false, 'posts_per_page'=>-1));

    // Generate output string.
    $output = '<select class="widefat" name="' . $select_name . '">';
    foreach ($posts as $post) {
    	$output .= '<option value="' . $post->ID . '"' . ($selected == $post->ID ? ' selected="selected"' : '') . '>' . $post->post_title . '</option>';
    }
    $output .= '</select>';

	return $output;
}


/**
 * Utility function.
 * Create a dropdown of taxonomy terms, given a taxonomy.
 * 
 * @param $select_id The id attribute output to the select element.
 * @param $post_type The slug of the post type you wish to filter by as a strong.
 * @param $selected  The ID (as an integer) of the currently selected post.
 */
function get_taxonomy_term_dropdown($select_name, $taxonomy, $selected = 0) {

	// Get raw array of all available terms corresponding to the $taxonomy.
	$terms = get_terms( $taxonomy );
    // $posts = get_posts(array('post_type'=> $post_type, 'post_status' => 'publish', 'suppress_filters' => false, 'posts_per_page'=>-1));

    // Generate output string.
    $output = '<select class="widefat" name="' . $select_name . '">';
    foreach ($terms as $term) {
    	$output .= '<option value="' . $term->slug . '"' . ($selected == $term->name ? ' selected="selected"' : '') . '>' . $term->name . '</option>';
    }
    $output .= '</select>';

	return $output;
}