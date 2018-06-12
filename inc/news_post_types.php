<?php

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
    $labels->view_item = 'View IT Connect News';
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
 * Add Service News post type
 */

function servicenews_post_type () {
  $labels = array(
    'name'               => _x( 'Service News', 'post type general name' ),
    'singular_name'      => _x( 'Service News', 'post type singular name' ),
    'add_new'            => _x( 'Add New Service News', 'service news' ),
    'add_new_item'       => __( 'Add New Service News' ),
    'edit_item'          => __( 'Edit Service News' ),
    'new_item'           => __( 'New Service News' ),
    'all_items'          => __( 'All Service News' ),
    'view_item'          => __( 'View Service News' ),
    'search_items'       => __( 'Search Service News' ),
    'not_found'          => __( 'No Service News found' ),
    'not_found_in_trash' => __( 'No Service News found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Service News'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'News content type for use by UW-IT Services on IT Connect',
    'public'        => true,
    'publicly_queryable' => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
    'taxonomies'  => array( 'svcnewscats' ),
  );
  register_post_type( 'servicenews', $args ); 
}
add_action( 'init', 'servicenews_post_type' );


/**
 * Create heirarchichal taxonomy for service news
 */

function create_svcnewscats_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Service News Categories', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Service News Category', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Search Service News Categories', 'textdomain' ),
        'all_items'         => __( 'All Service News Categories', 'textdomain' ),
        'parent_item'       => __( 'Parent Category', 'textdomain' ),
        'parent_item_colon' => __( 'Parent Category:', 'textdomain' ),
        'edit_item'         => __( 'Edit Category', 'textdomain' ),
        'update_item'       => __( 'Update Category', 'textdomain' ),
        'add_new_item'      => __( 'Add New Category', 'textdomain' ),
        'new_item_name'     => __( 'New Category Name', 'textdomain' ),
        'menu_name'         => __( 'Categories', 'textdomain' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'svcnewscats' ),
    );

    register_taxonomy( 'svcnewscats', array( 'servicenews' ), $args );
}
add_action( 'init', 'create_svcnewscats_taxonomies', 0 );