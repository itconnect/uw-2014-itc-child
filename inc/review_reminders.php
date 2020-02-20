<?php 

function content_review_notice(){
    global $post;

    if ($post->post_type != 'page') {
        return;
    }

    // Check if the ACF plugins function is present or abort
    if (function_exists('get_field')) {
        $message = 'Please remember to review your content.';
        $class = 'notice notice-info';
        
        // Check if reviewed_on field is filled in
        if (get_field('reviewed_on', $post->ID)) {
            
            // Get last reviewed field date and convert to Unix timestamp
            $reviewed = get_field('reviewed_on');
            $reviewed = strtotime($reviewed);
            
            // Create PHP DateTime object from Unix timestamp and PHP DateTime object for now
            $reviewedDate = DateTime::createFromFormat('U', $reviewed);
            
            // Create benchmark times
            $now = new DateTime;
            $OneYearAgo = new DateTime('-1 year');
            $TenMonthsAgo = new DateTime('-10 months');

            if ($reviewedDate < $TenMonthsAgo && $reviewedDate > $OneYearAgo)  {
                // Between 10 and 12 months since review                                                      
                $message = 'Between 10 and 12 months since review';                                                     
            } else if ($reviewedDate <= $OneYearAgo) {
                // A year or more since review                                                                                   
                $class = 'notice notice-warning';                                                                                          
                $message = ' <b>More than 1 year since this page was reviewed</b>.';                                                       
            } else {                                                                                                                       
             // It's been less than 10 months since this content was reviewed so we do not want to show a messages                      
             return;                                                                                                                    
            }                                                                                                                              
            
            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ),$message );

        // If reviewed_on field is not filled end, post message that page needs review ASAP
        } else {
        	$class = 'notice notice-error';
        	$message = '<p><span style="color: #ff0000;"><b>This page has not been marked as reviewed.</b></span>  Content on IT Connect should be reviewed a minimum of once per year, and that review should be tracked with the “Last reviewed” and “Reviewed by” content tracking fields above. <b>Please review this content for accuracy and relevance as soon as possible. </b></p><p><a href="https://itconnect.uw.edu/manager/tracking-content-review/"><strong>Learn more about tracking content review</strong></a></p>';
       		
            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ),$message );

       	}  
    }
}
add_action('admin_notices', 'content_review_notice');