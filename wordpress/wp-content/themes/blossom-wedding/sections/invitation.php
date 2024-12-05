<?php
/**
 * Invitation Section
 * 
 * @package Blossom_Wedding
 */
$invitation_background 	= get_theme_mod( 'invitation_background', esc_url( get_template_directory_uri() . '/images/form-section-bg.jpg' ) );

if( is_active_sidebar( 'invitation' ) ){ ?>
<section id="invitation_section" class="invitation-section" <?php if( $invitation_background ) echo 'style="background-image: url( ' . esc_url( $invitation_background ) . ' );"'; ?>>
	<div class="container">
	    <?php dynamic_sidebar( 'invitation' ); ?>
	</div>
</section> <!-- .invitation-section -->
<?php
}