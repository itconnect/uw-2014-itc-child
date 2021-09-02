<?php 
if (function_exists('get_field')) {
	if(get_field('page_javascript')) {
		echo '<!-- Start page level JS -->';
		echo '<script type="text/javascript">';
		echo get_field('page_javascript');
		echo '</script>';
		echo '<!-- End page level Js -->';
	} 
}

?>

