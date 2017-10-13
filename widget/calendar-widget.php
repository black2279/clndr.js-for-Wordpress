<?php

/**
 * Class Clndr_Widget widget.
 */
class Clndr_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Clndr_Widget', // Base ID
			__( 'Calendar', 'clndr' ), // Name
			array(
				'description' => __( 'Clndr widget shows a simple calendar', 'clndr' ),
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		clndr_load_events_from_db();
		clndr_print();
		echo $args['after_widget'];
	}

} // class Clndr_Widget

register_widget( 'Clndr_Widget' );