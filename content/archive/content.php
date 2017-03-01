<?php
/**
 * Template part for displaying post types in archive.php.
 * This is a fallback template and is used if no corresponding
 * named partial is available.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>

<article <?php hybrid_attr( 'post' ); ?>>
	<header class="entry-header">
		<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
		<?php get_template_part( 'template-parts/entry', 'byline' ); ?>
	</header><!-- .entry-header -->

	<div <?php hybrid_attr( 'entry-summary' ); ?>>
		<?php get_the_image( array( 'size' => 'thumbnail', 'image_class' => 'alignleft', 'order' => array( 'featured', 'attachment' ) ) ); ?>
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<?php get_template_part( 'template-parts/entry', 'footer' ); ?>
</article><!-- #post-## -->
