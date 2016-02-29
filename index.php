<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main <?php hybrid_attr( 'content' ); ?>>

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header <?php hybrid_attr( 'archive-title' ); ?>>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post type specific template for the content.
				 * Include a file called 'post_type'.php (where 'post_type' is the post type name)
				 * in either content/archive (for archives) or content/singular for singlular post types
				 * and that will be used instead.
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
