<?php
/**
 * Various template functions.
 *
 * @package Croft
 */

/**
 * Check to see if the page title should be displayed.
 *
 * @return boolean
 */
function croft_show_page_title() {
	if( get_post_meta( get_the_ID(), 'hide_page_title', true ) ) {
		return false;
	}

	return true;
}

/**
 * Outputs the theme copyright text.
 *
 * @return void
 */
function croft_theme_copyright() {
	echo croft_get_theme_copyright();
}

/**
 * Returns the theme copyright text.
 *
 * @return string
 */
function croft_get_theme_copyright() {

	$copyright = sprintf(
		// Translators: 1 is current year, 2 is site name.
		esc_html__( 'Copyright &#169; %1$s %2$s', 'croft' ),
		date_i18n( 'Y' ),
		get_bloginfo( 'name' )
	);

	return apply_filters( 'croft_theme_copyright', $copyright );
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

	$credit = sprintf( esc_html__( 'Theme: %1$s by %2$s', 'croft' ), hybrid_get_theme_link(), '<a href="https://github.com/brettsmason/">Brett Mason</a>' );

	return apply_filters( 'croft_theme_credit', $credit );
}
