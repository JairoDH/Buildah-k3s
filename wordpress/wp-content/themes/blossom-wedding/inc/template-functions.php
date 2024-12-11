<?php
/**
 * Blossom Wedding Template Functions which enhance the theme by hooking into WordPress
 *
 * @package Blossom_Wedding
 */

if( ! function_exists( 'blossom_wedding_doctype' ) ) :
/**
 * Doctype Declaration
*/
function blossom_wedding_doctype(){ ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <?php
}
endif;
add_action( 'blossom_wedding_doctype', 'blossom_wedding_doctype' );

if( ! function_exists( 'blossom_wedding_head' ) ) :
/**
 * Before wp_head 
*/
function blossom_wedding_head(){ ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php
}
endif;
add_action( 'blossom_wedding_before_wp_head', 'blossom_wedding_head' );

if( ! function_exists( 'blossom_wedding_page_start' ) ) :
/**
 * Page Start
*/
function blossom_wedding_page_start(){ ?>
    <div id="page" class="site">
    <a class="skip-link" href="#content"><?php esc_html_e( 'Skip to Content', 'blossom-wedding' ); ?></a>
    <?php
}
endif;
add_action( 'blossom_wedding_before_header', 'blossom_wedding_page_start', 20 );

if( ! function_exists( 'blossom_wedding_header' ) ) :
/**
 * Header Start
*/
function blossom_wedding_header(){ ?>

    <header id="masthead" class="site-header header-one" itemscope itemtype="http://schema.org/WPHeader">
        <div class="container">
            <?php blossom_wedding_site_branding(); ?>
            <div class="nav-wrap">
                <div class="toggle-btn-wrap">
                    <button class="toggle-btn" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle">
                        <span class="toggle-bar"></span>
                        <span class="toggle-bar"></span>
                        <span class="toggle-bar"></span>
                    </button>
                </div>
                <?php blossom_wedding_primary_nagivation(); ?>
                <?php blossom_wedding_rsvp_flag(); ?>
            </div> <!-- .nav-wrap -->
        </div>
    </header>
<?php }
endif;
add_action( 'blossom_wedding_header', 'blossom_wedding_header', 20 );

if( ! function_exists( 'blossom_wedding_content_start' ) ) :
/**
 * Content Start
 * 
*/
function blossom_wedding_content_start(){       
    $home_sections = blossom_wedding_get_home_sections();
    $add_class     = ( is_author() ) ? 'author-block' : 'page-header';
    if( ! ( is_front_page() && ! is_home() && $home_sections ) ){ 
        blossom_wedding_breadcrumb();
        ?>
        <div id="content" class="site-content">
            <div class="container">
                <div id="primary" class="content-area">
                    <?php if( ! is_404() && ! is_singular() ) : ?>
                        <div class="<?php echo esc_attr( $add_class ); ?>">
                			<?php
                                
                                if( is_archive() ) :
                                    global $wp_query;
                                    if( is_author() ){
                                        $author_title = get_the_author_meta( 'display_name' ); ?>
                                        <figure class="author-img"><?php echo get_avatar( get_the_author_meta( 'ID' ), 120 ); ?></figure>
                                        <div class="author-content-wrap">
                                            <?php 
                                                echo '<h1 class="author-name"><span class="sub-title">' . esc_html__( 'ALL POSTS BY: ', 'blossom-wedding' ). '</span>' . esc_html( $author_title ) . '</h1>';
                                                echo '<div class="author-info">' . wpautop( wp_kses_post( get_the_author_meta( 'description' ) ) ) . '</div>';
                                            ?>      
                                        </div>    
                                        <?php 
                                    }else{
                                        the_archive_title();
                                        echo '<span class="result-count">' . sprintf( esc_html__( '%1$s RESULTS', 'blossom-wedding' ), number_format_i18n( $wp_query->found_posts ) ) . '</span>';
                                        the_archive_description( '<div class="archive-description">', '</div>' );
                                    }
                                endif;
                                
                                if( is_search() ){ 
                                    global $wp_query;
                                    echo '<h1 class="page-title">' . esc_html__( 'SEARCH RESULTS FOR:', 'blossom-wedding' ) . '</h1>';
                                    get_search_form();
                                    echo '<span class="result-count">' . sprintf( esc_html__( '%1$s RESULTS', 'blossom-wedding' ), number_format_i18n( $wp_query->found_posts ) ) . '</span>';
                                }
                                
                                if( is_page() ){
                                    the_title( '<h1 class="page-title">', '</h1>' );
                                }
                            ?>
                		</div>
                    <?php endif;           
    }
}
endif;
add_action( 'blossom_wedding_content', 'blossom_wedding_content_start' );

