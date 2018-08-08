<?php
/**
* Enqueues child theme stylesheet and javascript, loading first the parent theme stylesheet
*/

function itc_child_enqueue() {
	wp_enqueue_style( 'parent-theme-css', get_template_directory_uri() . '/style.css' );
	//wp_enqueue_script('jquery', get_stylesheet_directory_uri() . '/js/jquery-3.3.1.min.js');
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
* Adds service field to the issues content type list in admin
*/

// Add the custom columns to theissue post type:
add_filter( 'manage_page_posts_columns', 'set_custom_edit_page_columns' );
function set_custom_edit_page_columns($columns) {
    if (!isset($columns['service_offering']))
                $columns['service_offering'] = "Service";

    return $columns;
}

// Add the data to the custom columns for the issue post type:
add_action( 'manage_page_posts_custom_column' , 'custom_page_column', 10, 2 );
function custom_page_column( $column, $post_ID ) {
    if ($column == 'service_offering') {
        $service = get_post_meta($post_ID, 'service_offering', TRUE);
        if ($service) {
          echo '<div id="service_offering-' . $post_ID . '">' . $service . '</div>';
        }
        else {
          echo '—';
        }
    }
}

add_action( 'bulk_edit_custom_box', 'add_service_to_bulk_quick_edit_custom_box', 10, 2 );
add_action( 'quick_edit_custom_box', 'add_service_to_bulk_quick_edit_custom_box', 10, 2 );
function add_service_to_bulk_quick_edit_custom_box( $column_name, $post_type ) {
   switch ( $post_type ) {
      case 'page':

         switch( $column_name ) {
            case 'service_offering':
               ?><fieldset class="inline-edit-col-right">
                  <div class="inline-edit-group">
                     <label>
                        <span class="title">Service</span><br />
                        <input type="text" name="service_offering" value="" />
                     </label>
                  </div>
               </fieldset><?php
               break;
         }
         break;

   }
}

add_action( 'admin_print_scripts-edit.php', 'service_enqueue_edit_scripts' );
function service_enqueue_edit_scripts() {
   wp_enqueue_script( 'service-admin-edit', get_stylesheet_directory_uri() . '/js/quick_edit.js', array( 'jquery', 'inline-edit-post' ), '', true );
}

add_action( 'save_post','service_edit_save_post', 10, 2 );
function service_edit_save_post( $post_id, $post ) {

   // don't save for autosave
   if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return $post_id;

   // dont save for revisions
   if ( isset( $post->post_type ) && $post->post_type == 'revision' )
      return $post_id;

   switch( $post->post_type ) {

      case 'page':

   if ( array_key_exists( 'service_offering', $_POST ) )
      update_post_meta( $post_id, 'service_offering', $_POST[ 'service_offering' ] );

   break;

   }

}

add_action( 'wp_ajax_service_edit_save_bulk_edit', 'service_edit_save_bulk_edit' );
function service_edit_save_bulk_edit() {
   // get our variables
   $post_ids = ( isset( $_POST[ 'post_ids' ] ) && !empty( $_POST[ 'post_ids' ] ) ) ? $_POST[ 'post_ids' ] : array();
   $service_offering = ( isset( $_POST[ 'service_offering' ] ) && !empty( $_POST[ 'service_offering' ] ) ) ? $_POST[ 'service_offering' ] : NULL;
   // if everything is in order
   if ( !empty( $post_ids ) && is_array( $post_ids ) && !empty( $service_offering ) ) {
      foreach( $post_ids as $post_id ) {
         update_post_meta( $post_id, 'service_offering', $service_offering );
      }
   }
}

//https://wpdreamer.com/2012/03/manage-wordpress-posts-using-bulk-edit-and-quick-edit/








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
