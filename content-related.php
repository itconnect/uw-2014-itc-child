<?php
/*
 * This content area relies on Advanced Custom Fields Pro existing and only works if it does.
 * 
 */
//Checks if ACF funciton exists before executing code that relies on plugin
if (function_exists('have_rows') {
	//Check if the display toggle is checked and if any of the related content type actually have rows before going any further
	if ( get_field('display_related_information') && (have_rows('related_information') || have_rows('service_catalog') || have_rows('request_forms')) ){
		
		// While the rows might exist, also need to check if they have content otherwise empty rows will
		// still force display of widget. This is also done for each of the 3 content types below.
		$hasContent = false;

		$out .= '<aside class="related-content" aria-label="related content">';

		// Related Info Subgroup
		if( have_rows('related_information') ) {

			$hasRelatedContent = false;
			$related .= '<span class="section-title">Related Information</span>';
			$related .= '<ul class="links">';

			while( have_rows('related_information') ): the_row(); 

				// vars
				$link = get_sub_field('related_information_link');

					if ($link) {
						$related .= '<li class="link"><a href="' . $link['url']  . '">' . $link['title'] . '</a></li>';
						$hasContent = true;
						$hasRelatedContent = true;
					}

			endwhile;

			$related .= '</ul>';
			if ($hasRelatedContent){
				$out .= $related;
			}

		}

		// Service Catalog Subgroup
		if( have_rows('service_catalog') ) {

			$hasScatContent = false;
			$scat .= '<span class="section-title">UW-IT Service Catalog</span>';
			$scat .= '<ul class="links">';

			while( have_rows('service_catalog') ): the_row(); 

				// vars
				$link = get_sub_field('service_catalog_link');

					if ($link) {
						$scat .= '<li class="link"><a href="' . $link['url']  . '">' . $link['title'] . '</a></li>';
						$hasContent = true;
						$hasScatContent = true;
					}

			endwhile;

			$scat .= '</ul>';
			if ($hasScatContent){
				$out .= $scat;
			}
		}

		// Request Forms Subgroup
		if( have_rows('request_forms') ) {

			$hasReqContent = false;
			$req .= '<span class="section-title">Forms & Support</span>';
			$req .= '<ul class="links">';

			while( have_rows('request_forms') ): the_row(); 

				// vars
				$link = get_sub_field('request_forms_link');

					if ($link) {
						$req .= '<li class="link"><a href="' . $link['url']  . '">' . $link['title'] . '</a></li>';
						$hasContent = true;
						$hasReqContent = true;
					}

			endwhile;

			$req .= '</ul>';
			if ($hasReqContent){
				$out .= $req;
			}

		}
		 
		$out .= '</div>';

		if ($hasContent) {
			echo $out;
		}

	}
}

?>