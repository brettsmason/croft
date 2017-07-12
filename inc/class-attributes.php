<?php
/**
 * Set default classes that we can apply to elements with the `hybrid_attr` function.
 */
function croft_class_defaults() {
	$defaults = array(

		// ROWS
		'row-header'                => 'grid-x grid-margin-x',
		'row-content'               => 'grid-x grid-margin-x',
		'row-footer'                => '',

		// CONTAINERS
		'container-header'          => 'grid-container',
		'container-content'         => 'grid-container',
		'container-footer'          => 'grid-container',

		// SITE HEADER
		'site-header'               => '',
		'branding'                  => 'cell auto',
		'site-title'                => '',
		'site-description'          => '',

		// CONTENT
		'site-content'              => '',
		'content-area'              => croft_content_classes(),

		'page-header'               => '',
		'page-title'                => '',
		'archive-description'       => '',

		// ENTRY
		'post'                      => '',

		'entry-header'              => '',
		'entry-title'               => '',
		'entry-content'             => '',
		'entry-summary'             => '',
		'entry-footer'              => '',

		// NAVIGATION
		'menu-primary'              => '',
		'menu-secondary'            => '',

		// SIDEBAR
		'sidebar-primary'           => croft_sidebar_classes(),
		'sidebar-subsidiary'        => 'grid-x grid-margin-x',

		// SITE FOOTER
		'site-footer'               => '',
		'site-info'                 => 'text-center'
	);

	return apply_filters( 'croft_classes_args', $defaults );
}

/**
 * Filter `hybrid_attr` slugs and append classes from our `croft_class_defaults` function.
 */
function croft_filter_classes( $attr, $slug ) {
	$classes = croft_class_defaults();

	if ( isset( $classes[ $slug ] ) )
		$attr['class'] .= ' ' . $classes[ $slug ];

	return $attr;
}
add_filter( 'hybrid_attr', 'croft_filter_classes', 10, 2 );

/**
 *  Sets content classes depending on layout
 */
function croft_content_classes() {
	if( '1c' === hybrid_get_theme_layout() )
		$class = 'cell';

	if( '2c-l' === hybrid_get_theme_layout() )
		$class = 'medium-9 cell';

	if( '2c-r' === hybrid_get_theme_layout() )
		$class = 'medium-9 medium-order-2 cell';

	return $class;
}

/**
 * Sets primary sidebar classes depending on layout
 */
function croft_sidebar_classes() {
	if( '2c-l' === hybrid_get_theme_layout() )
		$class = 'medium-3 cell';

	if( '2c-r' === hybrid_get_theme_layout() )
		$class = 'medium-3 medium-order-1 cell';

	return $class;
}
