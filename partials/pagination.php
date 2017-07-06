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

	<nav class="pager-container">
		<ul class="pager" role="navigation" aria-label="Pagination">
			<?php previous_post_link( '<li class="pager-item pager-prev"><span class="pager-item-title">' . esc_html_x( 'Previous:', 'previous post navigation', 'croft' ) . '</span>%link</li>' ); ?>
			<?php next_post_link( '<li class="pager-item pager-next"><span class="pager-item-title">' . esc_html_x( 'Next:', 'next post navigation', 'croft' ) . '</span>%link</li>' ); ?>
		</ul>
	</nav><!-- .pager-container -->

<?php elseif ( hybrid_is_plural() ) : // If viewing the blog, an archive, or search results. ?>

	<?php the_posts_pagination(
		array(
			'mid_size'           => 2,
			'prev_text'          => esc_html_x( 'Previous', 'posts navigation', 'croft' ),
			'next_text'          => esc_html_x( 'Next',     'posts navigation', 'croft' ),
			'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'croft' ) . ' </span>',
			'type'               => 'list'
		)
	); ?>

<?php endif; // End check for type of page being viewed. ?>
