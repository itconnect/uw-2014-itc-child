/**
*
* Enhancements for the Relevanassi search plugin and related taxonomy changes
*
*/

// Increases weight of featured and top level pages
function custom_field_weights($match) {

	$featured = get_post_meta($match->doc, 'featured', true);
	$top_level = get_post_meta($match->doc, 'top_level', true);

	if ('1' == $featured && '1' == $top_level) {
		$match->weight = $match->weight * 6;
	} else if ('1' == $featured) {
		$match->weight = $match->weight * 2;
	} /*else {
		$match->weight = $match->weight / 2;
	}*/
	
	return $match;
}
add_filter('relevanssi_match', 'custom_field_weights');
 
// Decreases the weight of old news, removes news older than 1 year
function news_date_weights($match) {
	$post_type = relevanssi_get_post_type($match->doc);
	if ($post_type == 'post') {
		$post_date = strtotime(get_the_time("Y-m-d", $match->doc));
		$one_year_ago = time() - (60*60*24*7*52);
		$six_months_ago = time() - (60*60*24*7*26);
		// Older than a year, remove weight
		if ($post_date < $one_year_ago) {
		    $match->weight = $match->weight * 0;
		} 
		// 26 weeks to a year old, halve the weight
		else if ($post_date < $six_months_ago) {
		    $match->weight = $match->weight * 0.5;
		}

	}
	return $match;
}
add_filter('relevanssi_match', 'news_date_weights');

// Customize the search result excerpts with a custom filed.
function excerpt_function($content, $post, $query) {
    $search_blurb = get_post_meta($post->ID, 'search_blurb', true);
    $content = $search_blurb;
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