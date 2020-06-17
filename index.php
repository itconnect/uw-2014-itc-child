<?php get_header(); ?>

<?php get_template_part( 'header', 'image' ); ?>

<div class="container uw-body">

  <div class="row">

      <div class="hero-container">

        <?php uw_site_title(); ?>

        <span class='udub-slant'><span></span></span>
        <h3 class='uw-site-tagline' >Your connection to information technology at UW</h3>
        
        <div class="hero-search">
          <form role="search" method="get" id="searchform-hero" class="searchform" action="/">
            <div>
              <label class="screen-reader-text" for="s">Search IT Connect:</label>
              <input type="text" value="" name="s" id="s" placeholder="Search IT Connect:" autocomplete="off">
              <button type="submit" aria-label="Submit search" class="hero-search-submit"></button>
            </div>
          </form>
        </div>

      </div>

      <?php get_template_part('menu', 'mobile'); ?>

      <?php get_template_part( 'breadcrumbs' ); ?>

    <div <?php uw_content_class(); ?> role='main'>

      <div id='main_content' class="uw-body-copy" tabindex="-1">

  			<?php
  				// Start the Loop.
  				while ( have_posts() ) : the_post();

  					/*
  					 * Include the post format-specific template for the content. If you want to
  					 * use this in a child theme, then include a file called called content-___.php
  					 * (where ___ is the post format) and that will be used instead.
  					 */
  					get_template_part( 'content', get_post_format() );

  					// If comments are open or we have at least one comment, load up the comment template.
  					if ( comments_open() || get_comments_number() ) {
  				        comments_template();
  					}

  				endwhile;
  			?>

            <span class="next-page"><?php next_posts_link( 'Next page', '' ); ?></span>

      </div>

    </div>

    <?php get_sidebar() ?>

  </div>

</div>

<?php get_footer(); ?>
