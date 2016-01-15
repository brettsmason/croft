<?php
/**
 * Template part for displaying a single comment.
 */

?>

<li <?php hybrid_attr( 'comment' ); ?>>

	<aside class="comment-avatar">
		<?php echo get_avatar( $comment, 52 ); ?>
	</aside>

	<article class="comment-container">
		<header class="comment-header">
			<cite <?php hybrid_attr( 'comment-author' ); ?>><?php comment_author_link(); ?></cite>
			<p class="comment-meta">
				<time <?php hybrid_attr( 'comment-published' ); ?>><?php printf( esc_html__( '%s ago', 'croft' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time>
				<a <?php hybrid_attr( 'comment-permalink' ); ?>><?php esc_html_e( 'Permalink', 'croft' ); ?></a>
				<?php
				edit_comment_link(
					sprintf(
						// translators: %s: Name of current comment
						esc_html__( 'Edit %s', 'croft' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				); ?>
			</p>
		</header><!-- .comment-meta -->

		<div <?php hybrid_attr( 'comment-content' ); ?>>

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-moderation">
					<?php _e( 'Your comment is awaiting moderation.', 'croft' ); ?>
				</p>
			<?php endif; ?>

			<?php comment_text(); ?>
		</div><!-- .comment-content -->

		<?php hybrid_comment_reply_link(); ?>
	</article>

<?php // No closing </li> is needed.  WordPress will know where to add it. ?>
