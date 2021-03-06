<?php
/**
 * Theme basic setup.
 *
 * @package evstrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 1130; /* pixels */
}

add_action( 'after_setup_theme', 'evstrap_setup' );

if ( ! function_exists ( 'evstrap_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function evstrap_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on evstrap, use a find and replace
		 * to change 'evstrap' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'evstrap', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'evstrap' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Adding Thumbnail basic support
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Adding support for Widget edit icons in customizer
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'evstrap_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Logo size
		add_image_size( 'ev-blocks-logo', 300 );

		// Set up the WordPress Theme logo feature.
		add_theme_support( 'custom-logo' );
		/*add_theme_support( 'custom-logo', array(
			'header-text' => array( 'titles-wrap' ),
			'flex-height' => true,
        	'flex-width'  => true,
			'size'        => 'ev-blocks-logo',
		));*/



		// Theme Image Sizes
		// @TODO Add theme image sizes
		// Good reference when ading image sizes https://developer.wordpress.org/reference/functions/add_image_size/
		add_image_size( 'banner-default-fixed-container', 1170, 300, true );
		add_image_size( 'banner-tall-fixed-container', 1170, 550, true );
		add_image_size( 'banner-default-full-container', 1920, 300, true );
		add_image_size( 'banner-tall-full-container', 1920, 550, true );
		add_image_size( 'banner-full-screen', 1920, 1080, true );

		add_image_size( 'thumbnail-no-crop', 150 );
		add_image_size( 'thumbnail-medium', 200, 200, true );

		add_image_size( 'content-small', 540 );
		add_image_size( 'content-medium', 720 );
		add_image_size( 'content-large', 960 );
		add_image_size( 'content-xlarge', 1140 );
		add_image_size( 'content-full', 1920 );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		//add_theme_support( 'editor-styles' );

		// Check and setup theme default settings.
		evstrap_setup_theme_default_settings();

	}
}


add_filter( 'excerpt_more', 'evstrap_custom_excerpt_more' );

if ( ! function_exists( 'evstrap_custom_excerpt_more' ) ) {
	/**
	 * Removes the ... from the excerpt read more link
	 *
	 * @param string $more The excerpt.
	 *
	 * @return string
	 */
	function evstrap_custom_excerpt_more( $more ) {
		if ( ! is_admin() ) {
			$more = '';
		}
		return $more;
	}
}

add_filter( 'wp_trim_excerpt', 'evstrap_all_excerpts_get_more_link' );

if ( ! function_exists( 'evstrap_all_excerpts_get_more_link' ) ) {
	/**
	 * Adds a custom read more link to all excerpts, manually or automatically generated
	 *
	 * @param string $post_excerpt Posts's excerpt.
	 *
	 * @return string
	 */
	function evstrap_all_excerpts_get_more_link( $post_excerpt ) {
		if ( ! is_admin() ) {
			$post_excerpt = $post_excerpt . ' [...]<p><a class="btn btn-secondary evstrap-read-more-link" href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . __( 'Read More...',
			'evstrap' ) . '</a></p>';
		}
		return $post_excerpt;
	}
}
