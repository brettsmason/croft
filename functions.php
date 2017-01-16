<?php
/**
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Croft
 * @author     Brett Mason <brettsmason@gmail.com>
 * @copyright  Copyright (c) 2017, Brett Mason
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Singleton class for launching the theme and setup configuration.
 *
 * @since  1.0.0
 * @access public
 */
final class Croft_Theme {

	/**
	 * Directory path to the theme folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_path = '';

	/**
	 * Directory URI to the theme folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_uri = '';

	/**
	 * Asset URI to the theme folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $asset_uri = '';

	/**
	 * Asset Path to the theme folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $asset_path = '';

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup();
			$instance->includes();
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Initial theme setup.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup() {

		$this->dir_path   = trailingslashit( get_template_directory() );
		$this->dir_uri    = trailingslashit( get_template_directory_uri() );
		$this->asset_uri  = trailingslashit( get_theme_file_uri() );
		$this->asset_path = trailingslashit( get_theme_file_path() );

		define( 'HYBRID_DIR', $this->dir_path . 'inc/hybrid-core/' );
		define( 'HYBRID_URI', $this->dir_uri . 'inc/hybrid-core/' );
	}

	/**
	 * Loads include and admin files for the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function includes() {

		// Load the Hybrid Core framework and theme files.
		require_once( $this->dir_path . 'inc/hybrid-core/hybrid.php' );

		// Load theme includes.
		require_once( $this->dir_path . 'inc/customizer.php' );
		require_once( $this->dir_path . 'inc/hc-overrides.php' );
		require_once( $this->dir_path . 'inc/functions-filters.php' );
		require_once( $this->dir_path . 'inc/functions-icons.php' );

		// Load WooCommerce file if plugin is active.
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
			require_once( $this->dir_path . 'inc/functions-woocommerce.php' );

		// Launch the Hybrid Core framework.
		new Hybrid();
	}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Theme setup.
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ),  5 );
		add_action( 'after_setup_theme', array( $this, 'custom_background_setup' ), 15 );

		// Register menus.
		add_action( 'init', array( $this, 'register_menus' ) );

		// Register sidebars.
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );

		// Register image sizes.
		add_action( 'init', array( $this, 'register_image_sizes' ) );

		// Register layouts.
		add_action( 'hybrid_register_layouts', array( $this, 'register_layouts' ) );

		// Register scripts, styles, and fonts.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 5 );
		add_action( 'admin_init', array( $this, 'register_editor_style' ), 5 );
	}

	/**
	 * The theme setup function.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function theme_setup() {

		// Theme layouts.
		add_theme_support( 'theme-layouts', array( 'default' => is_rtl() ? '2c-r' :'2c-l' ) );

		// Breadcrumbs.
		add_theme_support( 'breadcrumb-trail' );

		// Template hierarchy.
		add_theme_support( 'hybrid-core-template-hierarchy' );

		// The best thumbnail/image script ever.
		add_theme_support( 'get-the-image' );

		// Nicer [gallery] shortcode implementation.
		add_theme_support( 'cleaner-gallery' );

		// Automatically add feed links to `<head>`.
		add_theme_support( 'automatic-feed-links' );

		// Post formats.
		add_theme_support(
			'post-formats',
			array( 'image', 'gallery', 'video' )
		);

		// Site logo.
		add_theme_support(
			'custom-logo',
			array(
				'width'       => 300,
				'height'      => 200,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// Widget selective refresh.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// WooCommerce plugin.
		add_theme_support( 'woocommerce' );

		// Handle content width for embeds and images.
		hybrid_set_content_width( 1200 );
	}

	/**
	 * Adds support for the WordPress 'custom-background' theme feature.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function custom_background_setup() {

		add_theme_support(
			'custom-background',
			array(
				'default-color' => 'ffffff'
			)
		);
	}

	/**
	 * Registers nav menus.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_menus() {

		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'croft' ),
			'social'  => esc_html__( 'Social',  'croft' )
		) );
	}

	/**
	 * Registers sidebars.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_sidebars() {

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

	/**
	 * Registers image sizes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_image_sizes() {

		// Set post thumbnail size.
		set_post_thumbnail_size( 240, 135, true );

		// New image sizes.
		add_image_size( 'croft-landscape', 750, 422, true );
	}

	/**
	 * Registers layouts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_layouts() {

		hybrid_register_layout(
			'full-width',
			array(
				'label' => esc_html__( 'Full Width', 'croft' ),
				'image' => $this->dir_uri . 'assets/img/layouts/full-width.svg'
			)
		);

		hybrid_register_layout(
			'1c',
			array(
				'label' => esc_html__( '1 Column', 'croft' ),
				'image' => $this->dir_uri . 'assets/img/layouts/1c.svg'
			)
		);

		hybrid_register_layout(
			'2c-l',
			array(
				'label' => esc_html__( 'Content / Sidebar', 'croft' ),
				'image' => $this->dir_uri . 'assets/img/layouts/2c-l.svg'
			)
		);

		hybrid_register_layout(
			'2c-r',
			array(
				'label' => esc_html__( 'Sidebar / Content', 'croft' ),
				'image' => $this->dir_uri . 'assets/img/layouts/2c-r.svg'
			)
		);
	}

	/**
	 * Registers scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_scripts() {

		$suffix = hybrid_get_min_suffix();

		// Register scripts.
		wp_enqueue_script( 'theme-js', $this->asset_uri . "assets/js/theme{$suffix}.js", array( 'jquery' ), null, true );

		// Register fonts.
		// wp_enqueue_style( 'croft-fonts', '//fonts.googleapis.com/css?family=Montserrat|Istok+Web' );

		// Load parent theme stylesheet if child theme is active.
		if ( is_child_theme() )
			wp_enqueue_style( 'hybrid-parent' );

		// Load active theme stylesheet.
		wp_enqueue_style( 'hybrid-style' );
	}

	/**
	 * Registers scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_editor_style() {

		$suffix = hybrid_get_min_suffix();

		$editor_styles = array(
			$this->asset_uri . "assets/css/editor-style{$suffix}.js"
		);

		// Add the editor stylesheet.
		add_editor_style( $editor_styles );
	}
}

/**
 * Gets the instance of the `Croft_Theme` class. This function is useful for quickly grabbing data
 * used throughout the theme.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function Croft_Theme() {
	return Croft_Theme::get_instance();
}

// Go go go!
Croft_Theme();