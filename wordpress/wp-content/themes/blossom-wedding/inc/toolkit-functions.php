<?php
/**
 * Toolkit Filters
 *
 * @package Blossom_Wedding
 */

if( ! function_exists( 'blossom_wedding_default_icon_text_image_size' ) ) :
    function blossom_wedding_default_icon_text_image_size(){
        return 'blossom-wedding-accommodation';
    }
endif;
add_filter( 'bttk_icon_img_size', 'blossom_wedding_default_icon_text_image_size' );

if( ! function_exists( 'blossom_wedding_default_advertisement_image_size' ) ) :
    function blossom_wedding_default_advertisement_image_size(){
        return 'full';
    }
endif;
add_filter( 'bttk_ad_img_size', 'blossom_wedding_default_advertisement_image_size' );

if( ! function_exists( 'blossom_wedding_default_author_image_size' ) ) :
    function blossom_wedding_default_author_image_size(){
        return 'full';
    }
endif;
add_filter( 'author_bio_img_size', 'blossom_wedding_default_author_image_size' );