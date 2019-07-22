<?php 
//https://www.role-editor.com/documentation/hooks/

/**
* Child pages of a page with restricted access are not restricted
*/
add_filter('ure_auto_access_child_pages', 'ure_do_not_include_child_pages', 10, 1);
function ure_do_not_include_child_pages($include_children) {
 
   $include_children = false;
 
   return $include_children;
}

/**
* Users see all pages on pages lists, even ones they can't edit
*/
add_filter('ure_posts_show_full_list', 'show_full_list_of_posts', 10, 1);
function show_full_list_of_posts($full) {
 
   return true;
}

?>