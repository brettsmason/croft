<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>

<article <?php hybrid_attr( 'post' ); ?>>
	<?php if( croft_show_page_title() ) : ?>
	<header class="entry-header">
		<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php the_title(); ?></h1>
	</header><!-- .entry-header -->
	<?php endif; ?>

	<div <?php hybrid_attr( 'entry-content' ); ?>>
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'croft' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
