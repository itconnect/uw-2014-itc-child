<?php get_header(); ?>

<?php get_template_part( 'header', 'image' ); ?>

<div class="container uw-body">

  <div class="row">

    <div <?php uw_content_class(); ?> role='main'>

      <?php uw_site_title(); ?>

      <?php get_template_part('menu', 'mobile'); ?>

      <?php get_template_part( 'breadcrumbs' ); ?>

      <div id='main_content' class="uw-body-copy" tabindex="-1">

        <form role="search" method="get" id="searchform" class="searchform" action="<?php echo set_url_scheme( home_url('/') ) ?>">
          <div>
            <label class="screen-reader-text" for="s">Search for:</label>
            <input type="text" value="" name="s" id="s" placeholder="Search for:" autocomplete="off">
            <input type="submit" id="searchsubmit" value="Search">
            <input type="checkbox" id="pages" name="pages" value="pages">
            <label for="pages">Documentation</label>
            <input type="checkbox" id="news" name="news" value="news">
            <label for="news">News and communications</label>
            <input type="checkbox" id="services" name="services" value="services">
            <label for="services">Service Catalog</label>
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
