<?php
/**
 * Include this file in functions.php if you want to go with the class approach.
 * Be sure to remove any layout styles in the Sass files
 * (eg assets/scss/modules/_main.scss) if using this method.
 */

/**
 * Adds classes to the <main> container.
 */
function croft_branding_class( $attr ) {

	$attr['class'] .= ' medium-4 columns';

	return $attr;
}
add_filter( 'hybrid_attr_branding', 'croft_branding_class', 20 );

/**
 * Adds classes to the <main> container.
 */
function croft_site_content_class( $attr ) {

	if ( '2c-l' == hybrid_get_theme_layout() )
		$attr['class'] = 'medium-9 columns';

	elseif ( '2c-r' == hybrid_get_theme_layout() )
		$attr['class'] = 'medium-9 medium-push-3 columns';

	else
		$attr['class'] .= 'small-12 columns';

	return $attr;
}
add_filter( 'hybrid_attr_site_content', 'croft_site_content_class' );


/**
 * Adds classes to the primary sidebar.
 */
function croft_sidebar_class( $attr, $context ) {

	if ( 'primary' === $context && '2c-l' == hybrid_get_theme_layout() )
		$attr['class'] .= ' medium-3 columns';

	elseif ( 'primary' === $context && '2c-r' == hybrid_get_theme_layout() )
		$attr['class'] .= ' medium-3 medium-pull-9 columns';

	return $attr;
}
add_filter( 'hybrid_attr_sidebar', 'croft_sidebar_class', 10, 2 );


/**
 * Adds classes to comments.
 */
function croft_comment_class( $attr, $context ) {

	$attr['class'] .= ' media-object';

	return $attr;
}
add_filter( 'hybrid_attr_comment', 'croft_comment_class', 10, 2 );
