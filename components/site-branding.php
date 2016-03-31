<?php
/**
 * Template part for displaying the site branding.
 */

?>

<div <?php hybrid_attr( 'branding' ); ?>>
	<?php if ( has_custom_logo() ) : // If the site logo is set. ?>
		<?php if ( is_front_page() || is_home() ) : ?>
			<h1 <?php hybrid_attr( 'site-title' ); ?>><?php the_custom_logo(); ?></h1>
		<?php else: ?>
			<p <?php hybrid_attr( 'site-title' ); ?>><?php the_custom_logo(); ?></p>
		<?php endif; ?>
	<?php else: // If no site logo set. ?>
		<?php hybrid_site_title(); ?>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'display_tagline', 0 ) ) : // If the tagline is enabled. ?>
		<?php hybrid_site_description(); ?>
	<?php endif; ?>
</div><!-- .site-branding -->
