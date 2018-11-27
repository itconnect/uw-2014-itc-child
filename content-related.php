

<?php
//Check if the display toggle is checked and if any of the related content type actually have rows before going any further
if ( get_field('display_related_information') && (have_rows('related_information') || have_rows('service_catalog') || have_rows('request_forms')) ){

	$out .= '<aside class="related-content" aria-label="related content">';

	// Related Info Subgroup
	if( have_rows('related_information') ) {

		$out .= '<span class="section-title">Related Information</span>';
		$out .= '<ul class="links">';

		while( have_rows('related_information') ): the_row(); 

			// vars
			$link = get_sub_field('related_information_link');

				if ($link) {
					$out .= '<li class="link"><a href="' . $link['url']  . '">' . $link['title'] . '</a></li>';
				}

		endwhile;

		$out .= '</ul>';

	}

	// Service Catalog Subgroup
	if( have_rows('service_catalog') ) {

		$out .= '<span class="section-title">UW-IT Service Catalog</span>';
		$out .= '<ul class="links">';

		while( have_rows('service_catalog') ): the_row(); 

			// vars
			$link = get_sub_field('service_catalog_link');

				if ($link) {
					$out .= '<li class="link"><a href="' . $link['url']  . '">' . $link['title'] . '</a></li>';
				}

		endwhile;

		$out .= '</ul>';

	}

	// Request Forms Subgroup
	if( have_rows('request_forms') ) {

		$out .= '<span class="section-title">Forms & Support</span>';
		$out .= '<ul class="links">';

		while( have_rows('request_forms') ): the_row(); 

			// vars
			$link = get_sub_field('request_forms_link');

				if ($link) {
					$out .= '<li class="link"><a href="' . $link['url']  . '">' . $link['title'] . '</a></li>';
				}

		endwhile;

		$out .= '</ul>';

	}
	 
	$out .= '</div>';

	echo $out;

}

?>