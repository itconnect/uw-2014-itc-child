<?php get_header(); ?>

<?php get_template_part( 'header', 'image' ); ?>

<div class="container uw-body">

  <div class="row">

    <div <?php uw_content_class(); ?> role="main">

      <div class="hero-container">

        <?php
          uw_site_title();
        ?>
        <span class='udub-slant'><span></span></span>
        <div class='uw-site-tagline' >Information technology tools and resources at the UW</div>

        <div class="hero-search">
          <form role="search" method="get" id="searchform" class="searchform" action="https://itconnect.uw.edu/">
            <div>
              <label class="screen-reader-text" for="s">Search IT Connect:</label>
              <input type="text" value="" name="s" id="s" placeholder="Search IT Connect:" autocomplete="off">
              <button type="submit" aria-label="Submit search" class="hero-search-submit"></button>
            </div>
          </form>
        </div>

      </div>

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

                get_template_part( 'content', 'alternatives' );

                get_search_form(); 

                ?>
                
              </div>

            </div>

          </div>
        </div>

      </div>

  </div>

</div>

<?php get_footer(); ?>


