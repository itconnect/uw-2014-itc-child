<?php echo "<!-- Using content.php template -->" ?>

<?php
if (is_single() || is_home()){
    the_date('F j, Y', '<p class="date">', '</p>');
}
?>
<h1 class="news-heading"><?php the_title() ?></h1>
<?php
if ((is_single() || is_home()) && get_option('show_byline_on_posts')) :
?>
<div class="author-info">
    <?php the_author(); ?>
    <p class="author-desc"> <small><?php the_author_meta(); ?></small></p>
</div>
<?php
endif;
?>

<?php
  

  if ( is_archive() || is_home() || is_single() ) {
    the_post_thumbnail( array(130, 130), array( 'class' => 'attachment-post-thumbnail blogroll-img' ) );
    the_content();
    echo "<hr>";
  } else
    the_content();
    //comments_template(true);
 ?>
