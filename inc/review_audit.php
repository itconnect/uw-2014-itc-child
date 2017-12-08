<?php
/*
*
* Adds a shortcode to list all pages, ordered by the last date they were reviewed:
*  
* Dependancies: plugin Advanced Custom Fields, DataTables jQuery plugin (https://datatables.net/download/index)
*
*/

function reviewedOnAudit() {
	ob_start();
	echo '<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/js/DataTables/datatables.min.css"/>';
    echo '<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/js/DataTables/datatables.min.js"></script>';
	echo '<table id="reviewed"><thead><tr><th>Page Title</th><th>Last Reviewed Date</th><th>Reviewed By</th><th>Contacts/SMEs</th><th>Service Offering</th></tr></thead><tbody>';
	// args
	$args = array(
		'post_type' => 'page',
		'posts_per_page'  => -1,
	);

	// query
	$wp_query = new WP_Query( $args );

	// loop
	while($wp_query->have_posts()) {
		$wp_query->the_post();

		if (get_field('reviewed_on')) {
			$date = '<span class="review_date">' . date_format(date_create(get_field('reviewed_on')), 'Y/m/d') . '</span>';
		} else {
			$date = '<span class="needs_review never_reviewed">Needs review</span>';
		};

		if (get_field('reviewed_by')) {
			$reviewer =  get_field('reviewed_by');
		} else {
			$reviewer = 'Not set';
		};

		if (get_field('contact')) {
			$contacts =  get_field('contact');
		} else {
			$contacts = 'None';
		};

		if (get_field('service_offering')) {
			$serviceoffering =  get_field('service_offering');
		} else {
			$serviceoffering = 'Not set';
		};
		
		echo '<tr><td><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></td><td>' . $date . '</td><td>' . $reviewer . '</td><td>' . $contacts .'</td><td>' . $serviceoffering . '</td></tr>';
	}
	echo '</tbody></table>';
	echo '<script>$(document).ready(function() { $("#reviewed").DataTable({"pageLength": 100});} );</script>';
	return ob_get_clean();
}
add_shortcode('reviewedOn', 'reviewedOnAudit');