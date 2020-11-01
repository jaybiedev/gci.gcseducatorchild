<?php
/*
 * Template Name: Resource Presenter
 * Template Post Type: instructor
 */
global $post;

if ( ! empty( $post ) && $post->post_type == 'instructor' ) {
	register_template(__FILE__);
}

get_header();

educator_edge_get_title();

edgt_lms_get_single_instructor();

get_footer();
