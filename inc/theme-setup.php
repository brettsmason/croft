<?php

/**
 * Registers custom image sizes for the theme.
 */
function croft_register_image_sizes() {

	// Sets the 'post-thumbnail' size.
	// set_post_thumbnail_size( 150, 150, true );

	// add_image_size( 'fdn_small', 320 );
	// add_image_size( 'fdn_medium', 640 );
	// add_image_size( 'fdn_large', 1024 );
	// add_image_size( 'fdn_xlarge', 1200 );
}
add_action( 'init', 'croft_register_image_sizes', 5 );

/**
 * Registers nav menu locations.
 */
function croft_register_menus() {
	register_nav_menu( 'primary',    esc_html_x( 'Primary',    'nav menu location', 'croft' ) );
	register_nav_menu( 'subsidiary', esc_html_x( 'Subsidiary', 'nav menu location', 'croft' ) );
	register_nav_menu( 'social',     esc_html_x( 'social',     'nav menu location', 'croft' ) );
}
add_action( 'init', 'croft_register_menus', 5 );

/**
 * Registers layouts.
 */
function croft_register_layouts() {

	hybrid_register_layout( '1c',   array( 'label' => esc_html__( '1 Column', 'croft' ),          'image' => '%s/assets/img/layouts/1c.svg' ) );
	hybrid_register_layout( '2c-l', array( 'label' => esc_html__( 'Content / Sidebar', 'croft' ), 'image' => '%s/assets/img/layouts/2c-l.svg' ) );
	hybrid_register_layout( '2c-r', array( 'label' => esc_html__( 'Sidebar / Content', 'croft' ), 'image' => '%s/assets/img/layouts/2c-r.svg' ) );
}
add_action( 'hybrid_register_layouts', 'croft_register_layouts' );

/**
 * Registers sidebars.
 */
function croft_register_sidebars() {

	hybrid_register_sidebar(
		array(
			'id'          => 'primary',
			'name'        => esc_html_x( 'Primary', 'sidebar', 'croft' ),
			'description' => esc_html__( 'The main sidebar area.', 'croft' )
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'subsidiary',
			'name'        => esc_html_x( 'Subsidiary', 'sidebar', 'croft' ),
			'description' => esc_html__( 'The footer widget area.', 'croft' )
		)
	);
}
add_action( 'widgets_init', 'croft_register_sidebars', 5 );

/**
 * Load scripts for the front end.
 */
function croft_enqueue_scripts() {

	$suffix = hybrid_get_min_suffix();

	wp_enqueue_script(
		'theme-js',
		trailingslashit( get_template_directory_uri() ) . "assets/js/main{$suffix}.js",
		array( 'jquery' ),
		null,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'croft_enqueue_scripts', 5 );

/**
 * Load stylesheets for the front end.
 */
function croft_enqueue_styles() {

	wp_enqueue_style( 'theme-fonts', '//fonts.googleapis.com/css?family=Montserrat|Istok+Web' );

	// Load parent theme stylesheet if child theme is active.
	if ( is_child_theme() )
		wp_enqueue_style( 'hybrid-parent' );

	// Load active theme stylesheet.
	wp_enqueue_style( 'hybrid-style' );
}
add_action( 'wp_enqueue_scripts', 'croft_enqueue_styles', 5 );

/**
 * Editor stylesheets
 */
function croft_add_editor_styles() {

	// Set up editor styles
	$editor_styles = array(
		"assets/css/editor-style.min.css",
	);
	// Add the editor styles.
	add_editor_style( $editor_styles );
}
add_action( 'admin_init', 'croft_add_editor_styles' );
