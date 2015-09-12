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
		// if ( ! empty( $instance['title'] ) ) {
		// 	echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		// }

		echo('<a class="magic-button" href="' . esc_url( /*get_permalink(*/ $instance['link'] /*)*/ ) . '">' . $instance['label'] . '</a>');

		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$label = ! empty( $instance['label'] ) ? $instance['label'] : __( 'New Label', 'magicdust-button-label-placeholder' );
		$link = ! empty( $instance['link'] ) ? $instance['link'] : __( '#', 'magicdust-button-link-placeholder' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e( 'Label:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" type="text" value="<?php echo esc_attr( $label ); ?>">
		</p>

 		<p>
		<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
		</p>
		
<!-- 		<p>
		<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:' ); ?></label> 
		<?php
		// $selected = ! empty()
		wp_dropdown_pages(array(
			'class'    => 'widefat',
		    'id'       => $this->get_field_id('link'),
		    'name'     => $this->get_field_name('link'),
		    'selected' => $link,
		)); ?>
		</p> -->

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
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '#';

		return $instance;
	}
		
}