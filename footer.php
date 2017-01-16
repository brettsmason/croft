<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

?>

	</div><!-- #content -->

	<?php hybrid_get_sidebar( 'subsidiary' ); // Loads the sidebar/subsidiary.php template. ?>

	<footer <?php hybrid_attr( 'footer' ); ?>>
		<div class="row">

			<?php hybrid_get_menu( 'subsidiary' ); // Loads the menu/subsidiary.php template. ?>

			<div class="site-info">
				<div class="copyright">
					<?php croft_theme_copyright(); ?>
				</div><!-- .copyright -->

				<div class="credit">
					<?php croft_theme_credit(); ?>
				</div><!-- .credit -->
			</div><!-- .site-info -->
		</div><!-- .row -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