if( ! function_exists( 'blossom_wedding_posts_per_page_count' ) ):
/**
*   Counts the Number of total posts in Archive, Search and Author
*/
function blossom_wedding_posts_per_page_count(){
    global $wp_query;
    if( is_archive() || is_search() && $wp_query->found_posts > 0 ) {
        $posts_per_page = get_option( 'posts_per_page' );
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $start_post_number = 0;
        $end_post_number   = 0;

        if( $wp_query->found_posts > 0 && !( blossom_wedding_is_woocommerce_activated() && is_shop() ) ):                
            $start_post_number = 1;
            if( $wp_query->found_posts < $posts_per_page  ) {
                $end_post_number = $wp_query->found_posts;
            }else{
                $end_post_number = $posts_per_page;
            }

            if( $paged > 1 ){
                $start_post_number = $posts_per_page * ( $paged - 1 ) + 1;
                if( $wp_query->found_posts < ( $posts_per_page * $paged )  ) {
                    $end_post_number = $wp_query->found_posts;
                }else{
                    $end_post_number = $paged * $posts_per_page;
                }
            }

            printf( esc_html__( '%1$s Showing:  %2$s - %3$s of %4$s RESULTS %5$s', 'blossom-wedding' ), '<span class="post-count">', absint( $start_post_number ), absint( $end_post_number ), esc_html( number_format_i18n( $wp_query->found_posts ) ), '</span>' );
        endif;
    }
}
endif; 
add_action( 'blossom_wedding_before_posts_content' , 'blossom_wedding_posts_per_page_count', 10 );

