<?php
/**
 * Croft functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

// Get the template directory and make sure it has a trailing slash.
$croft_dir = trailingslashit( get_template_directory() );

// Load the Hybrid Core framework and theme files.
require_once( $croft_dir . 'inc/hybrid-core/hybrid.php' );
require_once( $croft_dir . 'inc/hc-overrides.php' );
require_once( $croft_dir . 'inc/theme-setup.php' );
require_once( $croft_dir . 'inc/utility.php' );
require_once( $croft_dir . 'inc/customizer.php' );

// Defines custom Hybrid Core directory.
define( 'HYBRID_DIR', trailingslashit( get_template_directory() ) . 'inc/hybrid-core/' );
define( 'HYBRID_URI', trailingslashit( get_template_directory_uri() ) . 'inc/hybrid-core/' );

// Launch the Hybrid Core framework.
new Hybrid();

function croft_theme_setup() {

	// Theme layouts.
	add_theme_support( 'theme-layouts', array( 'default' => is_rtl() ? '2c-r' :'2c-l' ) );

	// Enable custom template hierarchy.
	add_theme_support( 'hybrid-core-template-hierarchy' );

	// The best thumbnail/image script ever.
	add_theme_support( 'get-the-image' );

	// Breadcrumbs. Yay!
	add_theme_support( 'breadcrumb-trail' );

	// Nicer [gallery] shortcode implementation.
	add_theme_support( 'cleaner-gallery' );

	// Automatically add feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// Post formats.
	add_theme_support(
		'post-formats',
		array( 'image', 'gallery', 'video' )
	);

	// Site logo.
	add_theme_support( 'custom-logo', array(
		'height'      => 300,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Handle content width for embeds and images.
	hybrid_set_content_width( 1200 );
}
add_action( 'after_setup_theme', 'croft_theme_setup', 5 );
