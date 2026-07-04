<?php
/**
 * Front-end & editor asset registration.
 *
 * Handles enqueuing of stylesheets and scripts with automatic, file-based
 * cache-busting so browsers only re-download an asset when it actually changes.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Build a cache-busting version string for a theme asset.
 *
 * Uses the file's last-modified time in development-friendly fashion: whenever
 * the file changes, the version changes, so the browser fetches the new copy.
 * Falls back to the theme version if the file cannot be read.
 *
 * @since 1.0.0
 *
 * @param string $relative_path Path to the asset relative to the theme root.
 * @return string Version string suitable for wp_enqueue_* `$ver`.
 */
function spn_cabinets_asset_version( $relative_path ) {
	$absolute = SPN_CABINETS_DIR . '/' . ltrim( $relative_path, '/' );

	if ( file_exists( $absolute ) ) {
		return (string) filemtime( $absolute );
	}

	return SPN_CABINETS_VERSION;
}

/**
 * Return the public URL for a theme asset.
 *
 * @since 1.0.0
 *
 * @param string $relative_path Path to the asset relative to the theme root.
 * @return string Fully-qualified asset URL.
 */
function spn_cabinets_asset_uri( $relative_path ) {
	return SPN_CABINETS_URI . '/' . ltrim( $relative_path, '/' );
}

/**
 * Enqueue front-end styles and scripts.
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_enqueue_assets() {

	/*
	 * -------------------------------------------------------------------------
	 * Styles
	 * -------------------------------------------------------------------------
	 * A single, well-organised main.css keeps the front end to one render-
	 * blocking request. See README.md for the internal CSS layering.
	 */
	$main_css = 'assets/css/main.css';
	wp_enqueue_style(
		'spn-cabinets-main',
		spn_cabinets_asset_uri( $main_css ),
		array(),
		spn_cabinets_asset_version( $main_css ),
		'all'
	);

	/*
	 * -------------------------------------------------------------------------
	 * Scripts
	 * -------------------------------------------------------------------------
	 * All scripts load in the footer and use `defer` (added via the filter
	 * below) so they never block rendering. No jQuery dependency.
	 */

	// Accessible navigation (mobile toggle, submenu handling, focus management).
	$navigation_js = 'assets/js/navigation.js';
	wp_enqueue_script(
		'spn-cabinets-navigation',
		spn_cabinets_asset_uri( $navigation_js ),
		array(),
		spn_cabinets_asset_version( $navigation_js ),
		true
	);

	// General site interactions.
	$main_js = 'assets/js/main.js';
	wp_enqueue_script(
		'spn-cabinets-main',
		spn_cabinets_asset_uri( $main_js ),
		array(),
		spn_cabinets_asset_version( $main_js ),
		true
	);

	/*
	 * Expose a small, safe data object to JS (URLs, nonces, i18n strings).
	 * Extend `spn_cabinets_script_data` via the filter as features are added.
	 */
	wp_localize_script(
		'spn-cabinets-main',
		'spnCabinets',
		apply_filters(
			'spn_cabinets_script_data',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'restUrl' => esc_url_raw( rest_url() ),
				'nonce'   => wp_create_nonce( 'spn_cabinets_nonce' ),
			)
		)
	);

	// Threaded-comment support only where needed.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'spn_cabinets_enqueue_assets' );

/**
 * Add `defer` to the theme's own front-end scripts.
 *
 * Uses the core script-loader filter so we never hand-write <script> tags.
 *
 * @since 1.0.0
 *
 * @param string $tag    The full <script> HTML tag.
 * @param string $handle The script's registered handle.
 * @return string Possibly-modified tag.
 */
function spn_cabinets_defer_scripts( $tag, $handle ) {
	$deferred = array(
		'spn-cabinets-navigation',
		'spn-cabinets-main',
	);

	if ( in_array( $handle, $deferred, true ) && false === strpos( $tag, ' defer' ) ) {
		$tag = str_replace( ' src=', ' defer src=', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'spn_cabinets_defer_scripts', 10, 2 );

/**
 * Print the "JavaScript is available" flag as early as possible.
 *
 * Adds a `js` class to <html> before first paint so CSS can present the
 * JS-enhanced header (mobile toggle + off-canvas) with no layout shift, while
 * no-JS users keep the inline navigation fallback. This is the single
 * sanctioned inline script — it contains no dynamic/PHP data (see CLAUDE.md §7).
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_js_detection() {
	echo "<script>document.documentElement.classList.add('js');</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static PE flag, no dynamic data.
}
add_action( 'wp_head', 'spn_cabinets_js_detection', 2 );

/**
 * Enqueue assets for the block editor (Gutenberg).
 *
 * The front-end editor styles are already registered via add_editor_style()
 * in theme-support.php; this hook is reserved for editor-only JS or additional
 * editor styling that should not load on the front end.
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_enqueue_editor_assets() {
	// Reserved for future editor-only assets (custom block styles, formats, etc.).
}
add_action( 'enqueue_block_editor_assets', 'spn_cabinets_enqueue_editor_assets' );
