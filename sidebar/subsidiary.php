<?php
/**
 * The sidebar containing the subsidiary widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
?>

<?php if ( is_active_sidebar( 'subsidiary' ) ) : // If the sidebar has widgets. ?>

	<aside <?php hybrid_attr( 'sidebar', 'subsidiary' ); ?>>

		<div <?php hybrid_attr( 'row', 'subsidiary' ); ?>>

			<?php dynamic_sidebar( 'subsidiary' ); // Displays the subsidiary sidebar. ?>

		</div><!-- .row -->

	</aside><!-- #sidebar-subsidiary -->

<?php endif; // End widgets check. ?>