<?php
/**
 * Inline SVG icon system.
 *
 * Icons are inline SVG (no icon font, no external library) so they scale with
 * text via `em`, inherit `currentColor`, and add zero extra requests. Decorative
 * by default (aria-hidden); pass a `title` to give an icon an accessible name.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return the raw SVG markup for a named icon.
 *
 * @since 1.0.0
 *
 * @param string $name Icon slug (menu, close, chevron-down, phone, mail,
 *                     whatsapp, map-pin, arrow-right).
 * @param array  $args {
 *     Optional.
 *
 *     @type string $class Extra class(es) for the <svg>. Default ''.
 *     @type string $title Accessible name. If set, icon is exposed to AT.
 *     @type int    $size  Pixel size hint (width/height). Default 24.
 * }
 * @return string SVG markup, or empty string if the icon is unknown.
 */
function spn_cabinets_icon( $name, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'class' => '',
			'title' => '',
			'size'  => 24,
		)
	);

	// viewBox 0 0 24 24, stroke-based (feather-style) unless noted.
	$paths = array(
		'menu'         => '<line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>',
		'close'        => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
		'chevron-down' => '<polyline points="6 9 12 15 18 9"/>',
		'phone'        => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.94.36 1.86.68 2.75a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.89.32 1.81.55 2.75.68A2 2 0 0 1 22 16.92z"/>',
		'mail'         => '<rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="22 6 12 13 2 6"/>',
		'map-pin'      => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
		'arrow-right'  => '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
		// WhatsApp is a filled brand glyph (no stroke).
		'whatsapp'     => '<path d="M17.5 14.4c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.06 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.22 1.36.19 1.87.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z"/><path d="M12 2a10 10 0 0 0-8.5 15.28L2 22l4.83-1.47A10 10 0 1 0 12 2zm0 18.2a8.2 8.2 0 0 1-4.18-1.15l-.3-.18-2.87.87.87-2.79-.19-.31A8.2 8.2 0 1 1 12 20.2z"/>',
	);

	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}

	$is_filled  = in_array( $name, array( 'whatsapp' ), true );
	$has_title  = '' !== $args['title'];
	$class      = trim( 'icon icon--' . $name . ' ' . $args['class'] );
	$size       = absint( $args['size'] );

	$svg_attrs = sprintf(
		'xmlns="http://www.w3.org/2000/svg" class="%1$s" width="%2$d" height="%2$d" viewBox="0 0 24 24" %3$s %4$s',
		esc_attr( $class ),
		$size,
		$is_filled ? 'fill="currentColor"' : 'fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"',
		$has_title ? 'role="img"' : 'aria-hidden="true" focusable="false"'
	);

	$title = $has_title
		? '<title>' . esc_html( $args['title'] ) . '</title>'
		: '';

	return '<svg ' . $svg_attrs . '>' . $title . $paths[ $name ] . '</svg>';
}

/**
 * Allowed SVG tags/attributes for wp_kses().
 *
 * Intended for sanitising UNTRUSTED SVG (e.g. a future ACF/Customizer SVG
 * upload). NOTE: do not use this to filter the theme's own icon set — wp_kses
 * lowercases attribute names, which would corrupt the case-sensitive `viewBox`
 * attribute and break icon scaling. The built-in icons are static, theme-owned
 * markup and are echoed directly (see spn_cabinets_the_icon()).
 *
 * @since 1.0.0
 * @return array
 */
function spn_cabinets_svg_allowed_html() {
	$svg_atts = array(
		'xmlns'          => true,
		'class'          => true,
		'width'          => true,
		'height'         => true,
		'viewbox'        => true,
		'fill'           => true,
		'stroke'         => true,
		'stroke-width'   => true,
		'stroke-linecap' => true,
		'stroke-linejoin' => true,
		'aria-hidden'    => true,
		'focusable'      => true,
		'role'           => true,
	);

	return array(
		'svg'      => $svg_atts,
		'title'    => array(),
		'g'        => array( 'fill' => true ),
		'path'     => array( 'd' => true, 'fill' => true ),
		'line'     => array( 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true ),
		'polyline' => array( 'points' => true ),
		'polygon'  => array( 'points' => true ),
		'circle'   => array( 'cx' => true, 'cy' => true, 'r' => true ),
		'rect'     => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'ry' => true ),
	);
}

/**
 * Echo a named icon.
 *
 * The icon set is static, theme-authored SVG with no user input, so it is safe
 * to echo directly — exactly like the rest of the theme's static template
 * markup. (Routing it through wp_kses would lowercase `viewBox` and break it.)
 *
 * @since 1.0.0
 *
 * @param string $name Icon slug.
 * @param array  $args See spn_cabinets_icon().
 * @return void
 */
function spn_cabinets_the_icon( $name, $args = array() ) {
	echo spn_cabinets_icon( $name, $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Trusted static SVG icon.
}
