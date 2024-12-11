<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blossom_Wedding
 */
    
    /**
     * After Content
     * 
     * @hooked blossom_wedding_content_end - 20
    */
    do_action( 'blossom_wedding_before_footer' );
    
    /**
     * Footer
     * 
     * @hooked blossom_wedding_footer_start  - 20
     * @hooked blossom_wedding_footer_top    - 30
     * @hooked blossom_wedding_footer_bottom - 40
     * @hooked blossom_wedding_back_to_top   - 45
     * @hooked blossom_wedding_footer_end    - 50
    */
    do_action( 'blossom_wedding_footer' );
    
    /**
     * After Footer
     * 
     * @hooked blossom_wedding_page_end    - 20
    */
    do_action( 'blossom_wedding_after_footer' );

    wp_footer(); ?>

</body>
</html>
