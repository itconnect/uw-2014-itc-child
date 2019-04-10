<?php get_header(); 
   $sidebar = get_post_meta($post->ID, "sidebar"); ?>

<?php get_template_part( 'header', 'image' ); ?>

<div class="container uw-body" role='main'>

  <div class="row">

    <div class="hero-container">

      <?php
      if ( is_front_page() ) :
      ?>
       <a href="/"><h1 class="uw-site-title">IT Connect</h1></a>
      <?php
      else:
        uw_site_title();
      endif;
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

    <?php get_template_part( 'menu', 'mobile' ); ?>

    <?php get_template_part( 'breadcrumbs' ); ?>

    <aside id="sidebar" role="complementary">
        <?php

          $taxonomy = 'portfolio_categories';
          $terms = get_terms($taxonomy); // Get all terms of a taxonomy

          if ( $terms && !is_wp_error( $terms ) ) :
          ?>
              <ul>
                  <?php foreach ( $terms as $term ) { ?>
                      <li><a href="<?php echo get_term_link($term->slug, $taxonomy); ?>"><?php echo $term->name; ?></a></li>
                  <?php } ?>
              </ul>
          <?php endif;?>

        ?>
    </aside>

    <div class="col-md-<?php echo ((!isset($sidebar[0]) || $sidebar[0]!="on") ? "9" : "12" ) ?> uw-content">

      <div id='main_content' class="uw-body-copy" tabindex="-1">

        <?php
          // Start the Loop.
          while ( have_posts() ) : the_post();

            /*
             * Include the post format-specific template for the content. If you want to
             * use this in a child theme, then include a file called called content-___.php
             * (where ___ is the post format) and that will be used instead.
             */
            get_template_part( 'content', 'page' );




            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
              comments_template();
            }

          endwhile;
        ?>



      </div>

    </div>

  </div>

  <div id="mobile-sidebar-menu"><div class="uw-sidebar">
    <?php uw_sidebar_menu(); ?>
  </div></div>

</div>

<?php get_footer(); ?>