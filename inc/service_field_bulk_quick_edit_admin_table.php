<?php
/**
* Adds service field to the page list in admin table, makes service field bulk and quick editable
*/

function check_some_other_plugin() {
  if ( is_plugin_active('advanced-custom-fields/acf.php') ) {
      // Add the custom columns header "service" to the page psot type:
      add_filter( 'manage_page_posts_columns', 'set_custom_edit_page_columns' );
      function set_custom_edit_page_columns($columns) {
          if (!isset($columns['service_offering']))
                      $columns['service_offering'] = "Service";

          return $columns;
      }

      // Add the service field data to the custom columns for service
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

      // Add the field for service to the bulk and quick edit screens (same function for both actions)
      add_action( 'bulk_edit_custom_box', 'add_service_to_bulk_quick_edit_custom_box', 10, 2 );
      add_action( 'quick_edit_custom_box', 'add_service_to_bulk_quick_edit_custom_box', 10, 2 );
      function add_service_to_bulk_quick_edit_custom_box( $column_name, $post_type ) {
         switch ( $post_type ) {
            case 'page':

               switch( $column_name ) {
                  case 'service_offering':
                     ?><fieldset class="inline-edit-col-right" style="width: 100%; dispaly: block; margin-top: 5px">
                        <div class="inline-edit-group" style="padding-left: 5px;">
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

      // Add a modified version of WP js to allow us to save and populate data fields added above
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
  } // wrap
} // wrap
add_action( 'admin_init', 'check_some_other_plugin' );

//https://wpdreamer.com/2012/03/manage-wordpress-posts-using-bulk-edit-and-quick-edit/
