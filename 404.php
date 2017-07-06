<?php get_header(); ?>

	<div id="primary" <?php hybrid_attr( 'content-area' ); ?>>
		<main id="main" <?php hybrid_attr( 'site-main' ); ?>>

			<section class="entry error-404 not-found">
				<header class="entry-header">
					<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'croft' ); ?></h1>
				</header><!-- .entry-header -->

				<div <?php hybrid_attr( 'entry-content' ); ?>>
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'croft' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .entry-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php hybrid_get_sidebar( 'primary' ); // Loads the sidebar/primary.php template. ?>
<?php get_footer(); ?>
