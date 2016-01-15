<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 */

get_header(); ?>

	<div <?php hybrid_attr( 'content-area' ); ?>>
		<main <?php hybrid_attr( 'content' ); ?>>

		<?php
		if ( have_posts() ) : ?>

			<header <?php hybrid_attr( 'archive-header' ); ?>>
				<h1 <?php hybrid_attr( 'archive-title' ); ?>><?php printf( esc_html__( 'Search Results for: %s', 'croft' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .archive-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				hybrid_get_content_template();

			endwhile;

			get_template_part( 'template-parts/loop-nav' );

		else :

			get_template_part( 'content/none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
hybrid_get_sidebar( 'primary' ); // Loads the sidebar/primary.php template.
get_footer();
