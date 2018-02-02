<?php if ( has_nav_menu( 'primary' ) ) : // Check if there's a menu assigned to the 'primary' location. ?>

	<nav <?php hybrid_attr( 'menu', 'primary' ); ?>>

		<?php wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => '',
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'menu-items menu horizontal dropdown',
				'fallback_cb'    => '',
				'items_wrap'     => '<ul id="%s" class="%s" data-dropdown-menu>%s</ul>'
			)
		); ?>

	</nav><!-- #menu-primary -->

<?php endif; // End check for menu. ?>
