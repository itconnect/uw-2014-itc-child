<h1><?php the_title() ?></h1>

<?php 

get_template_part( 'content', 'related' );

the_content();

get_template_part( 'content', 'pagebottom' );

?>