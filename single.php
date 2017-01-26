<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main <?php hybrid_attr( 'content' ); ?>>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post(); ?>

				<?php
				/*
				* Loads the content/singular/post_type.php template
				* (where post_type is the name of the post type).
				*/
				hybrid_get_content_template(); ?>

				<?php get_template_part( 'template-parts/pagination' ); ?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) : ?>
					<?php comments_template(); ?>
				<?php endif; ?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php hybrid_get_sidebar( 'primary' ); // Loads the sidebar/primary.php template. ?>
<?php get_footer(); ?>
