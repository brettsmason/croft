<?php if ( has_nav_menu( 'primary' ) ) : // Check if there's a menu assigned to the 'primary' location. ?>

	<nav <?php hybrid_attr( 'menu', 'primary' ); ?>>

		<div class="menu-toggle" data-responsive-toggle="primary-menu" data-hide-for="medium">
			<button data-toggle><?php croft_do_svg( 'menu-toggle', array( 'inline' => true ) ); ?> <?php esc_html_e( 'Menu', 'croft' );?></button>
		</div><!-- .menu-toggle -->

		<div class="row">
			<?php wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => '',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'menu-items menu vertical medium-horizontal',
					'fallback_cb'    => '',
					'items_wrap'     => '<ul id="%s" class="%s" data-responsive-menu="accordion medium-dropdown">%s</ul>',
					'walker'         => new Foundation_Menu_Walker()
				)
			); ?>
		</div><!-- .row -->

	</nav><!-- #menu-primary -->

<?php endif; // End check for menu. ?>
