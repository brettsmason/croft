<?php
/**
 * Template part for displaying the entry footer.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>

<footer class="entry-footer">
	<?php hybrid_post_terms( array( 'taxonomy' => 'category', 'text' => esc_html__( 'Filed Under: %s', 'croft' ) ) ); ?>
	<?php hybrid_post_terms( array( 'taxonomy' => 'post_tag', 'text' => esc_html__( 'Tagged With: %s', 'croft' ) ) ); ?>
</footer><!-- .entry-footer -->
