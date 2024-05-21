<?php

    $event_conference_theme_css= "";

    /*--------------------------- Scroll to top positions -------------------*/

    $event_conference_scroll_position = get_theme_mod( 'event_conference_scroll_top_position','Right');
    if($event_conference_scroll_position == 'Right'){
        $event_conference_theme_css .='#button{';
            $event_conference_theme_css .='right: 20px;';
        $event_conference_theme_css .='}';
    }else if($event_conference_scroll_position == 'Left'){
        $event_conference_theme_css .='#button{';
            $event_conference_theme_css .='left: 20px;';
        $event_conference_theme_css .='}';
    }else if($event_conference_scroll_position == 'Center'){
        $event_conference_theme_css .='#button{';
            $event_conference_theme_css .='right: 50%;left: 50%;';
        $event_conference_theme_css .='}';
    }

    /*---------------------------Slider Height ------------*/

    $event_conference_slider_img_height = get_theme_mod('event_conference_slider_img_height');
    if($event_conference_slider_img_height != false){
        $event_conference_theme_css .='#top-slider .owl-carousel .owl-item img{';
            $event_conference_theme_css .='height: '.esc_attr($event_conference_slider_img_height).';';
        $event_conference_theme_css .='}';
    }

    /*--------------------------- Woocommerce Product Border Radius -------------------*/

    $event_conference_woo_product_border_radius = get_theme_mod('event_conference_woo_product_border_radius', 0);
    if($event_conference_woo_product_border_radius != false){
        $event_conference_theme_css .='.woocommerce ul.products li.product a img{';
            $event_conference_theme_css .='border-radius: '.esc_attr($event_conference_woo_product_border_radius).'px;';
        $event_conference_theme_css .='}';
    }

    /*---------------- Single post Settings ------------------*/

    $event_conference_single_post_navigation_show_hide = get_theme_mod('event_conference_single_post_navigation_show_hide',true);
    if($event_conference_single_post_navigation_show_hide != true){
        $event_conference_theme_css .='.nav-links{';
            $event_conference_theme_css .='display: none;';
        $event_conference_theme_css .='}';
    }

    /*--------------------------- Footer background image -------------------*/

    $event_conference_footer_bg_image = get_theme_mod('event_conference_footer_bg_image');
    if($event_conference_footer_bg_image != false){
        $event_conference_theme_css .='#colophon{';
            $event_conference_theme_css .='background: url('.esc_attr($event_conference_footer_bg_image).')!important;';
        $event_conference_theme_css .='}';
    }

    /*--------------------------- Copyright Background Color -------------------*/

    $event_conference_copyright_background_color = get_theme_mod('event_conference_copyright_background_color');
    if($event_conference_copyright_background_color != false){
        $event_conference_theme_css .='.footer_info{';
            $event_conference_theme_css .='background-color: '.esc_attr($event_conference_copyright_background_color).' !important;';
        $event_conference_theme_css .='}';
    } 

    /*--------------------------- Site Title And Tagline Color -------------------*/

    $event_conference_logo_title_color = get_theme_mod('event_conference_logo_title_color');
    if($event_conference_logo_title_color != false){
        $event_conference_theme_css .='p.site-title a, .navbar-brand a{';
            $event_conference_theme_css .='color: '.esc_attr($event_conference_logo_title_color).' !important;';
        $event_conference_theme_css .='}';
    }

    $event_conference_logo_tagline_color = get_theme_mod('event_conference_logo_tagline_color');
    if($event_conference_logo_tagline_color != false){
        $event_conference_theme_css .='.logo p.site-description, .navbar-brand p{';
            $event_conference_theme_css .='color: '.esc_attr($event_conference_logo_tagline_color).'  !important;';
        $event_conference_theme_css .='}';
    }