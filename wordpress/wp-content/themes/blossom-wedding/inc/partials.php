<?php
/**
 * Blossom Wedding Customizer Partials
 *
 * @package Blossom_Wedding
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function blossom_wedding_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function blossom_wedding_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if( ! function_exists( 'blossom_wedding_get_read_more' ) ) :
/**
 * Display blog readmore button
*/
function blossom_wedding_get_read_more(){
    return esc_html( get_theme_mod( 'read_more_text', __( 'READ THE ARTICLE', 'blossom-wedding' ) ) );    
}
endif;

if( ! function_exists( 'blossom_wedding_get_header_text' ) ) :
/**
 * Display header button
*/
function blossom_wedding_get_header_text(){
    return esc_html( get_theme_mod( 'header_button_text', __( 'RSVP', 'blossom-wedding' ) ) );    
}
endif;

if( ! function_exists( 'blossom_wedding_get_related_title' ) ) :
/**
 * Display blog readmore button
*/
function blossom_wedding_get_related_title(){
    return esc_html( get_theme_mod( 'related_post_title', __( 'Recommended Articles', 'blossom-wedding' ) ) );
}
endif;

if( ! function_exists( 'blossom_wedding_get_banner_title' ) ) :
/**
 * Banner Title
*/
function blossom_wedding_get_banner_title(){
    return esc_html( get_theme_mod( 'banner_title', __( 'Brittany &amp; Steven', 'blossom-wedding' ) ) );
}
endif;

if( ! function_exists( 'blossom_wedding_get_banner_sub_title' ) ) :
/**
 * Banner SubTitle
*/
function blossom_wedding_get_banner_sub_title(){
    return esc_html( get_theme_mod( 'banner_subtitle', __( 'Save the Day', 'blossom-wedding' ) ) );
}
endif;

if( ! function_exists( 'blossom_wedding_get_banner_desciption' ) ) :
/**
 * Banner Description
*/
function blossom_wedding_get_banner_desciption(){
    return esc_html( get_theme_mod( 'banner_description', __( 'JULY 23, 2018 - 11:00AM Red Barn Farm of Northfield10063 110th Street East, Northfield Minnesota', 'blossom-wedding' ) ) );
}
endif;

if( ! function_exists( 'blossom_wedding_get_story_section_title' ) ) :
/**
 * Story Title
*/
function blossom_wedding_get_story_section_title(){
    return esc_html( get_theme_mod( 'story_section_title', __( 'Our Love Story', 'blossom-wedding' ) ) );
}
endif;

if( ! function_exists( 'blossom_wedding_get_story_section_content' ) ) :
/**
 * Story SubTitle
*/
function blossom_wedding_get_story_section_content(){
    return esc_html( get_theme_mod( 'story_section_content', __( 'It\'s not too often that you find someone who can finish your sentences, let alone correct your improper use of a Dumb and Dumber quote. Whether it be a lazy Sunday on the couch or a run outside in the Summer, we are always happy just being together. What started off as a friendship soon grew into something much more than coincidence.', 'blossom-wedding' ) ) );
}
endif;

if( ! function_exists( 'blossom_wedding_get_story_section_end_title' ) ) :
/**
 * Story Title
*/
function blossom_wedding_get_story_section_end_title(){
    return esc_html( get_theme_mod( 'story_section_end_title', __( 'Adventure Begins', 'blossom-wedding' ) ) );
}
endif;

if( ! function_exists( 'blossom_wedding_get_story_section_end_content' ) ) :
/**
 * Story SubTitle
*/
function blossom_wedding_get_story_section_end_content(){
    return esc_html( get_theme_mod( 'story_section_end_content', __( 'AND SO THE', 'blossom-wedding' ) ) );
}
endif;

if( ! function_exists( 'blossom_wedding_get_officiant_section_title' ) ) :
/**
 * Officiant Title
*/
function blossom_wedding_get_officiant_section_title(){
    return esc_html( get_theme_mod( 'officiant_section_title', __( 'Wedding Officiant', 'blossom-wedding' ) ) );
}
endif;

if( ! function_exists( 'blossom_wedding_get_blog_section_title' ) ) :
/**
 * Blog Title
*/
function blossom_wedding_get_blog_section_title(){
    return esc_html( get_theme_mod( 'blog_section_title', __( 'From the Blog', 'blossom-wedding' ) ) );
}
endif;

if( ! function_exists( 'blossom_wedding_get_blog_view_all' ) ) :
/**
 * Blog View More
*/
function blossom_wedding_get_blog_view_all(){
    return esc_html( get_theme_mod( 'blog_view_all', __( 'VIEW MORE POSTS', 'blossom-wedding' ) ) );
}
endif;

if( ! function_exists( 'blossom_wedding_get_footer_copyright' ) ) :
/**
 * Footer Copyright
*/
function blossom_wedding_get_footer_copyright(){
    $copyright = get_theme_mod( 'footer_copyright' );
    echo '<span class="copyright">';
    if( $copyright ){
        echo wp_kses_post( $copyright );
    }else{
        esc_html_e( '&copy; Copyright ', 'blossom-wedding' );
        echo date_i18n( esc_html__( 'Y', 'blossom-wedding' ) );
        echo ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>. ';
        esc_html_e( 'All Rights Reserved. ', 'blossom-wedding' );
    }
    echo '</span>'; 
}
endif;