if ( ! function_exists( 'blossom_wedding_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function blossom_wedding_post_thumbnail() {
	global $wp_query;
    $image_size  = 'thumbnail';
    $ed_featured = get_theme_mod( 'ed_featured_image', true );
    $sidebar     = blossom_wedding_sidebar();
    
    if( is_home() ){  
        $image_size = blossom_wedding_blog_image_sizes();      
        echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '">';
        if( has_post_thumbnail() ){                        
            the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
        }else{
            blossom_wedding_get_fallback_svg( $image_size );    
        }        
        echo '</a></figure>';
    }elseif( is_archive() || is_search() ){
        $image_size = blossom_wedding_blog_image_sizes();      
        echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '">';
        if( has_post_thumbnail() ){                        
            the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
        }else{
            blossom_wedding_get_fallback_svg( $image_size );    
        }        
        echo '</a></figure>';
    }elseif( is_singular() ){
        $image_size = ( $sidebar ) ? 'blossom-wedding-blog' : 'blossom-wedding-blog-one';
        if( is_single() ){
            if( $ed_featured && has_post_thumbnail() ){
                echo '<figure class="post-thumbnail">';
                the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                echo '</figure>';    
            }
        }else{
            if( has_post_thumbnail() ){
                echo '<div class="post-thumbnail">';
                the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                echo '</div>';    
            }            
        }
    }
}
endif;
add_action( 'blossom_wedding_before_page_entry_content', 'blossom_wedding_post_thumbnail' );
add_action( 'blossom_wedding_before_post_entry_content', 'blossom_wedding_post_thumbnail', 20 );

if( ! function_exists( 'blossom_wedding_entry_header' ) ) :
/**
 * Entry Header
*/
function blossom_wedding_entry_header(){ 
    $readmore = get_theme_mod( 'read_more_text', __( 'READ THE ARTICLE', 'blossom-wedding' ) ); ?>
    <header class="entry-header">
        <?php 
            $ed_cat_single  = get_theme_mod( 'ed_category', false );
            $ed_post_date   = get_theme_mod( 'ed_post_date', false );
            $ed_post_author = get_theme_mod( 'ed_post_author', false );
            
            if( 'post' === get_post_type() ){
                echo '<div class="entry-meta">';
                if( is_single() ){
                    if( ! $ed_post_date ) blossom_wedding_posted_on();
                    if( ! $ed_cat_single ) blossom_wedding_category();
                }else{
                    if( ! $ed_post_date ) blossom_wedding_posted_on();
                }
                echo '</div>';
            }
            
            if ( is_singular() ) :
                the_title( '<h1 class="entry-title">', '</h1>' );
            else :
                the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
            endif; 
        
            if( is_single() ){
                if( ! $ed_post_author ) blossom_wedding_posted_by();
            }
        ?>
    </header>         
    <?php    
}
endif;

if( ! function_exists( 'blossom_wedding_entry_content' ) ) :
/**
 * Entry Content
*/
function blossom_wedding_entry_content(){ 
    $ed_excerpt = get_theme_mod( 'ed_excerpt', true ); ?>
    <div class="entry-content" itemprop="text">
		<?php
			if( is_singular() || ! $ed_excerpt || ( get_post_format() != false ) ){
                the_content();    
    			wp_link_pages( array(
    				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blossom-wedding' ),
    				'after'  => '</div>',
    			) );
            }else{
                the_excerpt();
            }
		?>
	</div><!-- .entry-content -->
    <?php
}
endif;
add_action( 'blossom_wedding_page_entry_content', 'blossom_wedding_entry_content', 15 );
add_action( 'blossom_wedding_post_entry_content', 'blossom_wedding_entry_content', 15 );

if( ! function_exists( 'blossom_wedding_entry_footer' ) ) :
/**
 * Entry Footer
*/
function blossom_wedding_entry_footer(){ 
    $readmore = get_theme_mod( 'read_more_text', __( 'READ THE ARTICLE', 'blossom-wedding' ) ); ?>
	<footer class="entry-footer">
		<?php
			if( is_single() ){
			    blossom_wedding_tag();
			}
            
            if( is_home() || is_archive() || is_search() ){
                echo '<a href="' . esc_url( get_the_permalink() ) . '" class="btn-readmore">' . esc_html( $readmore ) . '</a>';    
            }
            
            if( get_edit_post_link() ){
                edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'blossom-wedding' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						esc_html( get_the_title() )
					),
					'<span class="edit-link">',
					'</span>'
				);
            }
		?>
	</footer><!-- .entry-footer -->
	<?php 
}
endif;
add_action( 'blossom_wedding_page_entry_content', 'blossom_wedding_entry_footer', 20 );
add_action( 'blossom_wedding_post_entry_content', 'blossom_wedding_entry_footer', 20 );

if( ! function_exists( 'blossom_wedding_author' ) ) :
/**
 * Author Section
*/
function blossom_wedding_author(){ 
    $ed_author    = get_theme_mod( 'ed_author', false );
    $author_title = get_the_author_meta( 'display_name' );
    if( ! $ed_author && get_the_author_meta( 'description' ) ){ ?>
    <div class="author-block">
        <figure class="author-img"><?php echo get_avatar( get_the_author_meta( 'ID' ), 120 ); ?></figure>
        <div class="author-content-wrap">
            <?php 
                echo '<h4 class="author-name">' . esc_html( $author_title ) . '</h4>';
                echo '<div class="author-info">' . wpautop( wp_kses_post( get_the_author_meta( 'description' ) ) ) . '</div>';
            ?>      
        </div>
    </div>
    <?php
    }
}
endif;
add_action( 'blossom_wedding_after_post_content', 'blossom_wedding_author', 10 );

