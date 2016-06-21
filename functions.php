<?php
/**
* Enqueues child theme stylesheet and javascript, loading first the parent theme stylesheet
*/

function itc_child_enqueue() {
	wp_enqueue_style( 'parent-theme-css', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script('childscripts', get_stylesheet_directory_uri() . '/js/itconnect.js');
}
add_action( 'wp_enqueue_scripts', 'itc_child_enqueue' );


/**
* Adds editor style functionality for TinyMCE
*/
add_editor_style();

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
add_filter('relevanssi_match', 'custom_field_weights');
 
function custom_field_weights($match) {
	$featured = get_post_meta($match->doc, 'featured', true);
	if ('1' == $featured) {
 		$match->weight = $match->weight * 2;
	}
	else {
		$match->weight = $match->weight / 2;
	}
	return $match;
}

?>