<?php
/**
 * This file creates the Testimonial widget.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register Widget.
 */
function gts_init_widget() {

	register_widget( 'gts_widget' );

}
add_action( 'widgets_init', 'gts_init_widget' );

/**
 * GTS Widget Class.
 */
class GTS_Widget extends WP_Widget {

	/**
	 * Construct Class.
	 */
	function __construct() {

		parent::__construct(
			'gts_widget',
			__( 'Testimonials', 'gts-plugin' ),
			array(
				'description' => __( 'Displays testimonials', 'gts-plugin' ),
			)
		);
	}

	/**
	 * Widget.
	 *
	 * @param  array  $args Widget args.
	 * @param  string $instance This widget.
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		include( dirname( __FILE__ ) . '/gts-frontend.php' );

		echo '</div></section>';

	}

	/**
	 * Widget Form
	 *
	 * @param  array $instance Form settings.
	 */
	public function form( $instance ) {

		global $title;

		$form_title = $title;

		if ( isset( $instance['title'] ) ) {
			$form_title = $instance['title'];
		}

		echo '<p>';
		echo '<label for="' . $this->get_field_id( 'title' ) . '">' . _e( 'Title:' ) . '</label>';
		echo '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . 'type="text" value="' . esc_attr( $form_title ) . '">';
		echo '</p>';

	}

	/**
	 * Save settings.
	 *
	 * @param  array $new_instance Array of widget settings.
	 * @param  array $old_instance Array of old widget settings.
	 * @return array               Array of new widget settings.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;

	}
}
