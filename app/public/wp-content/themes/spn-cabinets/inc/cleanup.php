<?php
/**
 * Front-end <head> cleanup & performance tidying.
 *
 * Removes markup and requests that WordPress adds by default but that a lean,
 * lead-generation site does not need. Everything here is safe and reversible.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Remove unnecessary tags and links from wp_head().
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_clean_head() {
	// Really Simple Discovery & Windows Live Writer links — legacy, unused.
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// WordPress generator version tag (also handled in security.php).
	remove_action( 'wp_head', 'wp_generator' );

	// Shortlink <link rel="shortlink"> — not needed with pretty permalinks.
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );

	// Adjacent post rel links (prev/next) — often undesirable for SEO control.
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

	// REST API link in <head> (endpoint itself remains available).
	remove_action( 'wp_head', 'rest_output_link_wp_head' );

	// oEmbed discovery links (the oEmbed endpoint still works if needed).
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
}
add_action( 'init', 'spn_cabinets_clean_head' );

/**
 * Disable the emoji detection script and related styles.
 *
 * Modern browsers render emoji natively; the core script is an unnecessary
 * request and inline style block on every page.
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	// Stop the emoji DNS-prefetch hint core adds to resource hints.
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'spn_cabinets_disable_emojis' );

/**
 * Remove the global inline styles core prints for classic widgets.
 *
 * This block-library / classic-theme styling is not used by our custom markup.
 * Remove the lines below if you later rely on core block styles heavily.
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_dequeue_global_styles() {
	// Uncomment if the design does not use core block styling at all:
	// wp_dequeue_style( 'wp-block-library' );
	// wp_dequeue_style( 'wp-block-library-theme' );
	// wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'spn_cabinets_dequeue_global_styles', 100 );

/**
 * Clean up the resource-hint output (e.g. drop the s.w.org emoji prefetch).
 *
 * @since 1.0.0
 *
 * @param array  $hints         URLs to print for the given relation type.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Filtered hints.
 */
function spn_cabinets_resource_hints( $hints, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		$hints = array_filter(
			$hints,
			static function ( $hint ) {
				$url = is_array( $hint ) && isset( $hint['href'] ) ? $hint['href'] : $hint;
				return is_string( $url ) ? false === strpos( $url, 's.w.org' ) : true;
			}
		);
	}

	return $hints;
}
add_filter( 'wp_resource_hints', 'spn_cabinets_resource_hints', 10, 2 );
