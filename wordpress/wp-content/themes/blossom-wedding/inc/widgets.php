<?php
/**
 * Blossom Wedding Widget Areas
 * 
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @package Blossom_Wedding
 */

function blossom_wedding_widgets_init(){    
    $sidebars = array(
        'sidebar'   => array(
            'name'        => __( 'Sidebar', 'blossom-wedding' ),
            'id'          => 'sidebar', 
            'description' => __( 'Default Sidebar', 'blossom-wedding' ),
        ),
        'about' => array(
            'name'        => __( 'About Section', 'blossom-wedding' ),
            'id'          => 'about', 
            'description' => __( 'Add "Text", "Image" & "Text" widgets for about section. Please add image size of 512px by 512px for image widget.', 'blossom-wedding' ),
        ),
        'quote' => array(
            'name'        => __( 'Quote Section', 'blossom-wedding' ),
            'id'          => 'quote', 
            'description' => __( 'Add "Image" widget for Quote section.', 'blossom-wedding' ),
        ),
        'gallery' => array(
            'name'        => __( 'Gallery Section', 'blossom-wedding' ),
            'id'          => 'gallery', 
            'description' => __( 'Add "Custom HTML" widget for gallery section.', 'blossom-wedding' ),
        ),
        'invitation' => array(
            'name'        => __( 'Invitation Section', 'blossom-wedding' ),
            'id'          => 'invitation', 
            'description' => __( 'Add "Text" widget for invitation section.', 'blossom-wedding' ),
        ),
        'footer-one'=> array(
            'name'        => __( 'Footer One', 'blossom-wedding' ),
            'id'          => 'footer-one', 
            'description' => __( 'Add footer one widgets here.', 'blossom-wedding' ),
        ),
        'footer-two'=> array(
            'name'        => __( 'Footer Two', 'blossom-wedding' ),
            'id'          => 'footer-two', 
            'description' => __( 'Add footer two widgets here.', 'blossom-wedding' ),
        ),
        'footer-three'=> array(
            'name'        => __( 'Footer Three', 'blossom-wedding' ),
            'id'          => 'footer-three', 
            'description' => __( 'Add footer three widgets here.', 'blossom-wedding' ),
        )
    );
    
    foreach( $sidebars as $sidebar ){
        register_sidebar( array(
    		'name'          => esc_html( $sidebar['name'] ),
    		'id'            => esc_attr( $sidebar['id'] ),
    		'description'   => esc_html( $sidebar['description'] ),
    		'before_widget' => '<section id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</section>',
    		'before_title'  => '<h2 class="widget-title" itemprop="name">',
    		'after_title'   => '</h2>',
    	) );
    }

}
add_action( 'widgets_init', 'blossom_wedding_widgets_init' );