if( ! function_exists( 'blossom_wedding_navigation' ) ) :
/**
 * Navigation
*/
function blossom_wedding_navigation(){
    if( is_single() ){
        $previous = get_previous_post_link(
    		'<div class="nav-previous nav-holder">%link</div>',
    		'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 8"><defs><style>.arla{fill:#999596;}</style></defs><path class="arla" d="M16.01,11H8v2h8.01v3L22,12,16.01,8Z" transform="translate(22 16) rotate(180)"/></svg><span class="post-title">%title</span>',
    		false,
    		'',
    		'category'
    	);
    
    	$next = get_next_post_link(
    		'<div class="nav-next nav-holder">%link</div>',
    		'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 8"><defs><style>.arra{fill:#999596;}</style></defs><path class="arra" d="M16.01,11H8v2h8.01v3L22,12,16.01,8Z" transform="translate(-8 -8)"/></svg><span class="post-title">%title</span>',
    		false,
    		'',
    		'category'
    	); 
        
        if( $previous || $next ){?>            
            <nav class="navigation post-navigation" role="navigation">
    			<h2 class="screen-reader-text"><?php esc_html_e( 'Post Navigation', 'blossom-wedding' ); ?></h2>
    			<div class="nav-links">
    				<?php
                        if( $previous ) echo $previous;
                        if( $next ) echo $next;
                    ?>
    			</div>
    		</nav>        
            <?php
        }
    }else{
        
        the_posts_pagination( array(
            'prev_text'          => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 8"><g transform="translate(-8 -8)"><path fill="#121212" d="M16.01,11H8v2h8.01v3L22,12,16.01,8Z" transform="translate(30 24) rotate(180)"/></g></svg>',
            'next_text'          => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 8"><g transform="translate(22 16) rotate(180)"><path fill="#121212" d="M16.01,11H8v2h8.01v3L22,12,16.01,8Z" transform="translate(30 24) rotate(180)"/></g></svg>',
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'blossom-wedding' ) . ' </span>',
        ) );
    }
}
endif;
add_action( 'blossom_wedding_after_post_content', 'blossom_wedding_navigation', 15 );
add_action( 'blossom_wedding_after_posts_content', 'blossom_wedding_navigation' );

if( ! function_exists( 'blossom_wedding_newsletter' ) ) :
/**
 * Newsletter
*/
function blossom_wedding_newsletter(){ 
    $ed_newsletter = get_theme_mod( 'ed_newsletter', true );
    $newsletter    = get_theme_mod( 'newsletter_shortcode' );
    if( $ed_newsletter && $newsletter ){ ?>
        <div class="newsletter">
            <?php echo do_shortcode( $newsletter ); ?>
        </div>
        <?php
    }
}
endif;
add_action( 'blossom_wedding_after_post_content', 'blossom_wedding_newsletter', 30 );

if( ! function_exists( 'blossom_wedding_related_posts' ) ) :
/**
 * Related Posts 
*/
function blossom_wedding_related_posts(){ 
    $ed_related_post = get_theme_mod( 'ed_related', true );
    
    if( $ed_related_post ){
        blossom_wedding_get_posts_list( 'related' );    
    }
}
endif;                                                                               
add_action( 'blossom_wedding_after_post_content', 'blossom_wedding_related_posts', 35 );

if( ! function_exists( 'blossom_wedding_latest_posts' ) ) :
/**
 * Latest Posts
*/
function blossom_wedding_latest_posts(){ 
    blossom_wedding_get_posts_list( 'latest' );
}
endif;
add_action( 'blossom_wedding_latest_posts', 'blossom_wedding_latest_posts' );

if( ! function_exists( 'blossom_wedding_comment' ) ) :
/**
 * Comments Template 
*/
function blossom_wedding_comment(){
    // If comments are open or we have at least one comment, load up the comment template.
	if( get_theme_mod( 'ed_comments', true ) && ( comments_open() || get_comments_number() ) ) :
		comments_template();
	endif;
}
endif;
add_action( 'blossom_wedding_after_post_content', 'blossom_wedding_comment', 45 );
add_action( 'blossom_wedding_after_page_content', 'blossom_wedding_comment' );

