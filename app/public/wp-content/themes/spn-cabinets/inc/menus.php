<?php
/**
 * Navigation menu registration.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the theme's navigation menu locations.
 *
 * These are the *locations* the client assigns menus to under
 * Appearance → Menus. The actual menu items are managed in the admin.
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_register_menus() {
	register_nav_menus(
		array(
			'primary'         => __( 'Primary Menu', 'spn-cabinets' ),
			'footer'          => __( 'Footer Menu (Quick Links)', 'spn-cabinets' ),
			'footer_services' => __( 'Footer Menu (Services)', 'spn-cabinets' ),
			'footer_legal'    => __( 'Footer Menu (Legal / Bottom Bar)', 'spn-cabinets' ),
		)
	);
}
add_action( 'after_setup_theme', 'spn_cabinets_register_menus' );
