<?php
/**
 * SPN Cabinets — Theme bootstrap.
 *
 * This file has ONE job: define a few global constants and load the individual
 * feature modules that live in /inc. It contains no business logic itself so
 * that functionality stays small, testable and easy to locate.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

// Exit if accessed directly — never allow direct execution of theme files.
defined( 'ABSPATH' ) || exit;

/*
 * -----------------------------------------------------------------------------
 * Theme constants
 * -----------------------------------------------------------------------------
 * Centralised so every module can reference the same version, paths and URIs.
 * SPN_CABINETS_VERSION is used as the default asset cache-busting version and
 * should be bumped in style.css (and here, if you prefer) on each release.
 */

if ( ! defined( 'SPN_CABINETS_VERSION' ) ) {
	// Keep this in sync with the "Version" header in style.css.
	define( 'SPN_CABINETS_VERSION', '1.0.0' );
}

if ( ! defined( 'SPN_CABINETS_DIR' ) ) {
	// Absolute server path to the theme directory (no trailing slash).
	define( 'SPN_CABINETS_DIR', get_template_directory() );
}

if ( ! defined( 'SPN_CABINETS_URI' ) ) {
	// Public URL to the theme directory (no trailing slash).
	define( 'SPN_CABINETS_URI', get_template_directory_uri() );
}

/**
 * Load a theme module from the /inc directory.
 *
 * A tiny wrapper around require_once that guards against missing files so a
 * single fat-fingered filename can never white-screen the whole site.
 *
 * @since 1.0.0
 *
 * @param string $relative_path Path relative to the theme root, e.g. "inc/menus.php".
 * @return void
 */
function spn_cabinets_require( $relative_path ) {
	$file = SPN_CABINETS_DIR . '/' . ltrim( $relative_path, '/' );

	if ( is_readable( $file ) ) {
		require_once $file;
	} elseif ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		// Surface the problem loudly in development, silently in production.
		trigger_error( // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error
			esc_html( sprintf( 'SPN Cabinets: missing theme module "%s".', $relative_path ) ),
			E_USER_WARNING
		);
	}
}

/*
 * -----------------------------------------------------------------------------
 * Module loader
 * -----------------------------------------------------------------------------
 * Order matters where there are dependencies:
 *   1. classes  — autoloadable helper classes (e.g. the nav-menu walker).
 *   2. helpers  — small template/utility functions used across templates.
 *   3. features — theme supports, menus, asset enqueuing, cleanup, security.
 */
$spn_cabinets_modules = array(
	// Classes.
	'inc/classes/class-spn-cabinets-walker-nav-menu.php',

	// Helpers.
	'inc/helpers/icons.php',
	'inc/helpers/site-options.php',
	'inc/helpers/template-helpers.php',

	// Feature modules.
	'inc/theme-support.php',
	'inc/menus.php',
	'inc/post-types.php',
	'inc/enqueue-assets.php',
	'inc/cleanup.php',
	'inc/security.php',
	'inc/form-handlers.php',
);

foreach ( $spn_cabinets_modules as $spn_cabinets_module ) {
	spn_cabinets_require( $spn_cabinets_module );
}
unset( $spn_cabinets_module );
