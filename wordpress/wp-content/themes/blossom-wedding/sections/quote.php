<?php
/**
 * Quote Section
 * 
 * @package Blossom_Wedding
 */

if( is_active_sidebar( 'quote' ) ){ ?>
<section id="quote_section" class="quote-section">
    <?php dynamic_sidebar( 'quote' ); ?>
</section> <!-- .bg-cta-section -->
<?php
}