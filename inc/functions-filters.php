<?php
/**
 * Various small changes and filters for the theme.
 *
 * @package Croft
 */

# Add site name to alt tag og custom logo.
add_filter( 'get_custom_logo', 'croft_custom_logo_args' );

# Add screen reader to text to end of an excerpt.
add_filter( 'excerpt_more', 'croft_excerpt_more' );

# Change sticky post class.
add_filter( 'post_class', 'croft_sticky_class', 20 );

# Add class to subsidiary sidebar depending on number of widgets.
add_filter( 'hybrid_attr_sidebar', 'croft_sidebar_subsidiary_widget_count', 10, 2 );

# Wrap video embeds in .responsive-embed <div> with optional ratio classes.
add_filter( 'embed_oembed_html', 'croft_maybe_wrap_embed', 10, 2 );
add_filter( 'embed_handler_html', 'croft_maybe_wrap_embed', 10, 2 );

/**
 * Filters the custom logo output to include the site name as the alt tag.
 *
 * @return string
 */
function croft_custom_logo_args() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );

	$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
		esc_url( home_url( '/' ) ),
		wp_get_attachment_image( $custom_logo_id, 'full', false, array(
			'class'    => 'custom-logo',
			'itemprop' => 'logo',
			'alt' => esc_attr( get_bloginfo( 'name' ) ),
		) )
	);

	return $html;
}

/**
 * Change [...] to ... with added screen reader text.
 *
 * @return string
 */
function croft_excerpt_more() {
	/* Translators: The %s is the post title shown to screen readers. */
	$text = '<span class="screen-reader-text">' . sprintf( esc_attr__( 'Continue reading %s', 'croft' ), get_the_title() ) . '</span>';
	$more = sprintf( ' <a href="%s" class="more-link">&hellip; %s</a>', esc_url( get_permalink() ), $text );

	return $more;
}

/**
 * Change .sticky class for sticky posts for compatibility with Foundation.
 *
 * @param array $classes
 * @return array
 */
function croft_sticky_class( $classes ) {

	if ( ( $key = array_search( 'sticky', $classes ) ) !== false ) {
		unset( $classes[$key] );
		$classes[] = 'sticky-post';
	}

	return $classes;
}

/**
 * Adds widget number count as a class to the subsidiary widget area container.
 *
 * @param $attr
 * @param $context
 * @return mixed
 */
function croft_sidebar_subsidiary_widget_count( $attr, $context ) {

	if ( 'subsidiary' === $context ) {
		global $sidebars_widgets;

		if ( is_array( $sidebars_widgets ) && !empty( $sidebars_widgets[ $context ] ) ) {
			$count = count( $sidebars_widgets[ $context ] );

			if ( 1 === $count )
				$attr['class'] .= ' one';
			elseif ( 2 === $count )
				$attr['class'] .= ' two';
			elseif ( 3 === $count )
				$attr['class'] .= ' three';
			elseif ( 4 === $count )
				$attr['class'] .= ' four';
			elseif ( 5 === $count )
				$attr['class'] .= ' five';
			elseif ( 6 === $count )
				$attr['class'] .= ' six';
			}
		}

	return $attr;
}

/**
 * Adds a wrapper to videos.
 *
 * @return string
 */
function croft_wrap_embed_html( $html ) {

    if ( empty( $html ) || ! is_string( $html ) )
        return $html;

    preg_match( '/width=[\'"](.+?)[\'"]/i',  $html, $width_matches );
    preg_match( '/height=[\'"](.+?)[\'"]/i', $html, $height_matches );

    $width  = ! empty( $width_matches )  && isset( $width_matches[1] )  ? absint( $width_matches[1] )  : 0;
    $height = ! empty( $height_matches ) && isset( $height_matches[1] ) ? absint( $height_matches[1] ) : 0;

	$ratio = croft_get_ratio( $width, $height );

    return sprintf( '<div class="responsive-embed%s">%s</div>', $ratio, $html );
}

/**
 * Checks embed URL patterns to see if they should be wrapped in some special HTML, particularly
 * for responsive videos.
 *
 * @return string
 */
function croft_maybe_wrap_embed( $html, $url ) {

	if ( ! $html || ! is_string( $html ) || ! $url )
		return $html;

	$do_wrap = false;

	$patterns = array(
		'#http://((m|www)\.)?youtube\.com/watch.*#i',
		'#https://((m|www)\.)?youtube\.com/watch.*#i',
		'#http://((m|www)\.)?youtube\.com/playlist.*#i',
		'#https://((m|www)\.)?youtube\.com/playlist.*#i',
		'#http://youtu\.be/.*#i',
		'#https://youtu\.be/.*#i',
		'#https?://(.+\.)?vimeo\.com/.*#i',
		'#https?://(www\.)?dailymotion\.com/.*#i',
		'#https?://dai.ly/*#i',
		'#https?://(www\.)?hulu\.com/watch/.*#i',
		'#https?://wordpress.tv/.*#i',
		'#https?://(www\.)?funnyordie\.com/videos/.*#i',
		'#https?://vine.co/v/.*#i',
		'#https?://(www\.)?collegehumor\.com/video/.*#i',
		'#https?://(www\.|embed\.)?ted\.com/talks/.*#i'
	);

	$patterns = apply_filters( 'croft_maybe_wrap_embed_patterns', $patterns );

	foreach ( $patterns as $pattern ) {
		$do_wrap = preg_match( $pattern, $url );
		
		if ( $do_wrap )
			return croft_wrap_embed_html( $html );
	}

	return $html;
}

/**
 * Utility function for adding a class to embeds, depending on the ratio of the embed.
 *
 * @return string
 */
function croft_get_ratio( $width, $height ) {

    $ratio = '';

	$calc = array(
        ' widescreen' => array( 'w' => 16,  'h' => 9  ),
        ' panorama'   => array( 'w' => 256, 'h' => 81 )
    );

	$calc = apply_filters( 'croft_embed_ratios', $calc );

    foreach ( $calc as $name => $dim ) {

        if ( ( $width / $dim['w'] * $dim['h'] ) == $height ) {

            $ratio = $name;
            break;
        }
    }

    return $ratio;
}

/**
 * Filter the submenu (<ul>) element to add Foundation specific classes.
 *
 * @return array
 */
function croft_nav_menu_submenu_css_class( $classes ) {
	$classes[] = 'menu vertical';

	return $classes;
}
add_filter( 'nav_menu_submenu_css_class', 'croft_nav_menu_submenu_css_class' );