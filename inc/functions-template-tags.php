<?php
/**
 * Various template functions.
 * @package Croft
 */

/**
 * Outputs the edit post link.
 *
 * @return void
 */
function croft_edit_post_link() {
	echo croft_get_edit_post_link();
}

/**
 * Returns a formatted edit post link.
 *
 * @return string
 */
function croft_get_edit_post_link( $id = null ) {
	
	// If no ID is given, get the current posts ID.
	$id = $id ? $id : get_the_ID();

	$link = edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			__( 'Edit %s', 'croft' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>',
		$id
	);
	return $link;
}

/**
 * Outputs the theme credit text.
 *
 * @return void
 */
function croft_theme_credit() {
	echo croft_get_theme_credit();
}

/**
 * Returns the theme credit text.
 *
 * @return string
 */
function croft_get_theme_credit() {
	$credit = sprintf( esc_html__( 'Theme: %1$s by %2$s', 'croft' ), hybrid_get_theme_link(), '<a href="http://github.com/brettsmason/">Brett Mason</a>' );

	return apply_filters( 'croft_theme_credit', $credit );
}
