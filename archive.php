<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main <?php hybrid_attr( 'content' ); ?>>

		<?php if ( have_posts() ) : ?>

			<?php get_template_part( 'template-parts/archive-header' ); ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post(); ?>

				<?php
				/*
				 * Loads the content/archive/post_type.php template
				 * (where post_type is the name of the post type).
				 */
				hybrid_get_content_template(); ?>

			<?php endwhile; ?>

			<?php get_template_part( 'template-parts/loop-nav' ); ?>

		<?php else : ?>

			<?php get_template_part( 'content/none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php hybrid_get_sidebar( 'primary' ); // Loads the sidebar/primary.php template. ?>
<?php get_footer(); ?>
