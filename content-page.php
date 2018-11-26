<h1><?php the_title() ?></h1>

<?php 

the_content();

get_content_part( 'content', 'related' );

get_template_part( 'content', 'pagebottom' );

?>