<?php
/**
 * Story Section
 * 
 * @package Blossom_Wedding
 */

$section_title    = get_theme_mod( 'story_section_title', __( 'Our Love Story', 'blossom-wedding' ) );
$subtitle = get_theme_mod( 'story_section_content', __( 'It\'s not too often that you find someone who can finish your sentences, let alone correct your improper use of a Dumb and Dumber quote. Whether it be a lazy Sunday on the couch or a run outside in the Summer, we are always happy just being together. What started off as a friendship soon grew into something much more than coincidence.', 'blossom-wedding' ) );

$end_title    = get_theme_mod( 'story_section_end_title', __( 'Adventure Begins', 'blossom-wedding' ) );
$end_subtitle = get_theme_mod( 'story_section_end_content', __( 'AND SO THE', 'blossom-wedding' ) );

$story_section_one   = get_theme_mod( 'story_section_post_one' );
$story_section_two   = get_theme_mod( 'story_section_post_two' );
$story_section_three = get_theme_mod( 'story_section_post_three' );
$story_section_four  = get_theme_mod( 'story_section_post_four' );
$story_section_posts = array( $story_section_one, $story_section_two, $story_section_three, $story_section_four );
$story_section_posts = array_diff( array_unique( $story_section_posts ), array( '' ) );

$args = array(
    'posts_per_page' => -1,
    'post__in'       => $story_section_posts,
    'orderby'        => 'post__in',   
    'ignore_sticky_posts' => true,
);

$qry = new WP_Query( $args );

if( $story_section_posts && $qry->have_posts() ) { ?>
	<section id="story_section" class="story-section">
		<div class="container">
			<?php if( $section_title ) echo '<h2 class="section-title">' . esc_html( $section_title ) . '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 82 12"><defs><style>.a{fill:none;stroke:#e39696;stroke-width:2px;}</style></defs><g transform="translate(-8.2 -9.1)"><path class="a" d="M49.2,15.1,14.929,20m0,0c-.3,0-.6.1-.8.1a5,5,0,1,1,4.925-5" transform="translate(0 0)"/><g transform="translate(49.2 10.1)"><path class="a" d="M49,15.1l34.271-4.9m0,0c.3,0,.6-.1.8-.1a5,5,0,1,1-4.925,5" transform="translate(-49 -10.1)"/></g></g></svg>
			</h2>';
			if( $subtitle ) echo '<div class="section-desc">' . esc_html( $subtitle ) . '</div>'; ?>
			<div class="section-grid">
				<div class="section-grid-inner">
					<?php while( $qry->have_posts() ){ $qry->the_post(); ?>
						<article class="post">
							<figure class="post-thumbnail">
							<?php 
                                if( has_post_thumbnail() ){
                                    the_post_thumbnail( 'blossom-wedding-story', array( 'itemprop' => 'image' ) );
                                }else{
                                	blossom_wedding_get_fallback_svg( 'blossom-wedding-story' );
                                }
                            ?>
							</figure>
							<div class="content-wrap">										
								<header class="entry-header">
								<?php the_title( '<h3 class="entry-title">', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 82 12"><defs><style>.a{fill:none;stroke:#e39696;stroke-width:2px;}</style></defs><g transform="translate(-8.2 -9.1)"><path class="a" d="M49.2,15.1,14.929,20m0,0c-.3,0-.6.1-.8.1a5,5,0,1,1,4.925-5" transform="translate(0 0)"/><g transform="translate(49.2 10.1)"><path class="a" d="M49,15.1l34.271-4.9m0,0c.3,0,.6-.1.8-.1a5,5,0,1,1-4.925,5" transform="translate(-49 -10.1)"/></g></g></svg></h3>' ); ?>
								</header>
								<div class="entry-content"><?php the_excerpt(); ?></div>
							</div>
						</article>
					<?php } ?>
				</div>
			</div>

			<?php if( $end_title || $end_subtitle ) : ?>
				<div class="story-end">
					<?php if( $end_subtitle ) echo '<span class="story-end-subtitle">' . esc_html( $end_subtitle ) . '
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 82 12"><defs><style>.a{fill:none;stroke:#e39696;stroke-width:2px;}</style></defs><g transform="translate(-8.2 -9.1)"><path class="a" d="M49.2,15.1,14.929,20m0,0c-.3,0-.6.1-.8.1a5,5,0,1,1,4.925-5" transform="translate(0 0)"/><g transform="translate(49.2 10.1)"><path class="a" d="M49,15.1l34.271-4.9m0,0c.3,0,.6-.1.8-.1a5,5,0,1,1-4.925,5" transform="translate(-49 -10.1)"/></g></g></svg></span>'; ?>
					<?php if( $end_title ) echo '<h5 class="story-end-title">' . esc_html( $end_title ) . '</h5>'; ?>
				</div>
			<?php endif; ?>
		</div>
	</section> <!-- .story-section -->
<?php }
wp_reset_postdata();