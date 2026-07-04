<?php
/**
 * Theme support & core feature registration.
 *
 * Declares which WordPress and block-editor features this theme opts into.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register core theme supports.
 *
 * Hooked to `after_setup_theme` so it runs once WordPress is ready but before
 * the first request is rendered.
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_setup() {

	/*
	 * Make the theme available for translation.
	 * Translations live in /languages. Text domain: "spn-cabinets".
	 */
	load_theme_textdomain( 'spn-cabinets', SPN_CABINETS_DIR . '/languages' );

	// Let WordPress manage the document <title> (removes the need for a hard-coded one).
	add_theme_support( 'title-tag' );

	// Enable post thumbnails / featured images across posts, pages and portfolio items.
	add_theme_support( 'post-thumbnails' );

	// Allow a client-managed custom logo (used in the header template part).
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 96,
			'width'       => 300,
			'flex-height' => true,
			'flex-width'  => true,
			'unlink-homepage-logo' => false,
		)
	);

	// Output valid, modern HTML5 markup for core-generated elements.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);

	// Block-editor / front-end alignment support.
	add_theme_support( 'align-wide' );          // Wide & full-width alignments.
	add_theme_support( 'responsive-embeds' );   // Fluid oEmbeds (YouTube, etc.).

	// Load the editor stylesheet so the block editor mirrors the front end.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	// Let core output the standard block styles and inline SVG/duotone as needed.
	add_theme_support( 'wp-block-styles' );

	// Add a couple of nicety supports commonly expected of a modern theme.
	add_theme_support( 'automatic-feed-links' ); // Post/comment RSS discovery links.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Enable Featured Images for a future custom "project" (portfolio) post type
	 * as well. Registering here is harmless if the CPT does not yet exist.
	 */
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'after_setup_theme', 'spn_cabinets_setup' );

/**
 * Set the content width used by oEmbeds and wide images.
 *
 * @since 1.0.0
 * @global int $content_width
 * @return void
 */
function spn_cabinets_content_width() {
	// A sensible default; adjust to match the design's main column once built.
	$GLOBALS['content_width'] = apply_filters( 'spn_cabinets_content_width', 1200 );
}
add_action( 'after_setup_theme', 'spn_cabinets_content_width', 0 );
