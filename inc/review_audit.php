<?php
/*
*
* Adds a shortcode to list all pages, ordered by the last date they were reviewed:
*  
* Dependancies: plugin Advanced Custom Fields
*
*/

function reviewedOnAudit() {
	echo '<script src="' . get_stylesheet_directory_uri() . '/js/jquery.tablesorter.min.js"></script>';
	echo '<table id="reviewed" class="tablesorter"><thead><tr><th style="width:75%;">Page</th><th style="width:25%;">Last Reviewed</th></tr></thead><tbody>';
	// args
	$args = array(
		'post_type' => 'page',
		'posts_per_page'  => -1,
		//'meta_key'  => 'reviewed_on',
		//'orderby' => 'meta_value_num',
		'order' => 'ASC'
	);

	// query
	$wp_query = new WP_Query( $args );

	// loop
	while($wp_query->have_posts()) {
		$wp_query->the_post();


		if (get_field('reviewed_on')) {
			$date = date_create(get_field('reviewed_on'));
			//$date = date_format($date,'M j, Y');
			$date = '<span class="review_date">' . date_format($date, 'm/d/Y') . '</span>';
			/*
			*  ALSO MAKE RED IF OLDER THAN 1 YEAR
			*/


		} else {
			$date = '<span class="needs_review">Needs review</span>';
		};

		echo '<tr><td><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></td><td>' . $date . '</td></tr>';

	}
	echo '</tbody></table>';
	echo '<script>$(document).ready(function(){$("#reviewed").tablesorter({sortList: [[1,0]]});}); </script>';
}
add_shortcode('reviewedOn', 'reviewedOnAudit');