<?php
/**
 * Template part for displaying post navigation.
 * previous_post_link/xt_post_link is used on a single post to navigate between posts.
 * the_posts_pagination is used on archives for numbered pagination.
 *
 * @link https://codex.wordpress.org/Function_Reference/previous_post_link
 * @link https://codex.wordpress.org/Function_Reference/next_post_link
 * @link https://codex.wordpress.org/Function_Reference/the_posts_pagination
 */

?>

<?php if ( is_singular( 'post' ) ) : // If viewing a single post page. ?>

	<div class="pager">
		<?php previous_post_link( '<div class="prev">' . esc_html__( 'Previous: %link', 'croft' ) . '</div>', '%title' ); ?>
		<?php next_post_link(     '<div class="next">' . esc_html__( 'Next: %link',     'croft' ) . '</div>', '%title' ); ?>
	</div><!-- .loop-nav -->

<?php elseif ( hybrid_is_plural() ) : // If viewing the blog, an archive, or search results. ?>

	<?php the_posts_pagination(
		array(
			'prev_text' => esc_html_x( 'Previous', 'posts navigation', 'croft' ),
			'next_text' => esc_html_x( 'Next',     'posts navigation', 'croft' ),
			'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'croft' ) . ' </span>',
			'type' => 'list'
		)
	); ?>

<?php endif; // End check for type of page being viewed. ?>
