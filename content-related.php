

<?php

if ( get_field('display_related_information') && (get_field('related_information') || get_field('service_catalog') || get_field('request_forms')) ){

	$out .= '<div class="related-content">';

	// Related Info Subgroup
	if( have_rows('related_information') ): 

		$out .= '<ul class="links">';

		while( have_rows('related_information') ): the_row(); 

			// vars
			$link = get_sub_field('related_information_link');

				if ($link) {
					$out .= '<li class="link"><a href="' . $link['url']  . '">' . $link['title'] . '</a></li>';
				}

		endwhile;

		$out .= '</ul>';

	endif; 

	// Service Catalog Subgroup



	// Request Forms Subgroup



	}

	$out .= '</div>';

	echo $out;

}

?>