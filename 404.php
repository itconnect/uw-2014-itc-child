<?php get_header(); ?>

<?php get_template_part( 'header', 'image' ); ?>

<div class="container uw-body">

  <div class="row">

    <div <?php uw_content_class(); ?> role="main">

      <?php uw_site_title(); 
        echo "<span class='udub-slant'><span></span></span><h3 class='uw-site-tagline' >Information technology tools and resources at the UW</h3>";
      ?> 

      <?php get_template_part( 'breadcrumbs' ); ?>

        <div class="row show-grid">
          <div class="col-md-12">

            

            <div class="row show-grid">

              <div class="col-md-6">

                <div class="woof" style="background: url( <?php echo get_template_directory_uri() . '/assets/images/404.jpg' ?>) center center no-repeat; background-size: 100%;"></div>
                
                <h1>Sorry, we can't find that page.</h1>
                <p>Dubs tells us this page might not be what you had in mind when you set out on your journey through the UW Web.  Don&#146;t worry, we've created a list of pages that might be what you were looking for.</p>
              </div>

              <div class="col-md-5 col-md-offset-1">
                <?php
                  $url = parse_url($_SERVER['REQUEST_URI']);
                  $query = $url["path"];
                  $query = str_replace(['/', '-'], ' ', $query);
      
                  $args = array(
                      'post_type' => 'page',
                      'posts_per_page' => '5',
                      's' => $query
                  );
                  $search = new WP_Query( $args );
                  
                  //ob_start();
                  
                  if ( $search->have_posts() ) {

                    echo "<h4>Are any of these what you are looking for?</h4>";

                    while ( $search->have_posts() ) {
                       $search->the_post();
                           get_template_part( 'content', 'search' );
                    }
                  }else{
                    echo "<p>We were unable to find any alternative pages. Please try searching below or using the navigation above.</p>";
                  }

                ?>
                

                <?php get_search_form(); ?>
                
              </div>

              

            </div>

          </div>
        </div>

      </div>

  </div>

</div>

<?php get_footer(); ?>


