<?php
/**
 * Various small changes and helpers for the theme.
 * @package Croft
 */

/**
 * Filters the custom logo output to include the site name as the alt tag.
 *
 * @return string
 */
function croft_custom_logo_args() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );

	$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
		esc_url( home_url( '/' ) ),
		wp_get_attachment_image( $custom_logo_id, 'full', false, array(
			'class'    => 'custom-logo',
			'itemprop' => 'logo',
			'alt' => esc_attr( get_bloginfo( 'name' ) ),
		) )
	);

	return $html;
}
add_filter( 'get_custom_logo', 'croft_custom_logo_args' );

/**
 * Change [...] to ... with added screen reader text.
 *
 * @return string
 */
function croft_excerpt_more() {
	/* Translators: The %s is the post title shown to screen readers. */
	$text = '<span class="screen-reader-text">' . sprintf( esc_attr__( 'Continue reading %s', 'croft' ), get_the_title() ) . '</span>';
	$more = sprintf( ' <a href="%s" class="more-link">&hellip; %s</a>', esc_url( get_permalink() ), $text );
	return $more;
}
add_filter( 'excerpt_more', 'croft_excerpt_more' );

/**
 * Change .sticky class for sticky posts for compatibility with Foundation.
 *
 * @param array $classes
 * @return array
 */
function croft_sticky_class( $classes ) {
	if ( ( $key = array_search( 'sticky', $classes ) ) !== false ) {
		unset( $classes[$key] );
		$classes[] = 'sticky-post';
	}
	return $classes;
}
add_filter( 'post_class', 'croft_sticky_class', 20 );

/**
 * Adds widget number count as a class to the subsidiary widget area container.
 *
 * @param $attr
 * @param $context
 * @return mixed
 */
function croft_sidebar_subsidiary_class( $attr, $context ) {
	if ( 'subsidiary' === $context ) {
	global $sidebars_widgets;
		if ( is_array( $sidebars_widgets ) && !empty( $sidebars_widgets[ $context ] ) ) {
			$count = count( $sidebars_widgets[ $context ] );
			if ( 1 === $count )
			$attr['class'] .= ' one';
			elseif ( 2 === $count )
			$attr['class'] .= ' two';
			elseif ( 3 === $count )
			$attr['class'] .= ' three';
			elseif ( 4 === $count )
			$attr['class'] .= ' four';
			elseif ( 5 === $count )
			$attr['class'] .= ' five';
			elseif ( 6 === $count )
			$attr['class'] .= ' six';
			}
		}

	return $attr;
}
add_filter( 'hybrid_attr_sidebar', 'croft_sidebar_subsidiary_class', 10, 2 );
