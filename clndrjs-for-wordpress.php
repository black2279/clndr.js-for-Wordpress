<?php
/** 
* Plugin Name: clndr.js for Wordpress
* Description: Calendar widget based on clndr.js (https://github.com/kylestetz/CLNDR). It supports single events and multi-day events and they are displayed in a box below calendar. (It requires Event Wp plugin)
* Author: Cristian Andrighetto
* Version: 1.0.0
*/


if ( ! class_exists( 'Clndr' ) ) :

	class Clndr {
		/**
		 * Clndr constructor.
		 */
		function __construct() {
			add_action( 'widgets_init', array( $this, 'widget' ) );
		}
		
		/**
		 * Include Widgets
		 */
		public function widget() {
			require_once 'widget/functions.php';
			require_once 'widget/calendar-widget.php';
		}
		
	};
	
endif;

$clndr = new Clndr();

?>