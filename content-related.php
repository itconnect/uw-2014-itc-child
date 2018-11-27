<?php if( have_rows('related_information') ): ?>

	<ul class="slides">

	<?php while( have_rows('related_information') ): the_row(); 

		// vars
		$link = get_sub_field('related_information_link');

		?>

		<li class="slide">

			<?php if( $link ): ?>
				<a href="<?php echo $link; ?>">Link</a>
			<?php endif; ?>

		</li>

	<?php endwhile; ?>

	</ul>

<?php endif; ?>

<?php
/*
if ( get_field('display_related_information') && (get_field('related_information') || get_field('service_catalog') || get_field('request_forms')) ){

	$out .= '<div class="related-content">';


	$relatedinfo = get_field('related_information');
	if ($relatedinfo) {

		$out .= '<b>Related Information</b>';
		
		foreach ($relatedinfo as $related) {
			$out .= 'link ';
		}
	}

	$out .= '</div>';

	echo $out;

}
*/
?>