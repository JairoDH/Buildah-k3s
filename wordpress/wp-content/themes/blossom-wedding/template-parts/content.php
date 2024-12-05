<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blossom_Wedding
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); if( ! is_single() ) echo ' itemscope itemtype="https://schema.org/Blog"'; ?>>
	<?php 
        if( is_single() ) echo '<div class="title-wrap">';
        /**
         
         * @hooked blossom_wedding_post_thumbnail - 20
        */
        do_action( 'blossom_wedding_before_post_entry_content' );

        if( is_single() ) {
            blossom_wedding_entry_header();
            echo '</div>';
        }else{
            echo '<div class="content-wrap">';
            blossom_wedding_entry_header();
        }
        /** 
         * @hooked blossom_wedding_entry_content - 15
         * @hooked blossom_wedding_entry_footer  - 20
        */
        do_action( 'blossom_wedding_post_entry_content' );

        if( ! is_single() ) echo '</div>';
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
