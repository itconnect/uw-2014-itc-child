<?php 

/*
*
* Enhancements for the Relevanassi search plugin and related taxonomy changes
*
*/

// Increases weight of featured and top level pages
function custom_field_weights($match) {

	$search_prominence = get_post_meta($match->doc, 'search_prominence', true);

	if($search_prominence && (in_array('search_featured', $search_prominence) && in_array('search_top_level', $search_prominence))) {
		$match->weight = $match->weight * 6;
	} else if ($search_prominence && in_array('search_top_level', $search_prominence)) {
		$match->weight = $match->weight * 5;
	} else if ($search_prominence && in_array('search_featured', $search_prominence)) {
		$match->weight = $match->weight * 2;
	}
	
	return $match;
}
add_filter('relevanssi_match', 'custom_field_weights');

// For exact title or content matches, vastly increase weight
function rlv_exact_boost($results) {
	$query = strtolower(get_search_query());
	foreach ($results as $post_id => $weight) {
		$post = relevanssi_get_post($post_id);

		 // Boost exact title matches
		if (stristr($post->post_title, $query) != false) $results[$post_id] = $weight * 100;

		// Boost exact matches in post content
		if (stristr($post->post_content, $query) != false) $results[$post_id] = $weight * 100;
	}
	return $results;
}
add_filter('relevanssi_results', 'rlv_exact_boost');
 
// Decreases the weight of old news, removes news older than 1 year
function news_date_weights($match) {
	$post_type = relevanssi_get_post_type($match->doc);
	if ($post_type == 'post') {
		$post_date = strtotime(get_the_time("Y-m-d", $match->doc));
		$nine_months_ago = time() - (60*60*24*7*38);
		$eighteen_months_ago = time() - (60*60*24*7*78);
		// Older than a year and a half, remove weight
		if ($post_date < $eighteen_months_ago) {
		    $match->weight = $match->weight * 0;
		} 
		// 38 weeks to a 1 1/2 years old, halve the weight
		else if ($post_date < $nine_months_ago) {
		    $match->weight = $match->weight * 0.5;
		}

	}
	return $match;
}
add_filter('relevanssi_match', 'news_date_weights');

// Customize the search result excerpts with a custom filed.
function excerpt_function($content, $post, $query) {
    $text = get_post_meta($post->ID, 'custom_search_result_snippet', true);
	if ($text != '') {
		$text = strip_shortcodes($text);
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]&gt;', ']]&gt;', $text);
	}
    $content = $text;
	return $content;
}

add_filter('relevanssi_excerpt_content', 'excerpt_function', 10, 3);
// Removes ellipsis
add_filter('relevanssi_ellipsis', '');

/**
* Adds support for tags to pages (in addition to posts)
*   1) Registers taxonomies for page type
*   2) Includes tags on archive pages, modifies query object to return pages for archives
*/
function add_taxonomies_to_pages() {
	register_taxonomy_for_object_type('post_tag', 'page');
}

function tags_support_query($wp_query) {
	if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
} 

add_action('init', 'add_taxonomies_to_pages');
add_action('pre_get_posts', 'tags_support_query');

// Removes posts that require login for non-logged-in users and logged in users who are not uwit users
// Also checks if posts are set to publish before saying they can be shown
add_filter('relevanssi_post_ok', 'auth_reqd_search_filter', 11, 2);
function auth_reqd_search_filter($post_ok, $post_id) {
	$current_user = wp_get_current_user();
	$post_status = relevanssi_get_post_status($post_id);
	if ($post_status == 'publish') {
		if (is_user_logged_in() && (in_array('uwit',$current_user->roles) || in_array('administrator',$current_user->roles))) {
			$post_ok = true;
		} else {
			$isProtected = get_post_meta($post_id,'_srl-yesno');
			if ($isProtected[0] == 'Yes') {
				$post_ok = false;
			}
		}
	} else {
		$post_ok = false;
	}
	return $post_ok;
}

// Allows users to filter results by post type on the search results page
add_filter('relevanssi_hits_filter', 'filter_results_by_type');
function filter_results_by_type($hits) {
	if (!empty($_GET)) {
		$valid = array();
		$filtered = array();

		// Check terms in $_GET and create an array of valid post types for this query
		if (isset($_GET['pages'])){
			$valid['page']=TRUE;
		} 

		if (isset($_GET['news'])){
			$valid['post']=TRUE;
		} 

		if (isset($_GET['svcnws'])){
			$valid['servicenews']=TRUE;
		} 

		if (isset($_GET['services'])){
			$valid['service']=TRUE;
		}

		if(empty($valid)) {
			$valid['page']=TRUE;
			$valid['post']=TRUE;
			$valid['servicenews']=TRUE;
			$valid['service']=TRUE;
		}

		// Split the post types in array $types
		if (!empty($hits)) {
			foreach ($hits[0] as $hit) {
				if (array_key_exists($hit->post_type, $valid)) {
					array_push($filtered, $hit);
				}
			}
		}
		// Merge back to $hits in the desired order
		$hits[0] = $filtered;
		unset($filtered);
		$filtered = array();
		
	}

	// Filter out hits that have the "Hidden from search" checkbox checked
	if (!empty($hits)) {
		foreach ($hits[0] as $hit) {
			$searchopts = get_post_meta($hit->ID, 'search_prominence', true);
			if (!in_array('search_hidden', $searchopts)) {
				array_push($filtered, $hit);
			}
			$hits[0] = $filtered;
		}
	}

	return $hits;
}