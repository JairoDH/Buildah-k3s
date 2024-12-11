<?php
/**
 * Footer Setting
 *
 * @package Blossom_Wedding
 */

function blossom_wedding_customize_register_footer( $wp_customize ) {
    
    $wp_customize->add_section(
        'footer_settings',
        array(
            'title'      => __( 'Footer Settings', 'blossom-wedding' ),
            'priority'   => 199,
            'capability' => 'edit_theme_options',
        )
    );
    
    /** Footer Copyright */
    $wp_customize->add_setting(
        'footer_copyright',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'footer_copyright',
        array(
            'label'       => __( 'Footer Copyright Text', 'blossom-wedding' ),
            'section'     => 'footer_settings',
            'type'        => 'textarea',
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'footer_copyright', array(
        'selector' => '.site-info .copyright',
        'render_callback' => 'blossom_wedding_get_footer_copyright',
    ) );

    $wp_customize->add_setting( 'footer_background_image',
        array(
            'default'           => get_template_directory_uri() . '/images/footer-bg.jpg',
            'sanitize_callback' => 'blossom_wedding_sanitize_image',
        )
    );
    
    $wp_customize->add_control( 
        new WP_Customize_Image_Control( $wp_customize, 'footer_background_image',
            array(
                'label'         => esc_html__( 'Background Image', 'blossom-wedding' ),
                'description'   => esc_html__( 'Choose background Image of your choice. Recommended size for this image is 1920px by 1080px.', 'blossom-wedding' ),
                'section'       => 'footer_settings',
                'type'          => 'image',
            )
        )
    );
        
}
add_action( 'customize_register', 'blossom_wedding_customize_register_footer' );