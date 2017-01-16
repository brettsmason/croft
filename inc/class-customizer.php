<?php
/**
 * Handles the theme's theme customizer functionality.
 *
 * @package croft
 */

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @access public
 */
final class Croft_Customize {

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
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'panels'   ) );
		add_action( 'customize_register', array( $this, 'sections' ) );
		add_action( 'customize_register', array( $this, 'settings' ) );
		add_action( 'customize_register', array( $this, 'controls' ) );
		add_action( 'customize_register', array( $this, 'partials' ) );

		// Enqueue scripts and styles for the preview.
		add_action( 'customize_preview_init', array( $this, 'preview_enqueue' ) );
	}

	/**
	 * Sets up the customizer panels.
	 *
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function panels( $manager ) {

		// Example of adding a panel
		/*
		$manager->add_panel(
			'panel_name',
			array(
				'priority' => 5,
				'title'    => __( 'Panel Name', 'croft' )
			)
		);
		*/
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Move theme-specific sections to our theme options panel.
		// $manager->get_section( 'title_tagline' )->panel    = 'theme_options';

		// Example of adding a section
		/*
		$manager->add_section(
			'section_name_here',
			array(
				'panel' => 'panel_name_here',
				'title' => __( 'Name Here', 'croft' )
			)
		);
		*/
	}

	/**
	 * Sets up the customizer settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function settings( $manager ) {

		// Set the transport property of existing settings.
		$manager->get_setting( 'blogname' )->transport              = 'postMessage';
		$manager->get_setting( 'blogdescription' )->transport       = 'postMessage';
		$manager->get_setting( 'background_color' )->transport      = 'postMessage';
		$manager->get_setting( 'background_image' )->transport      = 'postMessage';
		$manager->get_setting( 'background_position_x' )->transport = 'postMessage';
		$manager->get_setting( 'background_repeat' )->transport     = 'postMessage';
		$manager->get_setting( 'background_attachment' )->transport = 'postMessage';
		$manager->get_setting( 'custom_logo' )->transport           = 'refresh';

		// Example setting
		/*
		$manager->add_setting(
			'setting_name',
			array(
				'default' => 'default_value
			)
		);
		*/
	}

	/**
	 * Sets up the customizer controls.
	 *
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function controls( $manager ) {

		// Set the priority of the custom logo control.
		$manager->get_control( 'custom_logo' )->priority = '50';

		// Example control
		/*
		$manager->add_control(
			'control_name',
			array(
				'label'   => esc_html__( 'Control Name', 'croft' ),
				'section' => 'section_name',
				'type'    => 'text'
			)
		);
		*/
	}

	/**
	 * Sets up the customizer partials.
	 *
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function partials( $manager ) {

		$manager->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'            => '.site-title a',
				'render_callback'	  => function() {
					bloginfo( 'name' );
				}
			)
		);

		$manager->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'            => '.site-description',
				'render_callback'	  => function() {
					bloginfo( 'description' );
				}
			)
		);
	}

	/**
	 * Loads theme customizer JavaScript.
	 *
	 * @access public
	 * @return void
	 */
	public function preview_enqueue() {

		wp_enqueue_script( 'croft-customize-preview', Croft_Theme()->asset_uri . 'assets/js/customizer.js', array( 'jquery' ), null, true );
	}
}

// Doing this customizer thang!
Croft_Customize::get_instance();
