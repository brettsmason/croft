<?php if ( has_nav_menu( 'primary' ) ) : // Check if there's a menu assigned to the 'primary' location. ?>

	<nav id="site-navigation" class="main-navigation" role="navigation">

		<?php wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => '',
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'menu-items menu horizontal dropdown',
				'fallback_cb'    => '',
				'items_wrap'     => '<ul id="%s" class="%s" data-dropdown-menu>%s</ul>',
				'walker'         => new Foundation_Menu_Walker()
			)
		); ?>

	</nav><!-- #site-navigation -->

<?php endif; // End check for menu. ?>
