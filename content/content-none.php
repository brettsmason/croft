<?php
/**
 * Template part used if no content was found (404 or search).
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>

<section class="entry no-results not-found">
	<header class="entry-header">
		<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php esc_html_e( 'Nothing Found', 'croft' ); ?></h1>
	</header><!-- .entry-header -->

	<div <?php hybrid_attr( 'entry-content' ); ?>>
		<?php if ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, nothing matched your search terms. Please try again with some different keywords.', 'croft' ); ?></p>

		<?php else : ?>

			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'croft' ); ?></p>

		<?php endif; ?>

		<?php get_search_form(); ?>
	</div><!-- .entry-content -->
</section><!-- .no-results -->
