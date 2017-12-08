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
	);

	// query
	$pagelist = get_pages( $args );

	// loop
	foreach ($pagelist as $listitem) {

		if (get_field('reviewed_on', $listitem->ID)) {
			$date = '<span class="review_date">' . date_format(date_create(get_field('reviewed_on', $listitem->ID)), 'Y/m/d') . '</span>';
		} else {
			$date = '<span class="needs_review never_reviewed">Needs review</span>';
		};

		if (get_field('reviewed_by', $listitem->ID)) {
			$reviewer =  get_field('reviewed_by', $listitem->ID);
		} else {
			$reviewer = 'Not set';
		};

		if (get_field('contact', $listitem->ID)) {
			$contacts =  get_field('contact', $listitem->ID);
		} else {
			$contacts = 'None';
		};

		if (get_field('service_offering', $listitem->ID)) {
			$serviceoffering =  get_field('service_offering', $listitem->ID);
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