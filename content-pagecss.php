<?php 
if (function_exists('get_field')) {
	if(get_field('page_css_styles')) {
		echo '<!-- Start page level CSS -->';
		echo '<style>';
		echo get_field('page_css_styles');
		echo '</style>';
		echo '<!-- End page level css -->';
	}
}

?>