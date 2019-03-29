<?php
/**
 * Understrap Theme Customizer
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! function_exists( 'understrap_customize_register' ) ) {
	/**
	 * Register basic customizer support.
	 *
	 * @param object $wp_customize Customizer reference.
	 */
	function understrap_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'understrap_customize_register' );

/**
 * Add Custom Controls
 */
require_once trailingslashit( dirname(__FILE__) ) . 'custom-controls.php';


if ( ! function_exists( 'understrap_theme_customize_register' ) ) {
	/**
	 * Register individual settings through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 */
	function understrap_theme_customize_register( $wp_customize ) {


		/**
		 * Select sanitization function
		 *
		 * @param string               $input   Slug to sanitize.
		 * @param WP_Customize_Setting $setting Setting instance.
		 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
		 */
		function understrap_theme_slug_sanitize_select( $input, $setting ) {

			// Ensure input is a slug (lowercase alphanumeric characters, dashes and underscores are allowed only).
			$input = sanitize_key( $input );

			// Get the list of possible select options.
			$choices = $setting->manager->get_control( $setting->id )->choices;

				// If the input is a valid key, return it; otherwise, return the default.
				return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

		}


		/**
		 * Create Theme Options Panel
		 */
		$wp_customize->add_panel( 'understrap_options', array(
			'title' => __( 'Theme Options' ),
			'description' => __( 'Custom Theme Options', 'understrap' ), // Include html tags such as <p>.
			'priority' => 160, // Mixed with top-level-section hierarchy.
		) );
	

		/**
		 * Theme layout options.
		 */ 
		$wp_customize->add_section(
			'understrap_theme_layout_options',
			array(
				'title'       => __( 'Site Layout Options', 'understrap' ),
				'capability'  => 'edit_theme_options',
				'description' => __( 'Container width and sidebar defaults', 'understrap' ),
				'panel' => 'understrap_options',
			)
		);

			// Container Type
			$wp_customize->add_setting(
				'understrap_container_type',
				array(
					'default'           => 'container',
					'type'              => 'theme_mod',
					'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
					'capability'        => 'edit_theme_options',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'understrap_container_type',
					array(
						'label'       => __( 'Container Width', 'understrap' ),
						'description' => __( 'Choose between Bootstrap\'s container and container-fluid', 'understrap' ),
						'section'     => 'understrap_theme_layout_options',
						'options'    => 'understrap_container_type',
						'type'        => 'select',
						'choices'     => array(
							'container'       => __( 'Fixed width container', 'understrap' ),
							'container-fluid' => __( 'Full width container', 'understrap' ),
						),
						'priority'    => '10',
					)
				)
			);

			//Sidebar Position
			$wp_customize->add_setting(
				'understrap_sidebar_position',
				array(
					'default'           => 'right',
					'type'              => 'theme_mod',
					'sanitize_callback' => 'sanitize_text_field',
					'capability'        => 'edit_theme_options',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'understrap_sidebar_position',
					array(
						'label'             => __( 'Sidebar Positioning', 'understrap' ),
						'description'       => __(
							'Set sidebar\'s default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.',
							'understrap'
						),
						'section'           => 'understrap_theme_layout_options',
						'options'          => 'understrap_sidebar_position',
						'type'              => 'select',
						'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
						'choices'           => array(
							'right' => __( 'Right sidebar', 'understrap' ),
							'left'  => __( 'Left sidebar', 'understrap' ),
							'both'  => __( 'Left & Right sidebars', 'understrap' ),
							'none'  => __( 'No sidebar', 'understrap' ),
						),
						'priority'          => '20',
					)
				)
			);

		/**
		 * BS Navbar Options.
		*/
		$wp_customize->add_section(
			'understrap_theme_navbar_options',
			array(
				'title'       => __( 'Navbar Options', 'understrap' ),
				'capability'  => 'edit_theme_options',
				'description' => __( 'Navbar skin and layout defaults', 'understrap' ),
				'panel' => 'understrap_options',
				//'priority'    => 161,
			)
		);

			// Navbar Poistion
			$wp_customize->add_setting(
				'understrap_navbar_position',
				array(
					'default'           => 'default',
					'type'              => 'theme_mod',
					'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
					'capability'        => 'edit_theme_options',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'understrap_navbar_position',
					array(
						'label'       => __( 'Navbar Position', 'understrap' ),
						'description' => __( 'Choose between Bootstrap\'s static, fixed top, fixed bottom, and sticky top navbar', 'understrap' ),
						'section'     => 'understrap_theme_navbar_options',
						'settings'    => 'understrap_navbar_position',
						'type'        => 'select',
						'choices'     => array(
							'default'       				=> __( 'Default', 'understrap' ),
							'fixed-top'   	=> __( 'Fixed top', 'understrap' ),
							'fixed-bottom' 	=> __( 'Fixed bottom', 'understrap' ),
							'sticky-top' 		=> __( 'Sticky Top', 'understrap' ),
						),
						'priority'    => '10',
					)
				)
			);

			// Navbar Container Width
			$wp_customize->add_setting(
				'understrap_navbar_container',
				array(
					'default'           => 'container',
					'type'              => 'theme_mod',
					'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
					'capability'        => 'edit_theme_options',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'understrap_navbar_container',
					array(
						'label'       => __( 'Navbar Container', 'understrap' ),
						'description' => __( 'Choose between Bootstrap\'s container and container-fluid. See BS docs for <a href="https://getbootstrap.com/docs/4.2/components/navbar/#how-it-works" target="_blank">more details</a>', 'understrap' ),
						'section'     => 'understrap_theme_navbar_options',
						'settings'    => 'understrap_navbar_container',
						'type'        => 'select',
						'choices'     => array(
							'container'       => __( 'Fixed width container', 'understrap' ),
							'container-fluid' => __( 'Full width container', 'understrap' ),
						),
					)
				)
			);

			// Navbar Breakpoint
			$wp_customize->add_setting(
				'understrap_navbar_breakpoint',
				array(
					'default'           => '',
					'type'              => 'theme_mod',
					'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
					'capability'        => 'edit_theme_options',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'understrap_navbar_breakpoint',
					array(
						'label'       => __( 'Navbar Collapse Breakpoint', 'understrap' ),
						'description' => __( 'Choose at which device breakpoint the navbar collapses for mobile display. See BS docs for <a href="https://getbootstrap.com/docs/4.2/components/navbar/#responsive-behaviors" target="_blank">more details</a>', 'understrap' ),
						'section'     => 'understrap_theme_navbar_options',
						'settings'    => 'understrap_navbar_breakpoint',
						'type'        => 'select',
						'choices'     => array(
							'navbar-expand-sm'    => __( 'Small (sm)', 'understrap' ),
							'navbar-expand-md'   	=> __( 'Medium (md)', 'understrap' ),
							'navbar-expand-lg' 		=> __( 'Large (lg)', 'understrap' ),
							'navbar-expand-xl' 		=> __( 'Extra Large (xl)', 'understrap' ),
							'navbar-expand'				=> __( 'Never Collapse', 'understrap' ),
							''										=> __( 'Always Collapse Collapse', 'understrap' ),
						)
					)
				)
			);

			// Navbar Colour scheme
			$wp_customize->add_setting(
				'understrap_navbar_color_scheme',
				array(
					'default'           => '',
					'type'              => 'theme_mod',
					'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
					'capability'        => 'edit_theme_options',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'understrap_navbar_color_scheme',
					array(
						'label'       => __( 'Navbar Color scheme', 'understrap' ),
						'description' => __( 'Choose base colour scheme./n See BS docs for <a href="https://getbootstrap.com/docs/4.2/components/navbar/#color-schemes" target="_blank">more details</a>', 'understrap' ),
						'section'     => 'understrap_theme_navbar_options',
						'settings'    => 'understrap_navbar_color_scheme',
						'type'        => 'select',
						'choices'     => array(
							'navbar-dark'    => __( 'Dark', 'understrap' ),
							'navbar-light'   	=> __( 'Light', 'understrap' ),
						)
					)
				)
			);

			// Navbar background color
			$wp_customize->add_setting(
				'understrap_navbar_bgcolor',
				array(
					'default'           => '',
					'type'              => 'theme_mod',
					'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
					'capability'        => 'edit_theme_options',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'understrap_navbar_bgcolor',
					array(
						'label'       => __( 'Navbar Background Color', 'understrap' ),
						'description' => __( 'Choose Navbar background colour based on theme primary, secondary, dark, and light classes. See BS docs for <a href="https://getbootstrap.com/docs/4.2/components/navbar/#background-colors" target="_blank">more details</a>', 'understrap' ),
						'section'     => 'understrap_theme_navbar_options',
						'settings'    => 'understrap_navbar_bgcolor',
						'type'        => 'select',
						'choices'     => array(
							'bg-primary'    => __( 'Primary Background', 'understrap' ),
							'bg-secondary'   	=> __( 'Secondary Background ', 'understrap' ),
							'bg-light'   	=> __( 'Light Background ', 'understrap' ),
							'bg-dark'   	=> __( 'Dark Background ', 'understrap' ),
							'bg-white'   	=> __( 'White ', 'understrap' ),
							'bg-transparent'   	=> __( 'Transparent', 'understrap' ),
						)
					)
				)
			);

		/**
		* Navbar Features
		**/
		$wp_customize->add_section(
			'understrap_theme_navbar_content',
			array(
				'title'       => __( 'Navbar Features', 'understrap' ),
				'capability'  => 'edit_theme_options',
				'description' => __( 'Navbar featured elements', 'understrap' ),
				'panel' => 'understrap_options',
			)
		);

		$wp_customize->add_setting(
			'understrap_navbar_shortcode',
			array(
				'default'           => '',
				'transport'         => 'refresh',
				//'sanitize_callback' => 'esc_attr',
				//'sanitize_js_callback' => 'esc_html',
			)
		);
		$wp_customize->add_control(
			new Understrap_Sortable_Repeater_Custom_Control(
			$wp_customize,
				'understrap_navbar_shortcode',
				array(
					'label'    		=> esc_html__('Navbar Elements', 'understrap'),
					'description' 	=> esc_html__('Add shortcodes here to add icon link, call-to-action buttons, etc', 'understrap'),
					'settings'		=> 'understrap_navbar_shortcode',
					'section'  		=> 'understrap_theme_navbar_content',
				)
			)
		);


		// Page Header options.
		// $wp_customize->add_section(
		// 	'understrap_theme_header_settings',
		// 	array(
		// 		'title'       => __( 'Page Header Settings', 'understrap' ),
		// 		'capability'  => 'edit_theme_options',
		// 		'description' => __( 'Navbar skin and layout defaults', 'understrap' ),
		// 		'panel' => 'understrap_options',
		// 	)
		// );

		/**
		 * Colour Pallete
		 * * Building palette array 
		 */
		 
		// primary color
		$understrap_color_palette[] = array(
			'slug'=>'understrap_color_primary', 
			'default' => '#7C008C',
			'label' => 'Primary Color'
		);

		// secondary color
		$understrap_color_palette[] = array(
			'slug'=>'understrap_color_secondary', 
			'default' => '#6c757d',
			'label' => 'Secondary Color'
		);

		// info color
		$understrap_color_palette[] = array(
			'slug'=>'understrap_color_info', 
			'default' => '#17a2b8',
			'label' => 'Info Color'
		);

		// warning color
		$understrap_color_palette[] = array(
			'slug'=>'understrap_color_warning', 
			'default' => '#ffc107',
			'label' => 'Warning Color'
		);

		// danger color
		$understrap_color_palette[] = array(
			'slug'=>'understrap_color_danger', 
			'default' => '#dc3545',
			'label' => 'Danger Color'
		);

		/**
		 * Loop through palette aray and define settings and controls for each
		 */ 
		foreach( $understrap_color_palette as $understrap_color_palette ) {
			// SETTINGS
			$wp_customize->add_setting(
					$understrap_color_palette['slug'], array(
							'default' => $understrap_color_palette['default'],
							'type' => 'option', 
							'capability' =>  'edit_theme_options'
					)
			);
			// CONTROLS
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
						$wp_customize,
						$understrap_color_palette['slug'], 
						array('label' => $understrap_color_palette['label'], 
						'section' => 'colors',
						'settings' => $understrap_color_palette['slug'])
				)
			);
		}

	}
} // endif function_exists( 'understrap_theme_customize_register' ).
add_action( 'customize_register', 'understrap_theme_customize_register' );

