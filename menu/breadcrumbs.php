<?php
/**
 * Template part for displaying breadcrumbs.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>

<?php if ( current_theme_supports( 'breadcrumb_trail' ) ) : // Check for breadcrumb support. ?>

	<?php breadcrumb_trail(
		array(
			'container'     => 'nav',
			'show_browse'   => false,
			'show_on_front' => false,
		)
	); ?>

<?php endif; // End check for breadcrumb support. ?>
