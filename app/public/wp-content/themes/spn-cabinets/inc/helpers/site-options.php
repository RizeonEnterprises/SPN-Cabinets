<?php
/**
 * Global site options & contact details.
 *
 * A single, filterable source of truth for the business contact details, the
 * global CTA and the announcement bar. The header AND footer both read from
 * here, so values are never duplicated in markup.
 *
 * All values are PLACEHOLDERS for now. They will later be populated from ACF /
 * the Customizer by hooking the matching filters — no template changes needed.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Business contact details.
 *
 * @since 1.0.0
 * @return array {
 *     @type string $phone         Raw phone (digits) used to build the tel: link.
 *     @type string $phone_display Formatted phone for display. Falls back to $phone.
 *     @type string $email         Email address.
 *     @type string $whatsapp      WhatsApp number in international digits, e.g. "441234567890".
 *     @type string $address       Full postal address (single line or with commas).
 * }
 */
function spn_cabinets_contact() {
	return apply_filters(
		'spn_cabinets_contact',
		array(
			'phone'         => '07956084290',           // Raw — builds the tel: link.
			'phone_display' => '07956 084 290',         // Formatted for display.
			'email'         => 'spncabinets@yahoo.co.uk',
			'whatsapp'      => '',                       // Not supplied yet (the mobile could double as WhatsApp).
			'address'       => '',                       // Not supplied yet.
		)
	);
}

/**
 * Global call-to-action (used by the header, and reusable elsewhere).
 *
 * @since 1.0.0
 * @return array { @type string $label; @type string $url; }
 */
function spn_cabinets_cta() {
	return apply_filters(
		'spn_cabinets_cta',
		array(
			'label' => __( 'Free Quote', 'spn-cabinets' ),
			'url'   => home_url( '/contact/' ),
		)
	);
}

/**
 * Announcement bar configuration. DISABLED by default.
 *
 * @since 1.0.0
 * @return array {
 *     @type bool   $enabled Whether to render the bar. Default false.
 *     @type string $text    Announcement text.
 *     @type string $url     Optional link URL.
 *     @type string $link_label Optional link label.
 * }
 */
function spn_cabinets_announcement() {
	return apply_filters(
		'spn_cabinets_announcement',
		array(
			'enabled'    => false, // Off by default — enable via the filter.
			'text'       => '',
			'url'        => '',
			'link_label' => '',
		)
	);
}

/**
 * The Free Quote form's "Service required" options.
 *
 * Shared by the form (renders the <select>) and the handler (validates the
 * submitted value against these keys), so the two can never drift. Filterable.
 *
 * @since 1.0.0
 * @return array Map of value => label.
 */
function spn_cabinets_quote_services() {
	return apply_filters(
		'spn_cabinets_quote_services',
		array(
			'kitchen-installation' => __( 'Kitchen Installation', 'spn-cabinets' ),
			'bedroom-fitting'      => __( 'Bedroom Fitting', 'spn-cabinets' ),
			'bespoke-cabinets'     => __( 'Bespoke Cabinets', 'spn-cabinets' ),
			'other'                => __( 'Other', 'spn-cabinets' ),
		)
	);
}

/**
 * Build a safe `tel:` href from a phone string.
 *
 * @since 1.0.0
 * @param string $phone Raw phone string.
 * @return string tel: URI (digits + leading +), or '' if none.
 */
function spn_cabinets_tel_href( $phone ) {
	$digits = preg_replace( '/[^0-9+]/', '', (string) $phone );
	return $digits ? 'tel:' . $digits : '';
}

/**
 * Build a safe wa.me href from a WhatsApp number.
 *
 * @since 1.0.0
 * @param string $number International WhatsApp number.
 * @return string https://wa.me/... URL, or '' if none.
 */
function spn_cabinets_whatsapp_href( $number ) {
	$digits = preg_replace( '/[^0-9]/', '', (string) $number );
	return $digits ? 'https://wa.me/' . $digits : '';
}

/**
 * Render a single contact item (phone / email / whatsapp / address).
 *
 * Outputs an accessible link when a value is configured, otherwise a
 * non-interactive placeholder (so the shell has no dead links). The visible
 * label falls back to a generic placeholder string until real values exist.
 *
 * @since 1.0.0
 *
 * @param string $type One of: phone, email, whatsapp, address.
 * @param array  $args {
 *     Optional.
 *     @type string $class     Extra class(es) for the item.
 *     @type bool   $show_icon Whether to render the leading icon. Default true.
 * }
 * @return void
 */
function spn_cabinets_contact_item( $type, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'class'     => '',
			'show_icon' => true,
		)
	);

	$contact = spn_cabinets_contact();

	// Map each type to its value, href, icon and placeholder label.
	$map = array(
		'phone'    => array(
			// Show the formatted number; fall back to the raw one. The tel: link
			// always uses the raw digits.
			'value'       => '' !== trim( (string) ( $contact['phone_display'] ?? '' ) ) ? $contact['phone_display'] : ( $contact['phone'] ?? '' ),
			'href'        => spn_cabinets_tel_href( $contact['phone'] ?? '' ),
			'icon'        => 'phone',
			'placeholder' => __( 'Phone Number', 'spn-cabinets' ),
		),
		'email'    => array(
			'value'       => $contact['email'],
			'href'        => $contact['email'] ? 'mailto:' . sanitize_email( $contact['email'] ) : '',
			'icon'        => 'mail',
			'placeholder' => __( 'Email Address', 'spn-cabinets' ),
		),
		'whatsapp' => array(
			'value'       => $contact['whatsapp'],
			'href'        => spn_cabinets_whatsapp_href( $contact['whatsapp'] ),
			'icon'        => 'whatsapp',
			'placeholder' => __( 'WhatsApp', 'spn-cabinets' ),
		),
		'address'  => array(
			'value'       => $contact['address'],
			'href'        => '', // Addresses render as text, not links.
			'icon'        => 'map-pin',
			'placeholder' => __( 'Business address', 'spn-cabinets' ),
		),
	);

	if ( ! isset( $map[ $type ] ) ) {
		return;
	}

	$item      = $map[ $type ];
	$has_value = '' !== trim( (string) $item['value'] );
	$label     = $has_value ? $item['value'] : $item['placeholder'];
	$class     = trim( 'contact-item contact-item--' . $type . ' ' . $args['class'] . ( $has_value ? '' : ' is-placeholder' ) );
	$is_link   = $has_value && $item['href'];
	$tag       = $is_link ? 'a' : 'span';

	echo '<span class="contact-item__wrap">'; // wrapper kept minimal for styling hooks.

	// Opening tag (link when a real value exists, otherwise a plain span).
	if ( $is_link ) {
		// WhatsApp opens the chat in a new tab.
		$rel = ( 'whatsapp' === $type ) ? ' target="_blank" rel="noopener noreferrer"' : '';
		printf(
			'<a class="%1$s" href="%2$s"%3$s>',
			esc_attr( $class ),
			esc_url( $item['href'] ),
			$rel // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static string.
		);
	} else {
		printf( '<span class="%1$s">', esc_attr( $class ) );
	}

	// Icon (trusted static SVG) + label (escaped).
	if ( $args['show_icon'] ) {
		spn_cabinets_the_icon( $item['icon'], array( 'class' => 'contact-item__icon' ) );
	}
	printf( '<span class="contact-item__text">%s</span>', esc_html( $label ) );

	echo '</' . esc_html( $tag ) . '>';
	echo '</span>';
}
