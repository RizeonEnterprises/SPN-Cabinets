<?php
/**
 * Front-end form handlers.
 *
 * Native, secure handling of the Free Quote form via admin-post.php. No plugin.
 * Flow: nonce check → honeypot → sanitise → validate → (on error) stash + redirect
 * back with `?status=error`, or (on success) wp_mail() the lead and redirect with
 * `?status=success`.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Handle a Free Quote form submission.
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_handle_quote_submission() {

	// 1. CSRF: verify the nonce (dies on failure).
	check_admin_referer( 'spn_cabinets_quote_submit', 'spn_cabinets_quote_nonce' );

	// 2. Resolve a safe, same-site redirect target (the page the form is on).
	$redirect = isset( $_POST['_redirect'] ) ? esc_url_raw( wp_unslash( $_POST['_redirect'] ) ) : '';
	$redirect = wp_validate_redirect( $redirect, home_url( '/' ) );

	// 3. Honeypot: if the hidden field is filled, it's a bot — feign success.
	if ( ! empty( $_POST['quote_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'status', 'success', $redirect ) . '#quote-form' );
		exit;
	}

	// 4. Sanitise every input aggressively.
	$data = array(
		'name'     => isset( $_POST['quote_name'] ) ? sanitize_text_field( wp_unslash( $_POST['quote_name'] ) ) : '',
		'email'    => isset( $_POST['quote_email'] ) ? sanitize_email( wp_unslash( $_POST['quote_email'] ) ) : '',
		'phone'    => isset( $_POST['quote_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['quote_phone'] ) ) : '',
		'postcode' => isset( $_POST['quote_postcode'] ) ? sanitize_text_field( wp_unslash( $_POST['quote_postcode'] ) ) : '',
		'service'  => isset( $_POST['quote_service'] ) ? sanitize_text_field( wp_unslash( $_POST['quote_service'] ) ) : '',
		'details'  => isset( $_POST['quote_details'] ) ? sanitize_textarea_field( wp_unslash( $_POST['quote_details'] ) ) : '',
	);

	// 5. Server-side validation.
	$services = spn_cabinets_quote_services();
	$errors   = array();

	if ( '' === $data['name'] ) {
		$errors['name'] = __( 'Please enter your full name.', 'spn-cabinets' );
	}

	if ( '' === $data['email'] ) {
		$errors['email'] = __( 'Please enter your email address.', 'spn-cabinets' );
	} elseif ( ! is_email( $data['email'] ) ) {
		$errors['email'] = __( 'Please enter a valid email address.', 'spn-cabinets' );
	}

	if ( '' === $data['phone'] ) {
		$errors['phone'] = __( 'Please enter your phone number.', 'spn-cabinets' );
	}

	if ( '' === $data['postcode'] ) {
		$errors['postcode'] = __( 'Please enter your postcode.', 'spn-cabinets' );
	}

	if ( '' === $data['service'] || ! array_key_exists( $data['service'], $services ) ) {
		$errors['service'] = __( 'Please choose the service you need.', 'spn-cabinets' );
	}

	// 6. On failure: stash errors + values in a short-lived transient, return.
	if ( ! empty( $errors ) ) {
		$token = md5( uniqid( (string) wp_rand(), true ) );
		set_transient(
			'spn_cabinets_quote_err_' . $token,
			array(
				'errors' => $errors,
				'values' => $data,
			),
			5 * MINUTE_IN_SECONDS
		);

		wp_safe_redirect(
			add_query_arg(
				array(
					'status' => 'error',
					'sqf'    => $token,
				),
				$redirect
			) . '#quote-form'
		);
		exit;
	}

	// 7. Success: email the lead to the site's enquiry address.
	$to = spn_cabinets_contact()['email'];
	if ( ! is_email( $to ) ) {
		$to = get_option( 'admin_email' );
	}

	$service_label = isset( $services[ $data['service'] ] ) ? $services[ $data['service'] ] : $data['service'];
	$site_name     = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );

	/* translators: %s: site name. */
	$subject = sprintf( __( '[%s] New Free Quote request', 'spn-cabinets' ), $site_name );

	$body = implode(
		"\n",
		array(
			__( 'A new Free Quote request has been submitted:', 'spn-cabinets' ),
			'',
			sprintf( '%s: %s', __( 'Name', 'spn-cabinets' ), $data['name'] ),
			sprintf( '%s: %s', __( 'Email', 'spn-cabinets' ), $data['email'] ),
			sprintf( '%s: %s', __( 'Phone', 'spn-cabinets' ), $data['phone'] ),
			sprintf( '%s: %s', __( 'Postcode', 'spn-cabinets' ), $data['postcode'] ),
			sprintf( '%s: %s', __( 'Service', 'spn-cabinets' ), $service_label ),
			sprintf(
				'%s: %s',
				__( 'Details', 'spn-cabinets' ),
				'' !== $data['details'] ? $data['details'] : __( '(none)', 'spn-cabinets' )
			),
			'',
			sprintf( '%s: %s', __( 'Submitted from', 'spn-cabinets' ), $redirect ),
		)
	);

	// Let the admin reply straight to the enquirer.
	$headers = array( sprintf( 'Reply-To: %s <%s>', $data['name'], $data['email'] ) );

	wp_mail( $to, $subject, $body, $headers );

	/**
	 * Fires after a valid quote submission — hook here to also store the lead
	 * (e.g. in a custom post type) once that exists.
	 *
	 * @since 1.0.0
	 * @param array $data Sanitised submission data.
	 */
	do_action( 'spn_cabinets_quote_submitted', $data );

	wp_safe_redirect( add_query_arg( 'status', 'success', $redirect ) . '#quote-form' );
	exit;
}
add_action( 'admin_post_nopriv_spn_cabinets_quote', 'spn_cabinets_handle_quote_submission' );
add_action( 'admin_post_spn_cabinets_quote', 'spn_cabinets_handle_quote_submission' );
