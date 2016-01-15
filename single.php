<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

get_header(); ?>

	<div <?php hybrid_attr( 'content-area' ); ?>>
		<main <?php hybrid_attr( 'content' ); ?>>

		<?php
		while ( have_posts() ) : the_post();

			/*
			 * Loads the content/singular/post_type.php template
			 * (where post_type is the name of the post type).
			 */
			hybrid_get_content_template();

			get_template_part( 'template-parts/loop-nav' );

			// get_template_part( 'template-parts/author-box' ); // Display the author profile box.

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
