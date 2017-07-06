<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" <?php hybrid_attr( 'site-main' ); ?>>

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header <?php hybrid_attr( 'archive-title' ); ?>>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php endif; ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post(); ?>

				<?php
				/*
				 * Include the Post type specific template for the content.
				 * Include a file called 'post_type'.php (where 'post_type' is the post type name)
				 * in either content/archive (for archives) or content/singular for singlular post types
				 * and that will be used instead.
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
