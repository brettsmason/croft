<?php
/**
 * Croft Theme Customizer.
 */

function croft_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	$wp_customize->add_setting( 'display_tagline', array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'croft_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'display_tagline', array(
		'label'    => __( 'Display Tagline?', 'croft' ),
		'type'     => 'checkbox',
		'section'  => 'title_tagline',
		'priority' => 10
	) );
}
add_action( 'customize_register', 'croft_customize_register' );


/**
 * Santizes the values of multiple checkbox field.
 */
function croft_sanitize_checkbox_multiple( $values ) {
    $multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;
    return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}

/**
 * Single checkbox sanitization.
 */
function croft_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function croft_customize_preview_js() {
	wp_enqueue_script( 'croft_customizer', trailingslashit( get_template_directory_uri() ) . 'assets/js/customizer.js', array( 'jquery', 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'croft_customize_preview_js' );
