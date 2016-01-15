<?php
/**
 * Template part for displaying the social menu.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>

<?php if ( has_nav_menu( 'social' ) ) : // Check if there's a menu assigned to the 'social' location. ?>

	<nav <?php hybrid_attr( 'menu', 'social' ); ?>>

		<?php wp_nav_menu(
			array(
				'theme_location'  => 'social',
				'container'       => '',
				'menu_id'         => 'menu-social',
				'menu_class'      => 'navigation',
				'depth'           => 1,
				'link_before'     => '<span class="screen-reader-text">',
				'link_after'      => '</span>',
				'fallback_cb'     => '',
			)
		); ?>

	</nav><!-- #menu-social -->

<?php endif; // End check for menu. ?>
