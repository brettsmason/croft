<?php
/**
 * Hybrid Core Compatibility and Mods File.
 */

/**
 * Sets the header ID.
 */
function croft_attr_header_replacement( $attr ) {

	$attr['id'] = 'masthead';

	return $attr;
}
add_filter( 'hybrid_attr_header', 'croft_attr_header_replacement' );

/**
 * Sets the main container ID/class.
 */
function croft_attr_content_replacement( $attr ) {

	$attr['id'] = 'main';
	$attr['class'] = 'site-main';

	return $attr;
}
add_filter( 'hybrid_attr_content', 'croft_attr_content_replacement' );

/**
 * Sets the footer ID.
 */
function croft_attr_footer_replacement( $attr ) {

	$attr['id'] = 'colophon';

	return $attr;
}
add_filter( 'hybrid_attr_footer', 'croft_attr_footer_replacement' );

/**
 * Search the template paths and replace them with singular and archive versions.
 */
function croft_content_template_hierarchy( $templates ) {
	if ( is_singular() || is_attachment() ) {
		$templates = str_replace( 'content/', 'content/singular/', $templates );
	} else {
		$templates = str_replace( 'content/', 'content/archive/', $templates );
	}
	return $templates;
}
add_filter( 'hybrid_content_template_hierarchy', 'croft_content_template_hierarchy' );

/**
 * Remove unwanted default Hybrid head elements.
 */
remove_action( 'wp_head',  'hybrid_meta_template', 1 );

/**
 * Returns the linked site title wrapped in a '<p>' tag unless on the home page
 * or the main blog page where no other H1 exists.
 */
function croft_seo_site_title( $title ) {
	if ( is_front_page() || is_home() ) {
		return $title;
	}
	return str_replace( array( '<h1', '</h1' ), array( '<p', '</p' ), $title );
}
add_filter( 'hybrid_site_title', 'croft_seo_site_title' );

/**
 * Returns the site description wrapped in a `<p>` tag.
 */
function croft_seo_site_description( $desc ) {
	return str_replace( array( '<h2', '</h2' ), array( '<p', '</p' ), $desc );
}
add_filter( 'hybrid_site_description', 'croft_seo_site_description' );
