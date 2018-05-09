<?php
/**
* Enqueues child theme stylesheet and javascript, loading first the parent theme stylesheet
*/

function itc_child_enqueue() {
	wp_enqueue_style( 'parent-theme-css', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script('jquery', get_stylesheet_directory_uri() . '/js/jquery-3.3.1.min.js');
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
* Adds additional file tyles allowed for media
*/

add_filter('upload_mimes', 'itconnect_allowed_mimetypes', 1, 1);

function itconnect_allowed_mimetypes($mime_types) {
    $mime_types['dwg'] = 'image/vnd.dwg'; // Adding DWG 
    return $mime_types;
}


/**
 * Show all parents, regardless of post status.
 */
function itconnect_show_all_parents( $args ) {
	$args['post_status'] = array( 'publish', 'pending', 'draft', 'private' );
	return $args;
}
add_filter( 'page_attributes_dropdown_pages_args', 'itconnect_show_all_parents' );
add_filter( 'quick_edit_dropdown_pages_args', 'itconnect_show_all_parents' );


/**
 * Overrides the dawgdrops nav menu call
 */
function uw_dropdowns()
{

echo '<nav id="dawgdrops" aria-label="Main menu"><div class="dawgdrops-inner container" role="application">';

echo  wp_nav_menu( array(
        'theme_location'  => UW_Dropdowns::LOCATION,
        'container'       => false,
        'depth'           => 3,
        //'container_class' => 'dawgdrops-inner container',
        'menu_class'      => 'dawgdrops-nav',
        'fallback_cb'     => '',
        'walker'          => new ITC_Dropdowns_Walker_Menu()
      ) );

echo '</div></nav>';
}

/** 
  * Calls shortcoad to add form to report broken links when report link clicked
  */
//add_action( 'wp_ajax_process_shortcode_on_report_click_action', 'process_shortcode_on_report_click_ajax');
//add_action( 'wp_ajax_nopriv_process_shortcode_on_tab_click_action', 'process_shortcode_on_report_click_ajax');

//function process_shortcode_on_report_click_ajax() {
//    echo do_shortcode('[contact-form-7 id="286" title="Report a problem"]');
    //die();
//    wp_die();
//}


/**
 * Replaces the dawgdrops nav walker to add additional levels
 */
require_once('ITC_Dropdowns_Walker_Menu.php');


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
