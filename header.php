<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head <?php hybrid_attr( 'head' ); ?>>
<?php wp_head(); ?>
</head>

<body <?php hybrid_attr( 'body' ); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'croft' ); ?></a>

	<header <?php hybrid_attr( 'header' ); ?>>
		<div class="row">

			<?php get_template_part( 'components/site-branding' ); // Loads the components/site-branding.php template. ?>

			<?php hybrid_get_menu( 'social' ); // Loads the menu/social.php template. ?>

		</div><!-- .row -->
	</header><!-- #masthead -->

	<?php hybrid_get_menu( 'primary' ); // Loads the menu/primary.php template. ?>

	<div id="content" class="site-content">
