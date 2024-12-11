<?php
/**
 * Active Callback
 * 
 * @package Blossom_Wedding
*/

/**
 * Active Callback for Banner Slider
*/
function blossom_wedding_banner_ac( $control ){
    $banner      = $control->manager->get_setting( 'ed_banner_section' )->value();
    $slider_type = $control->manager->get_setting( 'slider_type' )->value();
    $control_id  = $control->id;
    
    if ( $control_id == 'header_image' && ( $banner == 'static_banner' ) ) return true;
    if ( $control_id == 'header_video' && ( $banner == 'static_banner' ) ) return true;
    if ( $control_id == 'external_header_video' && ( $banner == 'static_banner' ) ) return true;
    if ( $control_id == 'banner_title' && ( $banner == 'static_banner' ) ) return true;
    if ( $control_id == 'banner_subtitle' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'banner_description' && $banner == 'static_banner' ) return true;
    
    if ( $control_id == 'slider_type' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'slider_auto' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'slider_caption' && $banner == 'slider_banner' ) return true;              
    if ( $control_id == 'slider_cat' && $banner == 'slider_banner' && $slider_type == 'cat' ) return true;
    if ( $control_id == 'no_of_slides' && $banner == 'slider_banner' && $slider_type == 'latest_posts' ) return true;
    if ( $control_id == 'hr' && $banner == 'slider_banner' ) return true;
    
    return false;
}

/**
 * Active Callback for Blog View All Button
*/
function blossom_wedding_blog_view_all_ac( $control ){
    $blog = get_option( 'page_for_posts' );
    $ed_blog_section = $control->manager->get_setting( 'ed_blog_section' )->value();
    if( $blog && $ed_blog_section ) return true;
    
    return false; 
}

/**
 * Active Callback for post/page
*/
function blossom_wedding_post_page_ac( $control ){
    
    $ed_related = $control->manager->get_setting( 'ed_related' )->value();
    $control_id = $control->id;
    
    if ( $control_id == 'related_post_title' && $ed_related == true ) return true;
    if ( $control_id == 'ed_featured_image' ) return true;
    
    return false;
}

/**
 * Active Callback for newsletter shortcode
*/
function blossom_wedding_newsletter_ac( $control ){
    
    $ed_newsletter = $control->manager->get_setting( 'ed_newsletter' )->value();
    $control_id = $control->id;
    
    if ( blossom_wedding_is_btnw_activated() && $control_id == 'newsletter_shortcode' && $ed_newsletter == true ) return true;
    
    return false;
}

/**
 * Active Callback for story section
*/
function blossom_wedding_story_section_active( $control ){
    
    $ed_story_section = $control->manager->get_setting( 'ed_story_section' )->value();
    
    if ( $ed_story_section ) return true;
    
    return false;
}

/**
 * Active Callback for officiant section
*/
function blossom_wedding_officiant_section_active( $control ){
    
    $ed_officiant_section = $control->manager->get_setting( 'ed_officiant_section' )->value();
    
    if ( $ed_officiant_section ) return true;
    
    return false;
}

/**
 * Active Callback for gallery section
*/
function blossom_wedding_gallery_section_active( $control ){
    
    $ed_gallery_section = $control->manager->get_setting( 'ed_gallery_section' )->value();
    
    if ( $ed_gallery_section ) return true;
    
    return false;
}

/**
 * Active Callback for blog section
*/
function blossom_wedding_blog_section_active( $control ){
    
    $ed_blog_section = $control->manager->get_setting( 'ed_blog_section' )->value();
    
    if ( $ed_blog_section ) return true;
    
    return false;
}

/**
 * Active Callback for Breadcrumbs
*/
function blossom_wedding_breadcrumbs_active( $control ){
    
    $ed_breadcrumb = $control->manager->get_setting( 'ed_breadcrumb' )->value();
    
    if ( $ed_breadcrumb ) return true;
    
    return false;
}

/**
 * Active Callback for local fonts
*/
function blossom_wedding_ed_localgoogle_fonts(){
    $ed_localgoogle_fonts = get_theme_mod( 'ed_localgoogle_fonts' , false );

    if( $ed_localgoogle_fonts ) return true;
    
    return false; 
}