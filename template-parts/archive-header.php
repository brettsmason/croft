<?php
/**
 * Template part for displaying a page/archive header.
 */
?>

<header <?php hybrid_attr( 'archive-header' ); ?>>

	<h1 <?php hybrid_attr( 'archive-title' ); ?>>
		<?php
		if ( is_home() && ! is_front_page() ) {
			single_post_title();
		} elseif ( is_archive() ) {
			the_archive_title();
		} elseif ( is_search() ) {
			printf( esc_html__( 'Search Results for: %s', 'croft' ), '<span>' . get_search_query() . '</span>' );
		} elseif ( is_404() ) {
			echo esc_html__( 'Oops! That page can&rsquo;t be found.', 'croft' );
		}
		?>
	</h1>

	<?php if ( ! is_paged() && $desc = get_the_archive_description() ) : // Check if we're on page/1. ?>

		<div <?php hybrid_attr( 'archive-description' ); ?>>
			<?php echo $desc; ?>
		</div><!-- .archive-description -->

	<?php endif; // End paged check. ?>

</header><!-- .archive-header -->
