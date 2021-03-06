<?php
/**
 * Custom header setup.
 *
 * @package evstrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'after_setup_theme', 'evstrap_custom_header_setup' );

if ( ! function_exists( 'evstrap_custom_header_setup' ) ) {
	function evstrap_custom_header_setup() {

		/**
		 * Filter evStrap custom-header support arguments.
		 *
		 * @since evStrap 0.5.2
		 *
		 * @param array $args {
		 *     An array of custom-header support arguments.
		 *
		 *     @type string $default-image          Default image of the header.
		 *     @type string $default_text_color     Default color of the header text.
		 *     @type int    $width                  Width in pixels of the custom header image. Default 954.
		 *     @type int    $height                 Height in pixels of the custom header image. Default 1300.
		 *     @type string $wp-head-callback       Callback function used to styles the header image and text
		 *                                          displayed on the blog.
		 *     @type string $flex-height            Flex support for height of header.
		 * }
		 */
		add_theme_support(
			'custom-header',
			apply_filters(
				'evstrap_custom_header_args',
				array(
					'default-image' => get_parent_theme_file_uri( '/img/header.jpg' ),
					'default-text-color'     => '000000',
					'width'         => 1920,
					'height'        => 550,
					'flex-height'   => true,
					'uploads'       => true,
					'wp-head-callback' => 'evstrap_header_style',
				)
			)
		);

		register_default_headers(
			array(
				'default-image' => array(
					'url'           => '%s/img/header.jpg',
					'thumbnail_url' => '%s/img/header.jpg',
					'description'   => __( 'Default Header Image', 'evstrap' ),
				),
			)
		);


	}
}
