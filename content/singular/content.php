<?php
/**
 * Template part for displaying post types in single.php.
 * This is a fallback template and is used if no corresponding
 * named partial is available.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>

<article <?php hybrid_attr( 'post' ); ?>>
	<header class="entry-header">
		<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php the_title(); ?></h1>
		<?php get_template_part( 'template-parts/entry', 'byline' ); ?>
	</header><!-- .entry-header -->

	<div <?php hybrid_attr( 'entry-content' ); ?>>
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'croft' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'croft' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php get_template_part( 'template-parts/entry', 'footer' ); ?>
</article><!-- #post-## -->
