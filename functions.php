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
* Adds support for SVG via TinyMCE editor
*/

add_filter('tiny_mce_before_init', 'allow_svg_in_tinymce');

function allow_svg_in_tinymce( $init ) {

	// NOTE: This doesn't take into account any security concerns regarding SVG.
	//       It doesn't remove potential vulnerable elements, etc. It just allows
	//       SVG, as is, assuming that the uploader is trusted. However, it would
	//       be easy to remove elements such as script if desired. Just remove from
	//       the array.

	$svgElemList = array(
		'a',
		'altGlyph',
		'altGlyphDef',
		'altGlyphItem',
		'animate',
		'animateColor',
		'animateMotion',
		'animateTransform',
		'circle',
		'clipPath',
		'color-profile',
		'cursor',
		'defs',
		'desc',
		'ellipse',
		'feBlend',
		'feColorMatrix',
		'feComponentTransfer',
		'feComposite',
		'feConvolveMatrix',
		'feDiffuseLighting',
		'feDisplacementMap',
		'deDistantLight',
		'feFlood',
		'feFuncA',
		'feFuncB',
		'feFuncG',
		'feFuncR',
		'feGaussianBlur',
		'feImage',
		'feMerge',
		'feMergeNode',
		'feMorphology',
		'feOffset',
		'fePointLight',
		'feSpecularLighting',
		'feSpotLight',
		'feTile',
		'feTurbulance',
		'filter',
		'font',
		'font-face',
		'font-face-format',
		'font-face-name',
		'font-face-src',
		'font-face-url',
		'foreignObject',
		'g',
		'glyph',
		'glyphRef',
		'hkern',
		'image',
		'line',
		'lineGradient',
		'marker',
		'mask',
		'metadata',
		'missing-glyph',
		'pmath',
		'path',
		'pattern',
		'polygon',
		'polyline',
		'radialGradient',
		'rect',
		'script',
		'set',
		'stop',
		'style',
		'svg',
		'switch',
		'symbol',
		'text',
		'textPath',
		'title',
		'tref',
		'tspan',
		'use',
		'view',
		'vkern'
	);

	// extended_valid_elements is the list of elements that TinyMCE allows. This checks
	// to make sure it exists, and then implodes the SVG element list and adds it. The
	// format of each element is 'element[attributes]'. The array is imploded, and turns
	// into something like '...svg[*],path[*]...'
	
	if ( isset( $init['extended_valid_elements'] ) ) {
		$init['extended_valid_elements'] .= ','.implode('[*],',$svgElemList).'[*]';
	}

	// return value
	return $init;
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
