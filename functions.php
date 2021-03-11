<?php
/**
* Enqueues child theme stylesheet and javascript, loading first the parent theme stylesheet
*/

function itc_child_enqueue() {
	wp_enqueue_style( 'parent-theme-css', get_template_directory_uri() . '/style.css', '', '2.02' );
	//wp_enqueue_script('jquery', get_stylesheet_directory_uri() . '/js/jquery-3.3.1.min.js');
	wp_enqueue_script('childscripts', get_stylesheet_directory_uri() . '/js/itconnect.js', '', '2.02');
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
 * Rename posts to IT Connect News.
 */

function itcn_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'IT Connect News';
    $submenu['edit.php'][5][0] = 'News';
    $submenu['edit.php'][10][0] = 'Add News';
    $submenu['edit.php'][16][0] = 'News Tags';
}
function itcn_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'IT Connect News';
    $labels->singular_name = 'IT Connect News';
    $labels->add_new = 'Add News';
    $labels->add_new_item = 'Add IT Connect News';
    $labels->edit_item = 'Edit IT Connect News';
    $labels->new_item = 'News';
    $labels->view_item = 'View ITCN article';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No IT Connect News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All IT Connect News';
    $labels->menu_name = 'IT Connect News';
    $labels->name_admin_bar = 'IT Connect News';
}
 
add_action( 'admin_menu', 'itcn_change_post_label' );
add_action( 'init', 'itcn_change_post_object' );

/**
 * Workaround for A-Z index, which no longer supports a listing of all pages on site, just relative pages.
 * Soluion from plugin author: https://wordpress.org/support/topic/only-showing-relative-pages/#post-11278091
 */
add_filter( 'a-z-listing-sections', '__return_empty_array' );

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


/**
* Adds reminders to the edit screen for content review
*/
require_once('inc/review_reminders.php');


/**
* Adds service field to the page list in admin table, makes service field bulk and quick editable
*/

require_once('inc/service_field_bulk_quick_edit_admin_table.php');


/**
* Creates shortcode for listing out pages by last edit
*/
require_once('inc/service_news_post_types.php');


/**
* Creates shortcode for IT Connect slideshow
*/
require_once('inc/itc_slideshow.php');

/**
* Adds configurations via hooks for URE Pro
*/
require_once('inc/ure_config.php');

/**
* Creates shortcode that lists EDW load data
*/
require_once('inc/edw-data-load.php');


?>
