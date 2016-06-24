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

$parents = get_post_ancestors($post->ID);
$parents = array_reverse($parents);
$html = '<div class="search-breadcrumbs">';
foreach ($parents as $parent) {
	$html .= '<span class="crumb">' . get_the_title($parent) . '</span>';
}
$html .= '</div>'
echo $html;
?>

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