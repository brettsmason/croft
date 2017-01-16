<?php
/**
 * A custom menu walker for the Foundation menu structure.
 */
class Foundation_Menu_Walker extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = Array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"menu vertical submenu\">\n";
	}
}
