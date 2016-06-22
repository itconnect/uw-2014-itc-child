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

// Increases weight of featured and top level pages
function custom_field_weights($match) {

	$featured = get_post_meta($match->doc, 'featured', true);
	$top_level = get_post_meta($match->doc, 'top_level', true);

	if ('1' == $featured && '1' == $top_level) {
		$match->weight = $match->weight * 5;
	} else if ('1' == $featured) {
		$match->weight = $match->weight * 2;
	} else {
		$match->weight = $match->weight / 2;
	}
	
	return $match;
}
add_filter('relevanssi_match', 'custom_field_weights');


/**
* Adds support for tags to pages (in addition to posts)
*   1) Registers taxonomies for page type
*   2) Includes tags on archive pages, modifies query object to return pages for archives
*/
function add_taxonomies_to_pages() {
	register_taxonomy_for_object_type('post_tag', 'page');
}

function tags_archives( $wp_query ) {
	if ($wp_query->get('tag'))
		$wp_query->set('post_type', 'any');
} 

add_action('init', 'add_taxonomies_to_pages');
if (!is_admin()) {
	add_action('pre_get_posts', array($this, 'tags_archives'));
} 

?>