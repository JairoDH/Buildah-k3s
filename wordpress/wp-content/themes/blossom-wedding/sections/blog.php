<?php
/**
 * Blog Section
 * 
 * @package Blossom_Wedding
 */

$section_title    = get_theme_mod( 'blog_section_title', __( 'From the Blog', 'blossom-wedding' ) );
$readmore = get_theme_mod( 'blog_readmore', __( 'READ THE ARTICLE', 'blossom-wedding' ) );
$blog     = get_option( 'page_for_posts' );
$label    = get_theme_mod( 'blog_view_all', __( 'VIEW MORE POSTS', 'blossom-wedding' ) );

$args = array(
    'post_type'           => 'post',
    'posts_per_page'      => 3,
    'ignore_sticky_posts' => true
);

$qry = new WP_Query( $args );

if( $section_title || $qry->have_posts() ){ ?>

<section id="blog_section" class="blog-section">
	<div class="container">
        <?php if( $section_title ) echo '<h2 class="section-title">' . esc_html( $section_title ) . '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 82 12"><defs><style>.a{fill:none;stroke:#e39696;stroke-width:2px;}</style></defs><g transform="translate(-8.2 -9.1)"><path class="a" d="M49.2,15.1,14.929,20m0,0c-.3,0-.6.1-.8.1a5,5,0,1,1,4.925-5" transform="translate(0 0)"/><g transform="translate(49.2 10.1)"><path class="a" d="M49,15.1l34.271-4.9m0,0c.3,0,.6-.1.8-.1a5,5,0,1,1-4.925,5" transform="translate(-49 -10.1)"/></g></g></svg></h2>'; ?>
        
        <?php if( $qry->have_posts() ){ ?>
            <div class="section-grid">
    			<?php 
                while( $qry->have_posts() ){
                    $qry->the_post(); ?>
                    <article class="post">
        				<figure class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                            <?php 
                                if( has_post_thumbnail() ){
                                    the_post_thumbnail( 'blossom-wedding-blog', array( 'itemprop' => 'image' ) );
                                }else{ 
                                    blossom_wedding_get_fallback_svg( 'blossom-wedding-blog' );
                                }                            
                            ?>                        
                            </a>
                        </figure>
    					<header class="entry-header">
    						<div class="entry-meta"><span class="posted-on"><time><a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_date() ); ?></a></time></span></div>
    						<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <a href="<?php the_permalink(); ?>" class="btn-readmore"><?php echo esc_html( $readmore ); ?></a>
    					</header>
        			</article>			
        			<?php 
                }
                ?>
    		</div>
    		
            <?php if( $blog && $label ){ ?>
                <div class="button-wrap">
        			<a href="<?php the_permalink( $blog ); ?>" class="btn-readmore"><?php echo esc_html( $label ); ?></a>
        		</div>
            <?php } ?>
        
        <?php } 
        wp_reset_postdata(); ?>
	</div>
</section>
<?php 
}