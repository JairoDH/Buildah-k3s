<?php
/**
 * Officiant Section
 * 
 * @package Blossom_Wedding
 */

$section_title  		 = get_theme_mod( 'officiant_section_title', __( 'Wedding Officiant', 'blossom-wedding' ) );
$officiant_section_one   = get_theme_mod( 'officiant_section_post_one' );
$officiant_section_two   = get_theme_mod( 'officiant_section_post_two' );
$officiant_posts      	 = array( $officiant_section_one, $officiant_section_two );
$officiant_posts 	     = array_diff( array_unique( $officiant_posts ), array( '' ) );

$args = array(
    'posts_per_page' => -1,
    'post__in'       => $officiant_posts,
    'orderby'        => 'post__in',
    'ignore_sticky_posts' => true,   
);

$qry = new WP_Query( $args );

if( $officiant_posts && $qry->have_posts() ) { ?>
	<section id="officiant_section" class="officiant-section">
		<div class="container">
		<?php if( $section_title ) echo '<h2 class="section-title">' . esc_html( $section_title ) . '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 82 12"><defs><style>.a{fill:none;stroke:#e39696;stroke-width:2px;}</style></defs><g transform="translate(-8.2 -9.1)"><path class="a" d="M49.2,15.1,14.929,20m0,0c-.3,0-.6.1-.8.1a5,5,0,1,1,4.925-5" transform="translate(0 0)"/><g transform="translate(49.2 10.1)"><path class="a" d="M49,15.1l34.271-4.9m0,0c.3,0,.6-.1.8-.1a5,5,0,1,1-4.925,5" transform="translate(-49 -10.1)"/></g></g></svg></h2>'; ?>

			<div class="man-matron-wrap">
				<?php while( $qry->have_posts() ){ $qry->the_post(); ?>
					<div class="<?php echo ( $qry->current_post == 0 ) ? 'man' : 'matron'; ?>-block">
						<figure class="officiant-img">
							<?php 
                                if( has_post_thumbnail() ){
                                    the_post_thumbnail( 'blossom-wedding-officiant' );
                                }else{
                                	blossom_wedding_get_fallback_svg( 'blossom-wedding-officiant' );
                                }
                            ?>
						</figure>
						<div class="officiant-content-wrap">
							<?php the_title( '<h4 class="officiant-title">', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 82 12"><defs><style>.a{fill:none;stroke:#e39696;stroke-width:2px;}</style></defs><g transform="translate(-8.2 -9.1)"><path class="a" d="M49.2,15.1,14.929,20m0,0c-.3,0-.6.1-.8.1a5,5,0,1,1,4.925-5" transform="translate(0 0)"/><g transform="translate(49.2 10.1)"><path class="a" d="M49,15.1l34.271-4.9m0,0c.3,0,.6-.1.8-.1a5,5,0,1,1-4.925,5" transform="translate(-49 -10.1)"/></g></g></svg></h4>' ); ?>
							<div class="officiant-content"><?php the_excerpt(); ?></div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</section> <!-- .officiant-section -->
<?php }
wp_reset_postdata();