if( ! function_exists( 'blossom_wedding_content_end' ) ) :
/**
 * Content End
*/
function blossom_wedding_content_end(){ 
    $home_sections = blossom_wedding_get_home_sections(); 
    if( ! ( is_front_page() && ! is_home() && $home_sections ) ){ ?>            
        </div><!-- .container -->        
    </div><!-- .site-content -->
    <?php
    }
}
endif;
add_action( 'blossom_wedding_before_footer', 'blossom_wedding_content_end', 20 );

if( ! function_exists( 'blossom_wedding_footer_start' ) ) :
/**
 * Footer Start
*/
function blossom_wedding_footer_start(){
    $background_image = get_theme_mod( 'footer_background_image', esc_url( get_template_directory_uri() . '/images/footer-bg.jpg' ) );
    ?>
    <footer id="colophon" class="site-footer" style="background-image: url('<?php echo esc_url( $background_image ); ?>');" itemscope itemtype="http://schema.org/WPFooter">
    <?php
}
endif;
add_action( 'blossom_wedding_footer', 'blossom_wedding_footer_start', 20 );

if( ! function_exists( 'blossom_wedding_footer_top' ) ) :
/**
 * Footer Top
*/
function blossom_wedding_footer_top(){    
    $footer_sidebars = array( 'footer-one', 'footer-two', 'footer-three' );
    $active_sidebars = array();
    $sidebar_count   = 0;
    
    foreach ( $footer_sidebars as $sidebar ) {
        if( is_active_sidebar( $sidebar ) ){
            array_push( $active_sidebars, $sidebar );
            $sidebar_count++ ;
        }
    }
                 
    if( $active_sidebars ){ ?>
        <div class="footer-t">
    		<div class="container">
                <div class="grid column-<?php echo esc_attr( $sidebar_count ); ?>">
                    <?php foreach( $active_sidebars as $active ){ ?>
        				<div class="col">
        				   <?php dynamic_sidebar( $active ); ?>	
        				</div>
                    <?php } ?>
                </div>
    		</div>
    	</div>
        <?php 
    }
}
endif;
add_action( 'blossom_wedding_footer', 'blossom_wedding_footer_top', 30 );

if( ! function_exists( 'blossom_wedding_footer_bottom' ) ) :
/**
 * Footer Bottom
*/
function blossom_wedding_footer_bottom(){ ?>
    <div class="footer-b">
		<div class="container">
			<div class="site-info">            
            <?php
                blossom_wedding_get_footer_copyright();
                echo esc_html__( ' Blossom Wedding | Developed By ', 'blossom-wedding' ); 
                echo '<a href="' . esc_url( 'https://blossomthemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Blossom Themes', 'blossom-wedding' ) . '</a>.';
                printf( esc_html__( ' Powered by %s. ', 'blossom-wedding' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'blossom-wedding' ) ) .'" target="_blank">WordPress</a>' );
                if ( function_exists( 'the_privacy_policy_link' ) ) {
                    the_privacy_policy_link();
                }
            ?>               
            </div>
		</div>
	</div>
    <?php
}
endif;
add_action( 'blossom_wedding_footer', 'blossom_wedding_footer_bottom', 40 );

if( ! function_exists( 'blossom_wedding_back_to_top' ) ) :
/**
 * Back to top
*/
function blossom_wedding_back_to_top(){ ?>
    <button id="back-to-top">
		<span><i class="fas fa-long-arrow-alt-up"></i></span>
	</button>
    <?php
}
endif;
add_action( 'blossom_wedding_footer', 'blossom_wedding_back_to_top', 45 );

if( ! function_exists( 'blossom_wedding_footer_end' ) ) :
/**
 * Footer End 
*/
function blossom_wedding_footer_end(){ ?>
    </footer><!-- #colophon -->
    <?php
}
endif;
add_action( 'blossom_wedding_footer', 'blossom_wedding_footer_end', 50 );

if( ! function_exists( 'blossom_wedding_page_end' ) ) :
/**
 * Page End
*/
function blossom_wedding_page_end(){ ?>
    </div><!-- #page -->
    <?php
}
endif;
add_action( 'blossom_wedding_after_footer', 'blossom_wedding_page_end', 20 );