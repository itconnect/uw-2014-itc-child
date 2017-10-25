<div class="search results_wrap">
<?php
if ($post->post_type == 'post'){
	the_date('F j, Y', '<p class="date">', '</p>');
}
?> 
<h3>
  <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title() ?> </a>
</h3>

<?php

include( locate_template( 'search-breadcrumbs.php' ) );

?>

</div>