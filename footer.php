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
			<div class="site-info">
				<div class="copyright">
					<?php printf(
						// Translators: 1 is current year, 2 is site name/link.
						esc_html__( 'Copyright &#169; %1$s %2$s', 'croft' ),
						date_i18n( 'Y' ), hybrid_get_site_link()
					); ?>
				</div><!-- .copyright -->
				<div class="credit">
					<?php printf(
						// Translators: 1 is WordPress name/link, and 2 is theme name/link.
						esc_html__( 'Powered by %1$s and %2$s', 'croft' ),
						hybrid_get_wp_link(), hybrid_get_theme_link()
					); ?>
				</div><!-- .credit -->
			</div><!-- .site-info -->
		</div><!-- .row -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
