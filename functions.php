<?php
/**
* Enqueues child theme stylesheet, loading first the parent theme stylesheet.
*
*function themify_custom_enqueue_child_theme_styles() {
*	wp_enqueue_style( 'parent-theme-css', get_template_directory_uri() . '/style.css' );
*}
*
*add_action( 'wp_enqueue_scripts', 'themify_custom_enqueue_child_theme_styles' );
*/

/** 
* Enqueus child theme stylesheet and javascript, loading first the parent theme stylesheet
*/

function itc_child_enqueue() {
	wp_enqueue_style( 'parent-theme-css', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script('childscripts', get_stylesheet_directory_uri() . '/js/itconnect.js');
}
add_action( 'wp_enqueue_scripts', 'itc_child_enqueue' );
?>