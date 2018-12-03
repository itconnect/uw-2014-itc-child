<?php
$html = '<div class="search-breadcrumbs"><span class="crumb">IT Connect</span>';

if ($post->post_type == 'page') {
	$parents = get_post_ancestors($post->ID);
	$parents = array_reverse($parents);

	foreach ($parents as $parent) {
		$html .= '<span class="crumb">' . get_the_title($parent) . '</span>';
	}
} else if ($post->post_type == 'post') {
	$html .= '<span class="crumb">News</span>';
} else if ($post->post_type == 'service') {
    $html .= '<span class="crumb">Service Catalog</span>';
}
$html .= '</div>';
echo $html;
?>