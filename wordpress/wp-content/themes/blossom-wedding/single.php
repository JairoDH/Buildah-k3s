<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Blossom_Wedding
 */

get_header(); ?>
        <main id="main" class="site-main">

            <?php
                while ( have_posts() ) : the_post();

                    get_template_part( 'template-parts/content', get_post_type() );

                endwhile; // End of the loop.
            ?>

        </main><!-- #main -->

        <?php
            /**
            * @hooked blossom_wedding_author               - 10
            * @hooked blossom_wedding_navigation           - 15  
            * @hooked blossom_wedding_newsletter           - 30
            * @hooked blossom_wedding_related_posts        - 35
            * @hooked blossom_wedding_comment              - 45
            */
            do_action( 'blossom_wedding_after_post_content' );
        ?>

    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
