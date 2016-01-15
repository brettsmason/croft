<?php
/**
 * Template part for displaying single pingbacks.
 */

?>

<li <?php hybrid_attr( 'comment' ); ?>>

	<header class="comment-header">
		<p class="comment-meta">
			<cite <?php hybrid_attr( 'comment-author' ); ?>><?php comment_author_link(); ?></cite><br />
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

<?php // No closing </li> is needed.  WordPress will know where to add it. ?>
