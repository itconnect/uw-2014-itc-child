<?php
  $url = parse_url($_SERVER['REQUEST_URI']);
  $query = $url["path"];
  $query = str_replace(['/', '-'], ' ', $query);

  $toplevel = array('connect', 'wares', 'learn', 'research', 'work', 'security');

  foreach ($toplevel as &$word) {
      $word = '/\b' . preg_quote($word, '/') . '\b/';
  }   

  $query = preg_replace($toplevel, '', $query);

  $args = array(
      'post_type' => 'page',
      'posts_per_page' => '5',
      's' => $query
  );
  $search = new WP_Query( $args );
  
  if(function_exists('relevanssi_do_query')) {
    relevanssi_do_query($search);
  }

  if ( $search->have_posts() ) {

    echo "<h4>Are any of these what you were looking for?</h4>";

    while ( $search->have_posts() ) {
       $search->the_post();


        echo '<div class="search results_wrap">';

        if ($post->post_type == 'post'){
          the_date('F j, Y', '<p class="date">', '</p>');
        }

        echo '<h3><a href="' . the_permalink() . '" title="' . the_title_attribute() . '">' . the_title() . '</a></h3>';

        include( locate_template( 'search-breadcrumbs.php' ) );

        echo '</div>';

    }
  }else{
    echo "<p><b>We were unable to find any alternative pages. Please try searching below or using the navigation above.</b></p>";
  }

?>