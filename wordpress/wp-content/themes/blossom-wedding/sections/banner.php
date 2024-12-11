<?php
/**
 * Banner Section
 * 
 * @package Blossom_Wedding
 */

$ed_banner        = get_theme_mod( 'ed_banner_section', 'slider_banner' );
$slider_type      = get_theme_mod( 'slider_type', 'latest_posts' ); 
$slider_cat       = get_theme_mod( 'slider_cat' );
$posts_per_page   = get_theme_mod( 'no_of_slides', 3 );
$ed_caption       = get_theme_mod( 'slider_caption', true );
$banner_title     = get_theme_mod( 'banner_title', __( 'Brittany &amp; Steven', 'blossom-wedding' ) );
$banner_subtitle  = get_theme_mod( 'banner_subtitle', __( 'Save The Day', 'blossom-wedding' ) );
$banner_description   = get_theme_mod( 'banner_description', __( 'JULY 23, 2018 - 11:00AM Red Barn Farm of Northfield10063 110th Street East, Northfield Minnesota', 'blossom-wedding' ) );
        
if( $ed_banner == 'static_banner' && has_custom_header() ){ ?>
    <div id="banner_section" class="site-banner banner<?php if( has_header_video() ) echo esc_attr( ' video-banner' ); ?>">
        <div class="banner-wrap">
            <div class="banner-item">
                <?php 
                    the_custom_header_markup(); 
                    if( $banner_title || $banner_subtitle || $banner_description ) {
                        echo '<div class="banner-caption"><div class="container">';
                            echo '<div class="banner-caption-inner">';
                            if( $banner_subtitle ) echo '<span class="sub-title">' . esc_html( $banner_subtitle ) . '</span>';
                            if( $banner_title ) echo '<h2 class="banner-title">' . esc_html( $banner_title ) . '<svg xmlns="http://www.w3.org/2000/svg" viewBox="-2 0 86 12"><defs><style>.a{fill:none;stroke:#e39696;stroke-width:2px;}</style></defs><g transform="translate(-8.2 -9.1)"><path class="a" d="M49.2,15.1,14.929,20m0,0c-.3,0-.6.1-.8.1a5,5,0,1,1,4.925-5" transform="translate(0 0)"/><g transform="translate(49.2 10.1)"><path class="a" d="M49,15.1l34.271-4.9m0,0c.3,0,.6-.1.8-.1a5,5,0,1,1-4.925,5" transform="translate(-49 -10.1)"/></g></g></svg></h2>';
                            if( $banner_description ) echo '<div class="banner-desc">' . esc_html( $banner_description ) . '</div>';
                            echo '</div>';
                        echo '</div></div>';
                    }
                ?>
            </div>
        </div>
        <button class="scroll-down"></button>
    </div>
<?php
}elseif( $ed_banner == 'slider_banner' ){
    if( $slider_type == 'latest_posts' || $slider_type == 'cat' ){
        $image_size = 'blossom-wedding-slider';
        $args = array(            
            'ignore_sticky_posts' => true
        );
        
        if( $slider_type === 'cat' && $slider_cat ){
            $args['post_type']      = 'post';
            $args['cat']            = $slider_cat; 
            $args['posts_per_page'] = -1;  
        }else{
            $args['post_type']      = 'post';
            $args['posts_per_page'] = $posts_per_page;
        }
            
        $qry = new WP_Query( $args );
        
        if( $qry->have_posts() ){ ?>
            <div id="banner_section" class="site-banner banner">
                <div class="banner-wrap owl-carousel">            
                    <?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                    <div class="banner-item">
                        <?php 
                        if( has_post_thumbnail() ){
                            the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
                        }else{ 
                            blossom_wedding_get_fallback_svg( $image_size );
                        }
                        
                        if( $ed_caption ){ ?>                        
                            <div class="banner-caption">
                                <div class="container">
                                    <div class="banner-caption-inner">
                                        <?php
                                            the_title( '<h2 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                                            blossom_wedding_posted_on();                              
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php } ?>                        
                </div>
                <button class="scroll-down"></button>                
            </div>
        <?php
        }
        wp_reset_postdata();
    
    }
}