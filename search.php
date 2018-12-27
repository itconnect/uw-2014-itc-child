<?php get_header(); ?>


<?php get_template_part( 'header', 'image' ); ?>

<div class="container uw-body" role="main">

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

    </div>

    <div <?php uw_content_class(); ?> role='main'>

      <?php get_template_part('menu', 'mobile'); ?>

      <?php get_template_part( 'breadcrumbs' ); ?>

      <div id='main_content' class="uw-body-copy" tabindex="-1">

        <form role="search" method="get" id="searchresultsform" class="searchresultsform" action="<?php echo set_url_scheme( home_url('/') ) ?>">
          <div id="searchbox"> 
            <label class="screen-reader-text" for="s">Search for:</label>
            <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" placeholder="Search IT Connect for:" autocomplete="off">
            <input type="submit" id="searchsubmit" value="Search">
            <fieldset class="filters">
              <legend>Include the following types of content:</legend>
              <input type="checkbox" id="pages" name="pages" value="true" checked>
              <label for="pages">Guides, tools, and resources</label>
              <input type="checkbox" id="news" name="news" value="true" checked>
              <label for="news">News</label>
              <input type="checkbox" id="services" name="services" value="true" checked>
              <label for="services">UW-IT Service Catalog</label>
            </fieldset>
          </div>
        </form>

        <?php
          if ( have_posts() ) :
            while ( have_posts() ) : the_post();
              get_template_part( 'content', 'search' );
            endwhile;
          else :
            echo '<h3 class=\'no-results\'>Sorry, no results matched your criteria.</h3>';
          endif;
        ?>


        <?php posts_nav_link(' '); ?>

      </div>

    </div>

    <?php get_sidebar() ?>

  </div>

</div>

<?php get_footer(); ?>
