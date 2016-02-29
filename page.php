<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main <?php hybrid_attr( 'content' ); ?>>

			<?php
			while ( have_posts() ) : the_post();

				/*
				 * Loads the content/singular/page.php template.
				 */
				hybrid_get_content_template();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
hybrid_get_sidebar( 'primary' ); // Loads the sidebar/primary.php template.
get_footer();
