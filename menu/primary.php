<?php
/**
 * Template part for the primary menu.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>

<?php if ( has_nav_menu( 'primary' ) ) : // Check if there's a menu assigned to the 'primary' location. ?>

	<nav <?php hybrid_attr( 'menu', 'primary' ); ?>>

		<div class="menu-toggle" data-responsive-toggle="primary-menu" data-hide-for="medium">
			<button data-toggle><span></span> <?php esc_html_e( 'Menu', 'croft' );?></button>
		</div><!-- .menu-toggle -->

		<?php wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => '',
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'primary menu vertical medium-horizontal',
				'fallback_cb'    => '',
				'items_wrap'     => '<div ' . hybrid_get_attr( 'row', 'menu-primary' ) . '><ul id="%s" class="%s" data-responsive-menu="accordion medium-dropdown">%s</ul></div>',
				'walker'         => new Foundation_Menu_Walker()
			)
		); ?>

	</nav><!-- #menu-primary -->

<?php endif; // End check for menu. ?>
