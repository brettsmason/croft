<?php
/**
 * SVG icon related functions and filters.
 *
 * @package Croft
 */

/**
 * Add SVG definitions to the footer.
 */
function croft_include_svg_icons() {

	// Define SVG sprite file.
	$svg_icons = croft_theme()->asset_path . 'assets/img/svg-icons.svg';

	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		echo file_get_contents( $svg_icons );
	}

}
add_action( 'wp_footer', 'croft_include_svg_icons', 9999 );

/**
 * Return SVG markup.
 *
 * @param string $icon Required. Use the icon filename, e.g. "facebook-square".
 * @param  array  $args {
 *     Parameters needed to display an SVG.
 *
 *     @param string $title Optional. SVG title, e.g. "Facebook".
 *     @param string $desc Optional. SVG description, e.g. "Share this post on Facebook".
 * }
 * @return string SVG markup.
 */
function croft_get_svg( $icon, $args = array() ) {

	// Define an icon.
	if ( false === $icon ) {
		return esc_html__( 'Please define an SVG icon filename.', 'croft' );
	}

	// Make sure $args is an array.
	if ( ! is_array( $args ) ) {
		return esc_html__( 'Please define optional parameters in the form of an array.', 'croft' );
	}

	// Set defaults.
	$defaults = array(
		'title'  => '',
		'desc'   => '',
		'class'  => '',
		'inline' => false
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Sets unique IDs for use by aria-labelledby.
	$title_id = $args['title'] ? uniqid( 'title-' ) : '';
	$desc_id = $args['desc'] ? uniqid( 'desc-' ) : '';

	// Sets SVG title.
	$title = $args['title'] ? '<title id="' . $title_id . '">' . esc_html( $args['title'] ) . '</title>' : '';

	// Sets SVG desc.
	$desc = $args['desc'] ? '<desc id="' . $desc_id . '">' . esc_html( $args['desc'] ) . '</desc>' : '';

	// Set ARIA labelledby.
	if ( $args['title'] && $args['desc'] ) {
		$aria_labelledby = 'aria-labelledby="' . $title_id . ' ' . $desc_id . '"';
	} elseif ( $args['title'] ) {
		$aria_labelledby = 'aria-labelledby="' . $title_id . '"';
	} elseif ( $args['desc'] ) {
		$aria_labelledby = 'aria-labelledby="' . $desc_id . '"';
	} else {
		$aria_labelledby = '';
	}

	// Set ARIA hidden.
	if ( $args['title'] || $args['desc'] ) {
		$aria_hidden = '';
	} else {
		$aria_hidden = 'aria-hidden="true"';
	}

	// Sets icon class.
	$class = $args['class'] ? esc_html( $args['class'] ) : 'icon icon-' . esc_html( $icon );

	// If our SVG is inline.
	if ( true === $args['inline'] ) {

		// Begin SVG markup.
		$svg = file_get_contents( locate_template( 'assets/img/svg-icons/' . esc_html( $icon ) . '.svg' ) );
		
		// Add ARIA hidden, ARIA labeledby and class markup.
		$svg = str_replace( '<svg', '<svg class="' . $class . '"' . $aria_hidden . $aria_labelledby . 'role="img"', $svg );

		if ( $title && $desc ) {

			// Get the intro SVG markup and save as $svg_intro.
			preg_match( '/<svg(.*?)>/', $svg, $svg_intro );

			// Add the title/desc to the markup.
			$svg = str_replace( $svg_intro[0], $svg_intro[0] . $title . $desc, $svg );
		}

	} else { // Otherwise, use our sprite.

		// Begin SVG markup.
		$svg = '<svg class="' . $class . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

		// If there is a title, display it.
		if ( $title ) {
			$svg .= '<title  id="' . $title_id . '">' . esc_html( $args['title'] ) . '</title>';
		}

		// If there is a description, display it.
		if ( $desc ) {
			$svg .= '<desc id="' . $desc_id . '">' . esc_html( $args['desc'] ) . '</desc>';
		}

		// Use absolute path in the Customizer so that icons show up in there.
		if ( is_customize_preview() ) {
			$svg .= '<use xlink:href="' . croft_theme()->asset_uri . 'assets/img/svg-icons.svg' . '#icon-' . esc_html( $icon ) . '"></use>';
		} else {
			$svg .= '<use xlink:href="#icon-' . esc_html( $icon ) . '"></use>';
		}

		$svg .= '</svg>';

	}

	return $svg;
}

/**
 * Display an SVG icon.
 *
 * @param  array $args Parameters needed to display an SVG.
 */
function croft_do_svg( $icon, $args = array() ) {
	echo croft_get_svg( $icon, $args );
}

/**
 * Display SVG icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function croft_nav_menu_social_icons( $item_output, $item, $depth, $args ) {

	// Get supported social icons.
	$social_icons = croft_social_links_icons();

	// Change SVG icon inside social links menu if there is a supported URL.
	if ( 'social' == $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( $args->link_after, '</span>' . croft_get_svg( esc_attr( $value ) ), $item_output );
			}
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'croft_nav_menu_social_icons', 10, 4 );

/**
 * Returns an array of supported social links (URL and icon name).
 *
 * @return array $social_links_icons
 */
function croft_social_links_icons() {

	// Supported social links icons.
	$social_links_icons = array(
		'codepen.io'      => 'codepen',
		'dropbox.com'     => 'dropbox',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'plus.google.com' => 'google-plus',
		'github.com'      => 'github',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin',
		'mailto:'         => 'envelope',
		'pinterest.com'   => 'pinterest',
		'reddit.com'      => 'reddit',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com'      => 'tumblr',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'youtube.com'     => 'youtube',
	);

	return apply_filters( 'croft_social_links_icons', $social_links_icons );
}
