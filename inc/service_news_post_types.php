<?php

/**
 * Add Service News post type
 */

function servicenews_post_type () {
  $labels = array(
    'name'               => _x( 'Service News', 'post type general name' ),
    'singular_name'      => _x( 'Service News', 'post type singular name' ),
    'add_new'            => _x( 'Add Service News', 'service news' ),
    'add_new_item'       => __( 'Add Service News' ),
    'edit_item'          => __( 'Edit Service News' ),
    'new_item'           => __( 'New Service News' ),
    'all_items'          => __( 'All Service News' ),
    'view_item'          => __( 'View Service News' ),
    'search_items'       => __( 'Search Service News' ),
    'not_found'          => __( 'No Service News found' ),
    'not_found_in_trash' => __( 'No Service News found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Service News'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'News content type for use by UW-IT Services on IT Connect',
    'public'        => true,
    'publicly_queryable' => true,
    'menu_position' => 5,
    'rewrite' => array('slug' => 'service-news'),
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
    'taxonomies'  => array( 'svcnewscats' ),
  );
  register_post_type( 'servicenews', $args ); 
}
add_action( 'init', 'servicenews_post_type' );


/**
 * Create heirarchichal taxonomy for service news
 */

function create_svcnewscats_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Service News Categories', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Service News Category', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Search Service News Categories', 'textdomain' ),
        'all_items'         => __( 'All Service News Categories', 'textdomain' ),
        'parent_item'       => __( 'Parent Category', 'textdomain' ),
        'parent_item_colon' => __( 'Parent Category:', 'textdomain' ),
        'edit_item'         => __( 'Edit Category', 'textdomain' ),
        'update_item'       => __( 'Update Category', 'textdomain' ),
        'add_new_item'      => __( 'Add New Category', 'textdomain' ),
        'new_item_name'     => __( 'New Category Name', 'textdomain' ),
        'menu_name'         => __( 'Categories', 'textdomain' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'svcnewscats' ),
    );

    register_taxonomy( 'svcnewscats', array( 'servicenews' ), $args );
}
add_action( 'init', 'create_svcnewscats_taxonomies', 0 );


add_shortcode( 'service_news', 'service_news_blogroll' );
function service_news_blogroll($atts){
    /* 
     * Expects:
     * news_category: The Service News category to display
     * 
     * Optional:
     * format: string "full" "compact" or "mini". Sets the format style for the output (default: full)
     * posts_per_page: number. The number of posts to show before pagination (default: 10)
     * pagination: string "off". Surpresses display of pagination
     * show_date: string "off". Surpresses display of date
     * readmore: string "off". Surpresses display of the read more link.
     */

    global $paged;
    global $post;
    $current_id = $post->ID;

    // Check if there is a category for the news, and reject if absent
    if (isset($atts['news_category'])) {
        $news_category = $atts['news_category'];
    } else {
        $output .= 'Please set a category by entering a category slug for the news_category attribute on the shortcode.';
        $output .= '<br /><br /><b>Example:</b> [service_news news_category="myslug"]'; 
        return $output;
    }

    // Determine format for news
    $format = 'full';
    if (isset($atts['format'])) {
        if ($atts['format'] == 'mini' || $atts['format'] == 'compact') { 
            $format = $atts['format'];
        }
    }

    // Sets number of words to display based on format
    if ($format=="compact"){ $wordlength = 15; } else { $wordlength = 42; }

    // Set the number of posts to grab per page
    if (isset($atts['posts_per_page'])) {$numPosts = $atts['posts_per_page'];} else {$numPosts = 10; $limited='on';}

    // Determine if pagniation should be shown
    if (isset($atts['pagination']) && $atts['pagination'] == 'off' ) { $pagination = 'off';} else { $pagination = 'on';}

    // Determine if date should be shown
    $show_date = 'on';
    if ((isset($atts['show_date'])) && $atts['show_date'] == 'off'){ 
        $show_date = 'off'; 
    }

    $args = array(
        'post_type' => 'servicenews',
        'posts_per_page' => $numPosts,
        'paged' => $paged,
        'tax_query' => array(
            array(
                'taxonomy' => 'svcnewscats',
                'field' => 'slug',
                'terms' => $news_category
            )
        )
    );

    $service_news_posts = new WP_Query($args);

    // Sets variables for pagination based on results
    $total_found_posts = $service_news_posts->found_posts;
    $total_page = ceil($total_found_posts / $numPosts);

    if($service_news_posts->have_posts()) :

        $output .= '<div class="service-news ' . $format . '">';

        while($service_news_posts->have_posts()) : $service_news_posts->the_post();

            $title = get_the_title();
            $link = get_permalink();
            if ( has_excerpt( $post->ID ) ) {
                $bodytext = get_the_excerpt();
            } else {
                $bodytext = apply_filters( 'the_content', wp_trim_words( strip_tags( get_the_content() ), $wordlength ) );
            }
            $image = get_the_post_thumbnail($post->ID, 'thumbnail');

            $output .= '<div id="postrow-' . $post->ID . '" class="postrow ' . $format . '">';

            $output .= '<h3 class="posttitle"><a class="postlink" href="' . $link;
            if ($current_id) {
                $output .= '?origin=' . $current_id; 
            }
            $output .='">' . $title . '</a></h3>';

            if ($show_date != 'off'){ $output .= '<span class="date">' . get_the_date( 'M. d, Y' ) . '</span>'; }

            if ($format == 'compact') {
                $output .= '<p class="postexcerpt">' . $bodytext  . '</p>';
            } else if ($format == 'full') {
                $output .= '<p class="postexcerpt">' . $image . $bodytext  . '</p>';
                $output .= '<a class="more" href="' . $link . '">Read more</a>';

            }

            $output .= '</div>'; // postrow div

        endwhile;

        if ($pagination == "on") {
            $output .= '<div class="pagination-wrap ' . $format . '">';
            $output .= '<span class="prev-posts-links">' . get_previous_posts_link('Previous page').'</span>';
            $output .= '<span class="next-posts-links">' . get_next_posts_link('Next page', $total_page) .'</span>';
            $output .= '</div>';
        }

        $output .= '</div>'; // Service News div


    else: 

        $output .= 'No posts were found for the selected category slug.';

    endif;

    return $output;
}
