<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blossom_Wedding
 */
    /**
     * Doctype Hook
     * 
     * @hooked blossom_wedding_doctype
    */
    do_action( 'blossom_wedding_doctype' );
?>
<head itemscope itemtype="http://schema.org/WebSite">
	<?php 
    /**
     * Before wp_head
     * 
     * @hooked blossom_wedding_head
    */
    do_action( 'blossom_wedding_before_wp_head' );
    
    wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<?php

    wp_body_open();
    
    /**
     * Before Header
     * 
     * @hooked blossom_wedding_page_start - 20 
    */
    do_action( 'blossom_wedding_before_header' );
    
    /**
     * Header
     * 
     * @hooked blossom_wedding_header - 20     
    */
    do_action( 'blossom_wedding_header' );
    
    /**
     * Before Content
     * 
    */
    do_action( 'blossom_wedding_after_header' );
    
    /**
     * Content
     * 
     * @hooked blossom_wedding_content_start
    */
    do_action( 'blossom_wedding_content' );