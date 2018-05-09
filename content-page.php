<h1><?php the_title() ?></h1>

<?php 

the_content();

/* 
 *
 *
 *
 * MOVE THIS TO A TEMPLATE PART
 *
 *
 *
 */
echo '<div class="page-bottom">';
the_modified_date('F j, Y', '<div class="itc-updated-date">Last updated ', '</div>');
the_tags('<div class="tags"><span>Tags: </span>','','</div>'); 
echo '<div class="report-link-container">See a problem on this page? <a class="report-link">Let us know</a>.<div id="report-form">'
echo do_shortcode('[contact-form-7 id="42260" title="Report a problem"]');
echo '</div></div>';
echo '</div>';
?>