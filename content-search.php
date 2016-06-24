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

$ancestors[] = $post->ID;
foreach ( array_filter( $ancestors ) as $index=>$ancestor ) {
	$class      = $index+1 == count($ancestors) ? ' class="current" ' : '';
	$page       = get_post( $ancestor );
	$url        = get_permalink( $page->ID );
  	$title_attr = esc_attr( $page->post_title );
  	if (!empty($class)){
    	$html .= "<li $class><span>" . $page->post_title . "</span></li>";
  	} else {
    	$html .= "<li><a href=\"$url\" title=\"{$title_attr}\">{$page->post_title}</a></li>";
  	} 
} 
?>
<nav class='uw-breadcrumbs' role='navigation' aria-label='breadcrumbs'><ul><?php $html ?></ul></nav>

<?php
if (get_option('show_byline_on_posts')) :
?>
<div class="author-info">
    <?php the_author(); ?>
    <p class="author-desc"> <small><?php the_author_meta(); ?></small></p>
</div>
<?php
endif;
  if ( ! is_home() && ! is_search() && ! is_archive() ) :
    uw_mobile_menu();
  endif;
 if ( has_post_thumbnail() ) :
 	the_post_thumbnail();
 endif;
?>
<?php the_excerpt(); ?>
</div>