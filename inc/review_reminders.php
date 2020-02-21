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
            $YearAndHalfAgo = new DateTime('-18 Months');
            $OneYearAgo = new DateTime('-1 year');
            $TenMonthsAgo = new DateTime('-10 months');

            if ($reviewedDate < $TenMonthsAgo && $reviewedDate > $OneYearAgo)  {
                // Between 10 and 12 months since review
                $message = '<div class="review-reminder"><p><span class="review-header">This page should be reviewed soon.</span>It is approaching one year since this content was last reviewed. Plan ahead and set aside some to review this content by it’s next review-by date: <span class="review-by-date">XXX</span>.</p><ul><li><a target="_blank" href="https://itconnect.uw.edu/manager/tracking-content-review/">Learn more about tracking content review</a></li><li><a target="_blank" href="https://itconnect.uw.edu/manager/tracking-content-review/last-reviewed/">See a table of all pages with review and ownership information</a></li></ul></div>';
            } else if ($reviewedDate <= $OneYearAgo) {
                // A year or more since review
                $class = 'notice notice-warning';
                $message = '<div class="review-reminder"><p><span class="review-header">This page is due for a comprehensive review.</span>Based on the content review and ownership fields below on this page, it has been more than a year since this content has undergone a comprehensive review. The content was last marked as reviewed on <span class="last-reviewed-date">XXX</span>.</p><p>Content on IT Connect should be reviewed a minimum of once per year, and that review should be tracked with the “Last reviewed” and “Reviewed by” content tracking fields in the “Content review and ownership” section of the edit screen of the page.</p><p>Please review the content on this page for accuracy and relevance, and update the page with any new information or changes.</p><ul><li><a target="_blank" href="https://itconnect.uw.edu/manager/tracking-content-review/">Learn more about tracking content review</a></li><li><a target="_blank" href="https://itconnect.uw.edu/manager/tracking-content-review/last-reviewed/">See a table of all pages with review and ownership information</a></li></ul></div>';
            } else {
             // It's been less than 10 months since this content was reviewed so we do not want to show a messages
                return;
            }

            // If it has been more than a year and half, change notice color to error (red)
            if ($reviewedDate < $YearAndHalfAgo) {
                $class = 'notice notice-error';
            }
            
            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ),$message );

        // If reviewed_on field is not filled end, post message that page needs review ASAP
        } else {
        	$class = 'notice notice-error';
        	$message = '<div class="review-reminder"><p><span class="review-header">This page has not been marked as reviewed.</span>  Content on IT Connect should be reviewed a minimum of once per year, and that review should be tracked with the “Last reviewed” and “Reviewed by” content tracking fields in the “Content review and ownership” section of the edit screen of the page.</p><p>Please review the content on this page for accuracy and relevance, and update the page with any new information or changes as soon as possible.</p><ul><li><a target="_blank" href="https://itconnect.uw.edu/manager/tracking-content-review/">Learn more about tracking content review</a></li><li><a target="_blank" href="https://itconnect.uw.edu/manager/tracking-content-review/last-reviewed/">See a table of all pages with review and ownership information</a></li></ul></div>';
       		
            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ),$message );

       	}  
    }
}
add_action('admin_notices', 'content_review_notice');