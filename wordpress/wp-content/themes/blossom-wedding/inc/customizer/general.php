<?php
/**
 * General Settings
 *
 * @package Blossom_Wedding
 */

function blossom_wedding_customize_register_general( $wp_customize ){
    
    /** General Settings */
    $wp_customize->add_panel( 
        'general_settings',
         array(
            'priority'    => 60,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'General Settings', 'blossom-wedding' ),
            'description' => __( 'Customize Header, Social, Sharing, SEO, Post/Page, Sidebar, Performance and Miscellaneous settings.', 'blossom-wedding' ),
        ) 
    );

    /** Header Settings */
    $wp_customize->add_section(
        'header_settings',
        array(
            'title'    => __( 'Header Settings', 'blossom-wedding' ),
            'priority' => 20,
            'panel'    => 'general_settings',
        )
    );

    /** Read More Text */
    $wp_customize->add_setting(
        'header_button_text',
        array(
            'default'           => __( 'RSVP', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'header_button_text',
        array(
            'type'    => 'text',
            'section' => 'header_settings',
            'label'   => __( 'Header Button Text', 'blossom-wedding' ),
        )
    );

    $wp_customize->selective_refresh->add_partial( 'header_button_text', array(
        'selector' => '.nav-wrap .rsvp-flag .rsvp-flag-inner',
        'render_callback' => 'blossom_wedding_get_header_text',
    ) );
    
    /** Read More Text */
    $wp_customize->add_setting(
        'header_text_url',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw', 
        )
    );
    
    $wp_customize->add_control(
        'header_text_url',
        array(
            'type'    => 'url',
            'section' => 'header_settings',
            'label'   => __( 'Header Button Url', 'blossom-wedding' ),
        )
    );

    /** Header Settings Ends */

    /** Social Media Settings */
    $wp_customize->add_section(
        'social_media_settings',
        array(
            'title'    => __( 'Social Media Settings', 'blossom-wedding' ),
            'priority' => 30,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_social_links', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_social_links',
            array(
                'section'     => 'social_media_settings',
                'label'       => __( 'Enable Social Links', 'blossom-wedding' ),
                'description' => __( 'Enable to show social links at header.', 'blossom-wedding' ),
            )
        )
    );
    
    $wp_customize->add_setting( 
        new Blossom_Wedding_Repeater_Setting( 
            $wp_customize, 
            'social_links', 
            array(
                'default' => '',
                'sanitize_callback' => array( 'Blossom_Wedding_Repeater_Setting', 'sanitize_repeater_setting' ),
            ) 
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Control_Repeater(
            $wp_customize,
            'social_links',
            array(
                'section' => 'social_media_settings',               
                'label'   => __( 'Social Links', 'blossom-wedding' ),
                'fields'  => array(
                    'font' => array(
                        'type'        => 'font',
                        'label'       => __( 'Font Awesome Icon', 'blossom-wedding' ),
                        'description' => __( 'Example: fab fa-facebook-f', 'blossom-wedding' ),
                    ),
                    'link' => array(
                        'type'        => 'url',
                        'label'       => __( 'Link', 'blossom-wedding' ),
                        'description' => __( 'Example: https://facebook.com', 'blossom-wedding' ),
                    )
                ),
                'row_label' => array(
                    'type' => 'field',
                    'value' => __( 'links', 'blossom-wedding' ),
                    'field' => 'link'
                ),
                'choices'   => array(
                    'limit' => 10
                )                        
            )
        )
    );
    /** Social Media Settings Ends */

    /** SEO Settings */
    $wp_customize->add_section(
        'seo_settings',
        array(
            'title'    => __( 'SEO Settings', 'blossom-wedding' ),
            'priority' => 40,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_post_update_date', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_post_update_date',
            array(
                'section'     => 'seo_settings',
                'label'       => __( 'Enable Last Update Post Date', 'blossom-wedding' ),
                'description' => __( 'Enable to show last updated post date on listing as well as in single post.', 'blossom-wedding' ),
            )
        )
    );

    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_breadcrumb', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_breadcrumb',
            array(
                'section'     => 'seo_settings',
                'label'       => __( 'Enable Breadcrumb', 'blossom-wedding' ),
                'description' => __( 'Enable to show breadcrumb in inner pages.', 'blossom-wedding' ),
            )
        )
    );

    /** Breadcrumb Home Text */
    $wp_customize->add_setting(
        'home_text',
        array(
            'default'           => __( 'Home', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field' 
        )
    );
    
    $wp_customize->add_control(
        'home_text',
        array(
            'type'    => 'text',
            'section' => 'seo_settings',
            'label'   => __( 'Breadcrumb Home Text', 'blossom-wedding' ),
            'active_callback' => 'blossom_wedding_breadcrumbs_active'
        )
    ); 
    
    /** SEO Settings Ends */

    /** Posts(Blog) & Pages Settings */
    $wp_customize->add_section(
        'post_page_settings',
        array(
            'title'    => __( 'Posts(Blog) & Pages Settings', 'blossom-wedding' ),
            'priority' => 50,
            'panel'    => 'general_settings',
        )
    );
    
    /** Prefix Archive Page */
    $wp_customize->add_setting( 
        'ed_prefix_archive', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_prefix_archive',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Prefix in Archive Page', 'blossom-wedding' ),
                'description' => __( 'Enable to hide prefix in archive page.', 'blossom-wedding' ),
            )
        )
    );
    
    /** Blog Excerpt */
    $wp_customize->add_setting( 
        'ed_excerpt', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_excerpt',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Enable Blog Excerpt', 'blossom-wedding' ),
                'description' => __( 'Enable to show excerpt or disable to show full post content.', 'blossom-wedding' ),
            )
        )
    );
    
    /** Excerpt Length */
    $wp_customize->add_setting( 
        'excerpt_length', 
        array(
            'default'           => 55,
            'sanitize_callback' => 'blossom_wedding_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Slider_Control( 
            $wp_customize,
            'excerpt_length',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Excerpt Length', 'blossom-wedding' ),
                'description' => __( 'Automatically generated excerpt length (in words).', 'blossom-wedding' ),
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 100,
                    'step'  => 5,
                )                 
            )
        )
    );
    
    /** Read More Text */
    $wp_customize->add_setting(
        'read_more_text',
        array(
            'default'           => __( 'READ THE ARTICLE', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'read_more_text',
        array(
            'type'    => 'text',
            'section' => 'post_page_settings',
            'label'   => __( 'Read More Text', 'blossom-wedding' ),
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'read_more_text', array(
        'selector' => '.entry-footer .btn-readmore',
        'render_callback' => 'blossom_wedding_get_read_more',
    ) );
    
    /** Note */
    $wp_customize->add_setting(
        'post_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Note_Control( 
            $wp_customize,
            'post_note_text',
            array(
                'section'     => 'post_page_settings',
                'description' => sprintf( __( '%s These options affect your individual posts.', 'blossom-wedding' ), '<hr/>' ),
            )
        )
    );
    
    /** Hide Author Section */
    $wp_customize->add_setting( 
        'ed_author', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_author',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Author Section', 'blossom-wedding' ),
                'description' => __( 'Enable to hide author section.', 'blossom-wedding' ),
            )
        )
    );

    if( blossom_wedding_is_btnw_activated() ){
        
        /** Enable Newsletter Section */
        $wp_customize->add_setting( 
            'ed_newsletter', 
            array(
                'default'           => true,
                'sanitize_callback' => 'blossom_wedding_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
            new Blossom_Wedding_Toggle_Control( 
                $wp_customize,
                'ed_newsletter',
                array(
                    'section'     => 'post_page_settings',
                    'label'       => __( 'Newsletter Section', 'blossom-wedding' ),
                    'description' => __( 'Enable to show Newsletter Section', 'blossom-wedding' ),
                )
            )
        );
        
        /** Newsletter Shortcode */
        $wp_customize->add_setting(
            'newsletter_shortcode',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post',
            )
        );
        
        $wp_customize->add_control(
            'newsletter_shortcode',
            array(
                'type'        => 'text',
                'section'     => 'post_page_settings',
                'label'       => __( 'Newsletter Shortcode', 'blossom-wedding' ),
                'description' => __( 'Enter the BlossomThemes Email Newsletters Shortcode. Ex. [BTEN id="356"]', 'blossom-wedding' ),
                'active_callback' => 'blossom_wedding_newsletter_ac'
            )
        ); 
    }

    /** Show Related Posts */
    $wp_customize->add_setting( 
        'ed_related', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_related',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Show Related Posts', 'blossom-wedding' ),
                'description' => __( 'Enable to show related posts in single page.', 'blossom-wedding' ),
            )
        )
    );
    
    /** Related Posts section title */
    $wp_customize->add_setting(
        'related_post_title',
        array(
            'default'           => __( 'Recommended Articles', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'related_post_title',
        array(
            'type'            => 'text',
            'section'         => 'post_page_settings',
            'label'           => __( 'Related Posts Section Title', 'blossom-wedding' ),
            'active_callback' => 'blossom_wedding_post_page_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'related_post_title', array(
        'selector' => '.additional-post .post-title',
        'render_callback' => 'blossom_wedding_get_related_title',
    ) );
    
    /** Comments */
    $wp_customize->add_setting(
        'ed_comments',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_comments',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Show Comments', 'blossom-wedding' ),
                'description' => __( 'Enable to show Comments in Single Post/Page.', 'blossom-wedding' ),
            )
        )
    );
    
    /** Hide Category */
    $wp_customize->add_setting( 
        'ed_category', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_category',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Category', 'blossom-wedding' ),
                'description' => __( 'Enable to hide category.', 'blossom-wedding' ),
            )
        )
    );
    
    /** Hide Post Author */
    $wp_customize->add_setting( 
        'ed_post_author', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_post_author',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Post Author', 'blossom-wedding' ),
                'description' => __( 'Enable to hide post author.', 'blossom-wedding' ),
            )
        )
    );
    
    /** Hide Posted Date */
    $wp_customize->add_setting( 
        'ed_post_date', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_post_date',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Posted Date', 'blossom-wedding' ),
                'description' => __( 'Enable to hide posted date.', 'blossom-wedding' ),
            )
        )
    );
    
    /** Show Featured Image */
    $wp_customize->add_setting( 
        'ed_featured_image', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_featured_image',
            array(
                'section'         => 'post_page_settings',
                'label'           => __( 'Show Featured Image', 'blossom-wedding' ),
                'description'     => __( 'Enable to show featured image in post detail (single post).', 'blossom-wedding' ),
                'active_callback' => 'blossom_wedding_post_page_ac'
            )
        )
    );
    /** Posts(Blog) & Pages Settings Ends */
    
    /** Miscellaneous Settings */
    $wp_customize->add_section(
        'misc_settings',
        array(
            'title'    => __( 'Misc Settings', 'blossom-wedding' ),
            'priority' => 85,
            'panel'    => 'general_settings',
        )
    );

    /** Shop Page Description */
    $wp_customize->add_setting( 
        'ed_shop_archive_description', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_shop_archive_description',
            array(
                'section'         => 'misc_settings',
                'label'           => __( 'Shop Page Description', 'blossom-wedding' ),
                'description'     => __( 'Enable to show Shop Page Description.', 'blossom-wedding' ),
                'active_callback' => 'blossom_wedding_is_woocommerce_activated'
            )
        )
    );
    
    /** Miscellaneous Settings End */
    
}
add_action( 'customize_register', 'blossom_wedding_customize_register_general' );