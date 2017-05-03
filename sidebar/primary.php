<?php if ( '1c' !== hybrid_get_theme_layout() ) : // If not a one-column layout. ?>

	<section class="widget-area primary" role="complementary">

		<?php if ( is_active_sidebar( 'primary' ) ) : // If the sidebar has widgets. ?>

			<?php dynamic_sidebar( 'primary' ); // Displays the primary sidebar. ?>

		<?php endif; // End widgets check. ?>

	</section><!-- #sidebar-primary -->

<?php endif; // End layout check. ?>
