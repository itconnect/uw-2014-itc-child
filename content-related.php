<?php

if ( get_field('display_related_information') && (get_field('related_information') || get_field('service_catalog') || get_field('request_forms')) ){

	$out .= '<div class="related-content">';

	$out .= '<b>Related Information</b>';

	$relatedinfo = get_field('related_information');
	if ($relatedinfo) {
		foreach $relatedinfo as $related {
			$out .= 'link ';
		}
	}

	$out .= '</div>';

	echo $out;

}

?>