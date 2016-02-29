<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main <?php hybrid_attr( 'content' ); ?>>

		<?php
		if ( have_posts() ) : ?>

			<?php get_template_part( 'template-parts/archive-header' ); ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Loads the content/archive/post_type.php template
				 * (where post_type is the name of the post type).
				 */
				hybrid_get_content_template();

			endwhile;

			get_template_part( 'template-parts/loop-nav' );

		else :

			get_template_part( 'content/none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
hybrid_get_sidebar( 'primary' ); // Loads the sidebar/primary.php template.
get_footer();
