<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head <?php hybrid_attr( 'head' ); ?>>
<?php wp_head(); ?>
</head>

<body <?php hybrid_attr( 'body' ); ?>>

<?php hybrid_get_sidebar( 'off-canvas' ); // Loads the sidebar/off-canvas.php template. ?>

<div id="page" class="site off-canvas-content" data-off-canvas-content>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'croft' ); ?></a>

	<header <?php hybrid_attr( 'header' ); ?>>
		<div class="row">

			<div <?php hybrid_attr( 'branding' ); ?>>
				<button class="menu-toggle" data-toggle="sidebar-off-canvas"><?php croft_do_svg( 'menu-toggle', array( 'inline' => true ) ); ?> <?php esc_html_e( 'Menu', 'croft' );?></button>

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

			<?php hybrid_get_menu( 'primary' ); // Loads the menu/primary.php template. ?>

		</div><!-- .row -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
