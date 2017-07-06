<?php
/**
 * Template part for displaying a page header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Croft
 */

?>

<?php $class = ( is_home() && ! is_front_page() ? 'page-title screen-reader-text' : 'page-title' ); ?>

<header class="page-header">

	<h1 class="<?php echo $class; ?>">
	<?php
	if ( is_home() && ! is_front_page() ) :
		single_post_title();
	elseif ( is_tax() ) :
		single_term_title();
	elseif ( is_archive() ) :
		the_archive_title();
	elseif ( is_search() ) :
		printf( esc_html__( 'Search Results for: %s', 'croft' ), '<span class="search-term">' . get_search_query() . '</span>' );
	elseif ( is_404() ) :
		esc_html_e( 'Oops! That page can&rsquo;t be found.', 'croft' );
	endif;
	?>
	</h1>

	<?php if ( ! is_paged() && get_the_archive_description() ) {
		the_archive_description( '<div class="page-description">', '</div>' );
	} ?>

</header><!-- .page-header -->
