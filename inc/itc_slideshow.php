<?php
/*
 * This shortcode takes "slideshow" custom fields on IT Connect and generates a UW Slideshow with the. 
 * This allows for a clear, bug-free UI and scheduling of slideshow changes.
 * 
 * Dependancies: 
 *   -Advanced Custom Fields Pro
 *   -UW Slideshow javascript that is including in the UW 2014 theme
 */

function itc_slideshow($atts, $content=null){
	ob_start();
	if (function_exists('have_rows') && have_rows('itc_slideshow_slides')) {
		$out .= '<div class="uw-slideshow">';

		while( have_rows('itc_slideshow_slides') ): the_row(); 

			// vars
			$headline = get_sub_field('itc_slideshow_headline');
			$bodytext = get_sub_field('itc_slideshow_body_text');
			$img = get_sub_field('itc_slideshow_image');
			$link = get_sub_field('itc_slideshow_link');

			$out .= '<div class="slide">';
			
			$out .= '<a	href="' . $link . '">';
			$out .= '<img class="alignnone size-full" src="' . $img["url"] . '" alt="' . $img["alt"] . '" width="' . $img["width"] . '" height="' . $img["height"] . '" />';
			$out .= '</a>';
			$out .= '<div>';
			$out .= '<h3><a	href="' . $link . '">' . $headline . '</a></h3>';
			$out .= $bodytext;
			$out .= '</div>';


			$out .= '</div>'; // slide

		endwhile;

		$out .= '</div>'; // uw-slideshow
	}

	echo $out;
	return ob_get_clean();
}
add_shortcode('itc_slideshow','itc_slideshow');

