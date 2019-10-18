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

    <nav class="uw-breadcrumbs" role="navigation" aria-label="breadcrumbs">
      <ul>
        <li>
          <a href="http://uw.edu" title="University of Washington">Home</a>
        </li>
        <li>
          <a href="https://itconnect.uw.edu/" title="IT Connect">IT Connect</a>
        </li>
        <li>
          <a href="/service-news/" title="Service News">Service News</a>
        </li>
        <?php 
          if (has_term('','svcnewscats')) {
            $count = 0;
            foreach (get_the_terms(get_the_ID(), 'svcnewscats') as $cat) {
              if ($cat->parent == "0" && $count == 0){
                echo '<li><a href="' . get_category_link($cat->term_id) . '">' . $cat->name . '</a></li>';
                $count=1;
              }
            }
          }
          if (isset($_GET['origin'])) {
            $origin = $_GET['origin'];
            $title = get_the_title($origin);
            $permalink = get_the_permalink($origin);
            echo '<li><a href="' . $permalink . '">' . $title . '</a></li>';
          }
        ?>
        <li class="current"><span><?php the_title() ?></span></li></ul>
        </nav>

    <aside id="sidebar" role="complementary">
      <div class="col-md-3 uw-sidebar">
        <nav id="desktop-relative" aria-label="relative content">
          <ul class="uw-sidebar-menu first-level"><li class="pagenav"><a href="https://ovp.s.uw.edu" title="Home" class="homelink">Home</a>
            <ul>
              <li class="page_item page_item_has_children current_page_ancestor current_page_parent">
                <?php 
                if (isset($_GET['origin'])) {
                    $origin = $_GET['origin'];
                    $title = get_the_title($origin);
                    $permalink = get_the_permalink($origin);
                    echo '<a href="' . $permalink . '">' . $title . '</a>';
                } elseif (has_term('','svcnewscats')) {
                    $count = 0;
                    foreach (get_the_terms(get_the_ID(), 'svcnewscats') as $cat) {
                        if ($cat->parent == "0" && $count == 0){
                            echo '<a href="' . get_category_link($cat->term_id) . '">' . $cat->name . ' News</a>';
                            $count=1;
                        }
                    }
                } else {
                    echo '<a href="/service-news/">Service News</a>';
                }
                ?>
                <ul class="children">
                  <li class="page_item page_item_has_children current_page_item"><span><?php the_title(); ?></span></li>
                  <?php
                    if (isset($_GET['origin'])) {
                      foreach (get_the_terms(get_the_ID(), 'svcnewscats') as $cat) {
                        if ($cat->parent == "0"){
                            echo '<li class="page_item"><a href="' . get_category_link($cat->term_id) . '">' . $cat->name . ' News</a></li>';
                        }
                      }
                    }
                  ?>
                  <li class="page_item page_item_has_children child-page-existance-tester"><a href="/service-news/">All Service News</a></li>
                </ul>
              </li>
            </ul>
          </ul>
        </nav>
        <div class="svcnewscats-wrap">
          <h2>Service News by Category</h2>
          <ul class="svcnewscats-list">
          <?php
              wp_list_categories(array('taxonomy'=>'svcnewscats','depth'=>'2','title_li'=>''));
          ?>
        </div>
    </aside>

    <div class="col-md-<?php echo ((!isset($sidebar[0]) || $sidebar[0]!="on") ? "9" : "12" ) ?> uw-content">

      <div id='main_content' class="uw-body-copy" tabindex="-1">

        <?php
          // Start the Loop.
          while ( have_posts() ) : the_post();

            echo '<h1>' . get_the_title() . '</h1>';

            the_content();

            echo '<div class="page-bottom">';

            echo '<div class="tags"><span>Categories: </span>';

            foreach (get_the_terms(get_the_ID(), 'svcnewscats') as $cat) {
              echo '<a href="/svcnewscats/' . $cat->slug . '">' . $cat->name . '</a>';
            }

            echo '</div>';

            echo '<div class="report-link-container">See a problem on this page? <a class="report-link" href="javascript:void(0);">Let us know</a>.<div id="report-form">';
            echo do_shortcode('[contact-form-7 id="42260" title="Report a problem"]');
            echo '</div></div>';
            echo '</div>';

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