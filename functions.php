<?php
require_once( __DIR__ . '/classes/class-widget-instructors-posts-list.php' );
require_once( __DIR__ . '/classes/class-widget-posts-by-category-list.php');

function register_custom_widgets() {
	register_widget( 'WP_Widget_Instructors_Posts_List' );
	register_widget( 'WP_Widget_Posts_By_Category_List' );
}
add_action( 'widgets_init', 'register_custom_widgets' );

/*** Child Theme Function  ***/
if ( ! function_exists( 'educator_edge_child_theme_enqueue_scripts' ) ) {
	function educator_edge_child_theme_enqueue_scripts()
	{

		$parent_style = 'educator-edge-default-style';

		wp_enqueue_style('educator-edge-child-style', get_stylesheet_directory_uri() . '/style.css', array($parent_style));
	}

	add_action('wp_enqueue_scripts', 'educator_edge_child_theme_enqueue_scripts');
}
