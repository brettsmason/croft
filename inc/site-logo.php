<?php
/**
 * Register Customizer logo control
 *
 * @param WP_Customize_Manager $wp_customize
 */
function croft_logo_customize_register( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_setting( 'logo', array(
			'type'              => 'theme_mod',
			'transport'         => 'refresh',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_html',
	) );

	// Add Control (WordPress 4.3 cropped image control)
	if ( class_exists( 'WP_Customize_Cropped_Image_Control' ) ) {
		$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'logo', array(
			'section'     => 'title_tagline',
			'label'       => __( 'Logo', 'croft' ),
			'flex_width'  => true,
			'flex_height' => true,
			'width'       => 300,
			'height'      => 200,
			'priority' => 20
		) ) );
	}

	// Add Control (WordPress 4.2 standard image control)
	elseif( class_exists( 'WP_Customize_Media_Control' ) ) {
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
			'section' => 'title_tagline',
			'label'   => __( 'Logo', 'croft' ),
			'width'   => 300,
			'height'  => 200,
			'priority' => 20
		) ) );
	}
}
add_action( 'customize_register', 'croft_logo_customize_register' );

/**
 * Return the logo attributes if set.
 * $size: supply a WordPress image size name.
 * $return: 0: image URL  1: image width  2: image height.
 * 
 * @param string $size
 * @param string $attr
 *
 * @return bool
 */
function croft_get_site_logo( $size = 'full', $attr = '0' ) {
	if( current_theme_supports( 'croft-logo' ) && get_theme_mod( 'logo' ) ) {
		$image = wp_get_attachment_image_src( absint( get_theme_mod( 'logo' ) ), $size );
		if( $image ) {
            return $image[$attr];
        }
        /* Attachment doesn't exist */
        else {
            return false;
        }
	}
}

/**
 * Outputs the site logo.
 */
function croft_site_logo() {
	echo '<h1 ' . hybrid_get_attr( 'site-title' ) . '><a href="' . esc_url( home_url() ) . '" rel="home"><img class="site-logo" src="' . croft_get_site_logo() . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" /></a></h1>';
}
