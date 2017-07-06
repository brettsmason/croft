<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" <?php hybrid_attr( 'site-main' ); ?>>

		<?php if ( have_posts() ) : ?>

			<header <?php hybrid_attr( 'archive-header' ); ?>>
				<h1 <?php hybrid_attr( 'archive-title' ); ?>><?php printf( esc_html__( 'Search Results for: %s', 'croft' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .archive-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				hybrid_get_content_template(); ?>

			<?php endwhile; ?>

			<?php get_template_part( 'components/loop-nav' ); ?>

		<?php else : ?>

			<?php get_template_part( 'content/none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php hybrid_get_sidebar( 'primary' ); // Loads the sidebar/primary.php template. ?>
<?php get_footer(); ?>
