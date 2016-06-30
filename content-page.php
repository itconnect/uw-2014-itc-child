<h1><?php the_title() ?></h1>

<?php 

the_content();

the_tags('<div class="tags"><span>Tags: </span>',', ','</div>'); 

?>