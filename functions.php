<?php
/**
* Enqueues child theme stylesheet and javascript, loading first the parent theme stylesheet
*/

function itc_child_enqueue() {
	wp_enqueue_style( 'parent-theme-css', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script('childscripts', get_stylesheet_directory_uri() . '/js/itconnect.js');
}
add_action( 'wp_enqueue_scripts', 'itc_child_enqueue' );


// Update CSS within the Admin interface
function admin_style() {
  wp_enqueue_style('admin-styles', get_stylesheet_directory_uri() .'/admin-style.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

/**
* Adds editor style functionality for TinyMCE
*/
add_editor_style($stylesheet = 'editor-style.css');


/**
* Adds classes to body tag for CSS specificity over parent theme
*/

add_filter('body_class', 'itconnect_body_classes');

function itconnect_body_classes($classes) {
    $classes[] = 'itconnect';
    return $classes;
}


/**
* Enhancements for the Relevanassi search plugin
*/
require_once('inc/search_enhancements.php');


/**
* Overrides the uw_breadcrumbs to add additional functionality
*/
require_once('inc/uw_breadcrumbs_override.php');


/**
* Creates shortcode for listing out pages by last edit
*/
require_once('inc/review_audit.php');

?>
