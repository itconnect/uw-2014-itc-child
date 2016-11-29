<?php
/*
*
* Adds a shortcode to list all pages, ordered by the last date they were reviewed:
*  
* Dependancies: plugin Advanced Custom Fields
*
*/

function reviewedOnAudit() {
	// args
	$args = array(
		'post_type' => 'page',
		'posts_per_page'  => -1,
		'meta_key'  => 'reviewed_on',
		'orderby' => 'meta_value_num',
		'order' => 'ASC'
	);

	// query
	$wp_query = new WP_Query( $args );

	// loop
	while($wp_query->have_posts()) {
		$wp_query->the_post();

		$date = date_create(get_field('reviewed_on'));

		//echo get_post_meta($post->ID,’speaking_event_date’,true) . ‘<br />’;

		echo '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a> – ' . date_format($date,'m/d/Y') . '</li>';

	}
}
add_shortcode('reviewedOn', 'reviewedOnAudit');