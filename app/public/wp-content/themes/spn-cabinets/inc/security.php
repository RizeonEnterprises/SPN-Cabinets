<?php
/**
 * Sensible, theme-level security hardening.
 *
 * These are conservative, non-destructive tweaks appropriate for a brochure /
 * lead-generation site. Anything that could break editor or REST functionality
 * for legitimate users is deliberately avoided.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hide the WordPress version from the front end.
 *
 * Prevents version fingerprinting via the <meta name="generator"> tag and from
 * enqueued asset query strings.
 *
 * @since 1.0.0
 * @return string Always an empty string.
 */
function spn_cabinets_remove_version() {
	return '';
}
add_filter( 'the_generator', 'spn_cabinets_remove_version' );

/**
 * Strip the WordPress version query arg from core asset URLs.
 *
 * Only targets versions that match the current core version so our own
 * file-time cache-busting versions are left untouched.
 *
 * @since 1.0.0
 *
 * @param string $src The source URL of the enqueued style/script.
 * @return string Possibly-cleaned URL.
 */
function spn_cabinets_remove_version_query_arg( $src ) {
	if ( $src && false !== strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) {
		$src = remove_query_arg( 'ver', $src );
	}

	return $src;
}
add_filter( 'style_loader_src', 'spn_cabinets_remove_version_query_arg', 9999 );
add_filter( 'script_loader_src', 'spn_cabinets_remove_version_query_arg', 9999 );

/**
 * Disable XML-RPC.
 *
 * XML-RPC is a common brute-force and DDoS vector and is not needed by this
 * site (no remote publishing / Jetpack dependency). Remove this filter if a
 * future integration requires XML-RPC.
 *
 * @since 1.0.0
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Remove XML-RPC and Windows Live Writer discovery headers.
 *
 * @since 1.0.0
 *
 * @param array $headers Associative array of response headers.
 * @return array Filtered headers.
 */
function spn_cabinets_remove_xmlrpc_headers( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
}
add_filter( 'wp_headers', 'spn_cabinets_remove_xmlrpc_headers' );

/**
 * Disable the REST API user endpoints for unauthenticated requests.
 *
 * Blocks anonymous enumeration of usernames via /wp-json/wp/v2/users while
 * leaving the endpoint fully available to logged-in users and the editor.
 *
 * @since 1.0.0
 *
 * @param WP_REST_Response|WP_HTTP_Response|WP_Error|mixed $response Result to send.
 * @param array                                            $handler  Route handler.
 * @param WP_REST_Request                                  $request  Request used.
 * @return mixed|WP_Error The response, or a WP_Error for blocked requests.
 */
function spn_cabinets_restrict_user_endpoint( $response, $handler, $request ) {
	$route = $request->get_route();

	if ( ! is_user_logged_in() && preg_match( '#^/wp/v2/users#', $route ) ) {
		return new WP_Error(
			'rest_user_cannot_view',
			__( 'Sorry, you are not allowed to list users.', 'spn-cabinets' ),
			array( 'status' => rest_authorization_required_code() )
		);
	}

	return $response;
}
add_filter( 'rest_request_before_callbacks', 'spn_cabinets_restrict_user_endpoint', 10, 3 );

/**
 * Send a small set of hardening HTTP headers on front-end requests.
 *
 * NOTE: Content-Security-Policy is intentionally omitted here — it must be
 * tailored to the final asset/plugin set and is best set at the server level.
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_security_headers() {
	if ( is_admin() ) {
		return;
	}

	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
}
add_action( 'send_headers', 'spn_cabinets_security_headers' );
