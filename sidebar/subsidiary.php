<?php if ( is_active_sidebar( 'subsidiary' ) ) : // If the sidebar has widgets. ?>

	<section class="widget-area subsidiary" role="complementary">

		<div class="row">

			<?php dynamic_sidebar( 'subsidiary' ); // Displays the subsidiary sidebar. ?>

		</div><!-- .row -->

	</aside><!-- .widget-area -->

<?php endif; // End widgets check. ?>
