<?php

echo '<div class="page-bottom">';
// Surpressing last updated date. Planned to be implimented in ~2019
// the_modified_date('F j, Y', '<div class="itc-updated-date">Last updated ', '</div>');
if (get_field('reviewed_on')) {  
	echo '<div class="itc-updated-date">Last reviewed ' . date_format(date_create(get_field('reviewed_on')), 'F j, Y') . '</div>'; 
}
the_tags('<div class="tags"><span>Tags: </span>','','</div>'); 
echo '<div class="report-link-container">See a problem on this page? <a class="report-link" href="/help/page-feedback/">Let us know</a>.<div id="report-form">';
//echo do_shortcode('[contact-form-7 id="42260" title="Report a problem"]');
echo '</div></div>';
echo '</div>';

get_template_part( 'content', 'pagecss' );
get_template_part( 'content', 'pagejs' );

?>
