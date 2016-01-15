<?php
/**
 * The header for our theme.
 * This is the template that displays all of the <head> section and everything up until <div class="site-content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head <?php hybrid_attr( 'head' ); ?>>
<?php wp_head(); ?>
</head>

<body <?php hybrid_attr( 'body' ); ?>>
<div <?php hybrid_attr( 'site-container' ); ?>>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'croft' ); ?></a>

	<header <?php hybrid_attr( 'header' ); ?>>
		<div <?php hybrid_attr( 'row', 'header' ); ?>>
			<div <?php hybrid_attr( 'branding' ); ?>>
				<?php if ( croft_get_site_logo() ) : // If the site logo is set. ?>
					<?php croft_site_logo(); ?>
				<?php else: ?>
					<?php hybrid_site_title(); ?>
				<?php endif; ?>
				<?php if ( get_theme_mod( 'display_tagline', 0 ) ) : // If the tagline is enabled. ?>
					<?php hybrid_site_description(); ?>
				<?php endif; ?>
			</div><!-- .site-branding -->

			<?php hybrid_get_menu( 'social' ); // Loads the menu/social.php template. ?>
		</div><!-- .wrap -->
	</header><!-- #masthead -->

	<?php hybrid_get_menu( 'primary' ); // Loads the menu/primary.php template. ?>

	<div <?php hybrid_attr( 'site-content' ); ?>>
