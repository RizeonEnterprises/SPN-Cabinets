<?php
/**
 * Template part: Primary (desktop) navigation.
 *
 * Renders the "primary" menu with the accessible nav walker. On desktop this is
 * the main horizontal menu with dropdown-ready submenus; on mobile it also acts
 * as the no-JS fallback (the off-canvas menu takes over when JS is available).
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// Nothing to render if the client hasn't assigned a primary menu yet.
if ( ! spn_cabinets_has_menu( 'primary' ) ) {
	return;
}
?>
<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'spn-cabinets' ); ?>" data-primary-nav>
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'menu_id'        => 'primary-menu',
			'menu_class'     => 'primary-menu',
			'container'      => false,
			'depth'          => 2,
			'walker'         => new SPN_Cabinets_Walker_Nav_Menu(),
			'fallback_cb'    => false,
		)
	);
	?>
</nav><!-- .primary-nav -->
