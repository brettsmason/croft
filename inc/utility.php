<?php

/**
 * A custom menu walker for the Foundation menu structure.
 */
class Foundation_Menu_Walker extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = Array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"menu submenu\">\n";
	}
}

/**
 * Change .sticky class for sticky posts.
 *
 * @param array $classes
 *
 * @return array
 */
function croft_sticky_class( $classes ) {
	if ( ( $key = array_search( 'sticky', $classes ) ) !== false ) {
		unset( $classes[$key] );
		$classes[] = 'sticky-post';
	}
	return $classes;
}
add_filter( 'post_class', 'croft_sticky_class', 20 );

/**
 * Change [...] to ... with added screen reader text.
 */
function croft_excerpt_more() {
	/* Translators: The %s is the post title shown to screen readers. */
	$text = '<span class="screen-reader-text">' . sprintf( esc_attr__( 'Continue reading %s', 'croft' ), get_the_title() ) . '</span>';
	$more = sprintf( ' <a href="%s" class="more-link">&hellip; %s</a>', esc_url( get_permalink() ), $text );
	return $more;
}
add_filter( 'excerpt_more', 'croft_excerpt_more' );

/**
 * Change the markup of password protected post form.
 * Adds a wrapper around the fields for easier styling.
 */
function croft_entry_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );

	$form  = '<form class="post-password-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
	$form .= '<p>' . __( 'This content is password protected. To view it please enter your password below:', 'croft' ) . '</p>';
	$form .= '<div class="field-wrap">';
	$form .= '<label for="' . $label . '"><input name="post_password" id="' . $label . '" type="password" placeholder="Password" /></label>';
	$form .= '<input type="submit" name="Submit" value="' . esc_attr__( "Submit", 'croft' ) . '" />';
	$form .= '</div>';
	$form .= '</form>';
    return $form;
}
add_filter( 'the_password_form', 'croft_entry_password_form' );

/**
 * Additional Widgets Classes
 *
 * @param $params
 *
 * @return mixed
 */
function croft_widget_classes( $params ) {

	/* Global a counter array */
	global $croft_widget_num;

	/* Get the id for the current sidebar we're processing */
	$this_id = $params[0]['id'];

	/* Get registered widgets */
	$arr_registered_widgets = wp_get_sidebars_widgets();

	/* If the counter array doesn't exist, create it */
	if ( !$croft_widget_num ) {
		$croft_widget_num = array();
	}

	/* if current sidebar has no widget, return. */
	if ( !isset( $arr_registered_widgets[$this_id] ) || !is_array( $arr_registered_widgets[$this_id] ) ) {
		return $params;
	}

	/* See if the counter array has an entry for this sidebar */
	if ( isset( $croft_widget_num[$this_id] ) ) {
		$croft_widget_num[$this_id] ++;
	}
	/* If not, create it starting with 1 */
	else {
		$croft_widget_num[$this_id] = 1;
	}

	/* Add a widget number class for additional styling options */
	$class = 'class="widget widget-' . $croft_widget_num[$this_id] . ' ';

	/* in first widget, add 'widget-first' class */
	if ( $croft_widget_num[$this_id] == 1 ) {
		$class .= 'widget-first ';
	}
	/* in last widget, add 'widget-last' class */
	elseif( $croft_widget_num[$this_id] == count( $arr_registered_widgets[$this_id] ) ) {
		$class .= 'widget-last ';
	}

	/* str replace before_widget param with new class */
	$params[0]['before_widget'] = str_replace( 'class="widget ', $class, $params[0]['before_widget'] );

	return $params;
}
add_filter( 'dynamic_sidebar_params', 'croft_widget_classes' );

/**
 * Adds widget number count as a class to the subsidiary widget area container.
 * 
 * @param $attr
 * @param $context
 *
 * @return mixed
 */
function croft_sidebar_subsidiary_class( $attr, $context ) {
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
add_filter( 'hybrid_attr_sidebar', 'croft_sidebar_subsidiary_class', 10, 2 );

/**
 * Filters the custom logo output to include the site name as the alt tag.
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
add_filter( 'get_custom_logo', 'croft_custom_logo_args' );