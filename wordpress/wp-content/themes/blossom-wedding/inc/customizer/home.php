<?php
/**
 * Front Page Settings
 *
 * @package Blossom_Wedding
 */

function blossom_wedding_customize_register_frontpage( $wp_customize ) {
	
    /** Front Page Settings */
    $wp_customize->add_panel( 
        'frontpage_settings',
         array(
            'priority'    => 40,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Front Page Settings', 'blossom-wedding' ),
            'description' => __( 'Static Home Page settings.', 'blossom-wedding' ),
        ) 
    );    

    /** Slider Settings */

    $wp_customize->get_section( 'header_image' )->panel                    = 'frontpage_settings';
    $wp_customize->get_section( 'header_image' )->title                    = __( 'Banner Section', 'blossom-wedding' );
    $wp_customize->get_section( 'header_image' )->priority                 = 10;
    $wp_customize->get_control( 'header_image' )->active_callback          = 'blossom_wedding_banner_ac';
    $wp_customize->get_control( 'header_video' )->active_callback          = 'blossom_wedding_banner_ac';
    $wp_customize->get_control( 'external_header_video' )->active_callback = 'blossom_wedding_banner_ac';
    $wp_customize->get_section( 'header_image' )->description              = '';                                               
    $wp_customize->get_setting( 'header_image' )->transport                = 'refresh';
    $wp_customize->get_setting( 'header_video' )->transport                = 'refresh';
    $wp_customize->get_setting( 'external_header_video' )->transport       = 'refresh';
    
    /** Banner Options */
    $wp_customize->add_setting(
        'ed_banner_section',
        array(
            'default'           => 'slider_banner',
            'sanitize_callback' => 'blossom_wedding_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Wedding_Select_Control(
            $wp_customize,
            'ed_banner_section',
            array(
                'label'       => __( 'Banner Options', 'blossom-wedding' ),
                'description' => __( 'Choose banner as static image/video or as a slider.', 'blossom-wedding' ),
                'section'     => 'header_image',
                'choices'     => array(
                    'no_banner'        => __( 'Disable Banner Section', 'blossom-wedding' ),
                    'static_banner'    => __( 'Static/Video Banner', 'blossom-wedding' ),
                    'slider_banner'    => __( 'Banner as Slider', 'blossom-wedding' ),
                ),
                'priority' => 5 
            )            
        )
    );
    
    /** Title */
    $wp_customize->add_setting(
        'banner_title',
        array(
            'default'           => __( 'Brittany & Steven', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_title',
        array(
            'label'           => __( 'Title', 'blossom-wedding' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'blossom_wedding_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_title', array(
        'selector' => '.banner .banner-caption .banner-caption-inner h2.banner-title',
        'render_callback' => 'blossom_wedding_get_banner_title',
    ) );
    
    /** Sub Title */
    $wp_customize->add_setting(
        'banner_subtitle',
        array(
            'default'           => __( 'Save the Day', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_subtitle',
        array(
            'label'           => __( 'Sub Title', 'blossom-wedding' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'blossom_wedding_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_subtitle', array(
        'selector' => '.banner .banner-caption .banner-caption-inner span.sub-title',
        'render_callback' => 'blossom_wedding_get_banner_sub_title',
    ) );

    /** Sub Title */
    $wp_customize->add_setting(
        'banner_description',
        array(
            'default'           => __( 'JULY 23, 2018 - 11:00AM Red Barn Farm of Northfield10063 110th Street East, Northfield Minnesota', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_description',
        array(
            'label'           => __( 'Banner Description', 'blossom-wedding' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'blossom_wedding_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_description', array(
        'selector' => '.banner .banner-caption .banner-caption-inner .banner-desc',
        'render_callback' => 'blossom_wedding_get_banner_desciption',
    ) );

    /** Slider Content Style */
    $wp_customize->add_setting(
        'slider_type',
        array(
            'default'           => 'latest_posts',
            'sanitize_callback' => 'blossom_wedding_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Wedding_Select_Control(
            $wp_customize,
            'slider_type',
            array(
                'label'   => __( 'Slider Content Style', 'blossom-wedding' ),
                'section' => 'header_image',
                'choices' => array(
                    'latest_posts' => __( 'Latest Posts', 'blossom-wedding' ),
                    'cat'          => __( 'Category', 'blossom-wedding' ),
                ),
                'active_callback' => 'blossom_wedding_banner_ac'    
            )
        )
    );
    
    /** Slider Category */
    $wp_customize->add_setting(
        'slider_cat',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_wedding_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Wedding_Select_Control(
            $wp_customize,
            'slider_cat',
            array(
                'label'           => __( 'Slider Category', 'blossom-wedding' ),
                'section'         => 'header_image',
                'choices'         => blossom_wedding_get_categories(),
                'active_callback' => 'blossom_wedding_banner_ac'    
            )
        )
    );
    
    /** No. of slides */
    $wp_customize->add_setting(
        'no_of_slides',
        array(
            'default'           => 3,
            'sanitize_callback' => 'blossom_wedding_sanitize_number_absint'
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Slider_Control( 
            $wp_customize,
            'no_of_slides',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Number of Slides', 'blossom-wedding' ),
                'description' => __( 'Choose the number of slides you want to display', 'blossom-wedding' ),
                'choices'     => array(
                    'min'   => 1,
                    'max'   => 20,
                    'step'  => 1,
                ),
                'active_callback' => 'blossom_wedding_banner_ac'                 
            )
        )
    );
    
    /** HR */
    $wp_customize->add_setting(
        'hr',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Note_Control( 
            $wp_customize,
            'hr',
            array(
                'section'     => 'header_image',
                'description' => '<hr/>',
                'active_callback' => 'blossom_wedding_banner_ac'
            )
        )
    ); 
    
    /** Slider Auto */
    $wp_customize->add_setting(
        'slider_auto',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'slider_auto',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Auto', 'blossom-wedding' ),
                'description' => __( 'Enable slider auto transition.', 'blossom-wedding' ),
                'active_callback' => 'blossom_wedding_banner_ac'
            )
        )
    );

    /** Slider Caption */
    $wp_customize->add_setting(
        'slider_caption',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'slider_caption',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Caption', 'blossom-wedding' ),
                'description' => __( 'Enable slider caption.', 'blossom-wedding' ),
                'active_callback' => 'blossom_wedding_banner_ac'
            )
        )
    );

    /** Slider Settings Ends */
    
    /** Story Section */

    $wp_customize->add_section(
        'story_section',
        array(
            'title'    => __( 'Story Section', 'blossom-wedding' ),
            'priority' => 30,
            'panel'    => 'frontpage_settings',
        )
    );

    $wp_customize->add_setting(
        'ed_story_section',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_story_section',
            array(
                'section'     => 'story_section',
                'label'       => __( 'Enable Story Section', 'blossom-wedding' ),
            )
        )
    );

    /** Title */
    $wp_customize->add_setting(
        'story_section_title',
        array(
            'default'           => __( 'Our Love Story', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'story_section_title',
        array(
            'section' => 'story_section',
            'label'   => __( 'Section Title', 'blossom-wedding' ),
            'type'    => 'text',
            'active_callback' => 'blossom_wedding_story_section_active'
        )
    );

    $wp_customize->selective_refresh->add_partial( 'story_section_title', array(
        'selector' => '.story-section .container .section-title',
        'render_callback' => 'blossom_wedding_get_story_section_title',
    ) );

    $wp_customize->add_setting(
        'story_section_content',
        array(
            'default'           => __( 'It\'s not too often that you find someone who can finish your sentences, let alone correct your improper use of a Dumb and Dumber quote. Whether it be a lazy Sunday on the couch or a run outside in the Summer, we are always happy just being together. What started off as a friendship soon grew into something much more than coincidence.', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'story_section_content',
        array(
            'section' => 'story_section',
            'label'   => __( 'Section Description', 'blossom-wedding' ),
            'type'    => 'text',
            'active_callback' => 'blossom_wedding_story_section_active'
        )
    ); 

    $wp_customize->selective_refresh->add_partial( 'story_section_content', array(
        'selector' => '.story-section .container .section-desc',
        'render_callback' => 'blossom_wedding_get_story_section_content',
    ) );

    /** End Title */
    $wp_customize->add_setting(
        'story_section_end_title',
        array(
            'default'           => __( 'Adventure Begins', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'story_section_end_title',
        array(
            'section' => 'story_section',
            'label'   => __( 'Section End Title', 'blossom-wedding' ),
            'type'    => 'text',
            'active_callback' => 'blossom_wedding_story_section_active'
        )
    );

    $wp_customize->selective_refresh->add_partial( 'story_section_end_title', array(
        'selector' => '.story-section .container .story-end .story-end-title',
        'render_callback' => 'blossom_wedding_get_story_section_end_title',
    ) );

    $wp_customize->add_setting(
        'story_section_end_content',
        array(
            'default'           => __( 'AND SO THE', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'story_section_end_content',
        array(
            'section' => 'story_section',
            'label'   => __( 'Section Description', 'blossom-wedding' ),
            'type'    => 'text',
            'active_callback' => 'blossom_wedding_story_section_active'
        )
    ); 

    $wp_customize->selective_refresh->add_partial( 'story_section_end_content', array(
        'selector' => '.story-section .container .story-end .story-end-subtitle',
        'render_callback' => 'blossom_wedding_get_story_section_end_content',
    ) );
    
    $wp_customize->add_setting(
        'story_section_post_one',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_wedding_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Wedding_Select_Control(
            $wp_customize,
            'story_section_post_one',
            array(
                'label'   => __( 'Select Post One', 'blossom-wedding' ),
                'section' => 'story_section',
                'active_callback' => 'blossom_wedding_story_section_active',
                'choices' => blossom_wedding_get_posts(),
            )
        )
    );

    $wp_customize->add_setting(
        'story_section_post_two',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_wedding_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Wedding_Select_Control(
            $wp_customize,
            'story_section_post_two',
            array(
                'label'   => __( 'Select Post Two', 'blossom-wedding' ),
                'section' => 'story_section',
                'active_callback' => 'blossom_wedding_story_section_active',
                'choices' => blossom_wedding_get_posts(),
            )
        )
    );

    $wp_customize->add_setting(
        'story_section_post_three',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_wedding_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Wedding_Select_Control(
            $wp_customize,
            'story_section_post_three',
            array(
                'label'   => __( 'Select Post Three', 'blossom-wedding' ),
                'section' => 'story_section',
                'active_callback' => 'blossom_wedding_story_section_active',
                'choices' => blossom_wedding_get_posts(),
            )
        )
    );

    $wp_customize->add_setting(
        'story_section_post_four',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_wedding_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Wedding_Select_Control(
            $wp_customize,
            'story_section_post_four',
            array(
                'label'   => __( 'Select Post Four', 'blossom-wedding' ),
                'section' => 'story_section',
                'active_callback' => 'blossom_wedding_story_section_active',
                'choices' => blossom_wedding_get_posts(),
            )
        )
    );
    
    /** Story Section Ends */

    /** Officiant Section */
    $wp_customize->add_section(
        'officiant_section',
        array(
            'title'    => __( 'Officiant Section', 'blossom-wedding' ),
            'priority' => 80,
            'panel'    => 'frontpage_settings',
        )
    );

    $wp_customize->add_setting(
        'ed_officiant_section',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_officiant_section',
            array(
                'section'     => 'officiant_section',
                'label'       => __( 'Enable Officiant Section', 'blossom-wedding' ),
            )
        )
    );

    /** Title */
    $wp_customize->add_setting(
        'officiant_section_title',
        array(
            'default'           => __( 'Wedding Officiant', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'officiant_section_title',
        array(
            'section' => 'officiant_section',
            'label'   => __( 'Section Title', 'blossom-wedding' ),
            'type'    => 'text',
            'active_callback' => 'blossom_wedding_officiant_section_active'
        )
    );

    $wp_customize->selective_refresh->add_partial( 'officiant_section_title', array(
        'selector' => '.officiant-section .container .section-title',
        'render_callback' => 'blossom_wedding_get_officiant_section_title',
    ) );

    $wp_customize->add_setting(
        'officiant_section_post_one',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_wedding_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Wedding_Select_Control(
            $wp_customize,
            'officiant_section_post_one',
            array(
                'label'   => __( 'Select Post One', 'blossom-wedding' ),
                'section' => 'officiant_section',
                'active_callback' => 'blossom_wedding_officiant_section_active',
                'choices' => blossom_wedding_get_posts(),
            )
        )
    );

    $wp_customize->add_setting(
        'officiant_section_post_two',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_wedding_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Wedding_Select_Control(
            $wp_customize,
            'officiant_section_post_two',
            array(
                'label'   => __( 'Select Post Two', 'blossom-wedding' ),
                'section' => 'officiant_section',
                'active_callback' => 'blossom_wedding_officiant_section_active',
                'choices' => blossom_wedding_get_posts(),
            )
        )
    );

    /** Officiant Section Ends */

    /** Invitation Section */
    $wp_customize->add_section(
        'invitation',
        array(
            'title'    => __( 'Invitation Section', 'blossom-wedding' ),
            'priority' => 110,
            'panel'    => 'frontpage_settings',
        )
    );

    $wp_customize->add_setting( 'invitation_background',
        array(
            'default'           => esc_url( get_template_directory_uri() . '/images/form-section-bg.jpg' ),
            'sanitize_callback' => 'blossom_wedding_sanitize_image',
        )
    );
    
    $wp_customize->add_control( 
        new WP_Customize_Image_Control( $wp_customize, 'invitation_background',
            array(
                'label'         => esc_html__( 'Background Image', 'blossom-wedding' ),
                'description'   => esc_html__( 'Choose background Image of your choice. Recommended size for this image is 1920px by 1080px.', 'blossom-wedding' ),
                'section'       => 'invitation',
                'type'          => 'image',
                'priority'      => -1,
            )
        )
    );

    $wp_customize->add_setting(
        'invitation_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Note_Control( 
            $wp_customize,
            'invitation_note_text',
            array(
                'section'     => 'invitation',
                'description' => __( '<hr/>Add "Text" widget for invitation section.', 'blossom-wedding' ),
                'priority'      => -1,
            )
        )
    );

    $invitation_section = $wp_customize->get_section( 'sidebar-widgets-invitation' );
    if ( ! empty( $invitation_section ) ) {

        $invitation_section->panel     = 'frontpage_settings';
        $invitation_section->priority  = 110;
        $wp_customize->get_control( 'invitation_note_text' )->section  = 'sidebar-widgets-invitation';
        $wp_customize->get_control( 'invitation_background' )->section  = 'sidebar-widgets-invitation';
    }

    /** Invitation Section Ends*/  

    /** Blog Section */
    $wp_customize->add_section(
        'blog_section',
        array(
            'title'    => __( 'Blog Section', 'blossom-wedding' ),
            'priority' => 150,
            'panel'    => 'frontpage_settings',
        )
    );

    $wp_customize->add_setting(
        'ed_blog_section',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_wedding_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Wedding_Toggle_Control( 
            $wp_customize,
            'ed_blog_section',
            array(
                'section'     => 'blog_section',
                'label'       => __( 'Enable Blog Section', 'blossom-wedding' ),
            )
        )
    );

    /** Blog title */
    $wp_customize->add_setting(
        'blog_section_title',
        array(
            'default'           => __( 'From the Blog', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_section_title',
        array(
            'section' => 'blog_section',
            'label'   => __( 'Blog Title', 'blossom-wedding' ),
            'type'    => 'text',
            'active_callback' => 'blossom_wedding_blog_section_active'
        )
    );

    $wp_customize->selective_refresh->add_partial( 'blog_section_title', array(
        'selector' => '.blog-section .container .section-title',
        'render_callback' => 'blossom_wedding_get_blog_section_title',
    ) );
    
    /** Readmore Label */
    $wp_customize->add_setting(
        'blog_readmore',
        array(
            'default'           => __( 'READ THE ARTICLE', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_readmore',
        array(
            'label'           => __( 'Read More Label', 'blossom-wedding' ),
            'section'         => 'blog_section',
            'type'            => 'text',
            'active_callback' => 'blossom_wedding_blog_section_active'
        )
    );
    
    /** View All Label */
    $wp_customize->add_setting(
        'blog_view_all',
        array(
            'default'           => __( 'VIEW MORE POSTS', 'blossom-wedding' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_view_all',
        array(
            'label'           => __( 'View All Label', 'blossom-wedding' ),
            'section'         => 'blog_section',
            'type'            => 'text',
            'active_callback' => 'blossom_wedding_blog_view_all_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'blog_view_all', array(
        'selector' => '.blog-section .container .button-wrap a.btn-readmore',
        'render_callback' => 'blossom_wedding_get_blog_view_all',
    ) ); 

    /** Blog Section Ends */
}
add_action( 'customize_register', 'blossom_wedding_customize_register_frontpage' );