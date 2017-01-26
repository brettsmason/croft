<?php
/**
 * Template part for displaying the post byline.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>

<p class="entry-byline">
	<span class="posted-on">
		<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
	</span>

	<?php hybrid_post_author( array( 'text' => __( 'by %s', 'croft' ) ) ); ?>

	<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
		<span class="comments-link">
			<?php comments_popup_link( esc_html__( 'Leave a comment', 'croft' ), esc_html__( '1 Comment', 'croft' ), esc_html__( '% Comments', 'croft' ) ); ?>
		</span>
	<?php endif; ?>
</p><!-- .entry-byline -->
