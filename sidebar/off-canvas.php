<div <?php hybrid_attr( 'sidebar', 'off-canvas', array( 'class' => 'off-canvas position-left' ) ); ?> data-off-canvas data-content-scroll="false">

	<?php if ( is_active_sidebar( 'off-canvas' ) ) : // If the sidebar has widgets. ?>

		<?php dynamic_sidebar( 'off-canvas' ); // Displays the off-canvas sidebar. ?>

	<?php endif; // End widgets check. ?>

</div><!-- #sidebar-off-canvas -->
