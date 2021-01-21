<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" class="no-js">
    <head>
        <title> <?php wp_title(' | ',TRUE,'right'); bloginfo('name'); ?> </title>
        <meta charset="utf-8">
        <?php
        /*<meta name="description" content="<?php bloginfo('description', 'display'); ?>">*/
        if (is_front_page()) {
            ?>
                <meta name="description" content="<?php bloginfo('description', 'display'); ?>">
            <?php
        } else {
            if (get_field('custom_search_result_snippet')){
                ?>
                    <meta name="description" content="<?php the_field('custom_search_result_snippet'); ?>">
                <?php
            } else {
                ?>
                <meta name="description" content="<?php bloginfo('description', 'display'); ?>">
            <?php 
            }
        }
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php 
            if (is_search()) {
                ?><meta name="robots" content="noindex"><?php
            }
        ?>

        <!-- FontAwesome Icons -->
        <script src="https://kit.fontawesome.com/80ee7785e6.js" crossorigin="anonymous"></script>

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MCGKD3T');</script>
        <!-- End Google Tag Manager -->

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <?php wp_head(); ?>

        <!--[if lt IE 9]>
            <script src="<?php bloginfo("template_directory"); ?>/assets/ie/js/html5shiv.js" type="text/javascript"></script>
            <script src="<?php bloginfo("template_directory"); ?>/assets/ie/js/respond.js" type="text/javascript"></script>
            <link rel='stylesheet' href='<?php bloginfo("template_directory"); ?>/assets/ie/css/ie.css' type='text/css' media='all' />
        <![endif]-->

        <?php
        echo get_post_meta( get_the_ID() , 'javascript' , 'true' );
        echo get_post_meta( get_the_ID() , 'css' , 'true' );
        ?>

    </head>
    <!--[if lt IE 9]> <body <?php body_class('lt-ie9'); ?>> <![endif]-->
    <!--[if gt IE 8]><!-->
    <body <?php body_class(); ?> >
    <!--<![endif]-->

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MCGKD3T"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
   
   <a id="main-content" href="#main_content" class='screen-reader-shortcut'>Skip to main content</a>

    <div id="uw-container">

    <div id="uw-container-inner">


    <?php get_template_part('thinstrip_itc'); ?>

    <?php require( get_template_directory() . '/inc/template-functions.php' );
          uw_dropdowns(); ?>
