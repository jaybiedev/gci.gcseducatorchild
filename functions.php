<?php

/*** Child Theme Function  ***/
if ( ! function_exists( 'educator_edge_child_theme_enqueue_scripts' ) ) {
	function educator_edge_child_theme_enqueue_scripts()
	{

		$parent_style = 'educator-edge-default-style';

		wp_enqueue_style('educator-edge-child-style', get_stylesheet_directory_uri() . '/style.css', array($parent_style));
	}

	add_action('wp_enqueue_scripts', 'educator_edge_child_theme_enqueue_scripts');
}