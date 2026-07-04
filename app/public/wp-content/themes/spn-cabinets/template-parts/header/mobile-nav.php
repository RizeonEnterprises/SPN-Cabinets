<?php
/**
 * Template part: Off-canvas mobile navigation.
 *
 * A slide-in panel with a backdrop, rendered as a sibling of the header/content
 * so the background can be made inert while it is open. Behaviour (open/close,
 * focus trap, Escape, outside-click, scroll-lock) is progressively enhanced by
 * navigation.js. Without JS this stays hidden and the inline primary nav in the
 * header serves as the fallback.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// No panel if there is no primary menu assigned.
if ( ! spn_cabinets_has_menu( 'primary' ) ) {
	return;
}
?>
<div id="mobile-nav" class="mobile-nav" data-mobile-nav>

	<div class="mobile-nav__backdrop" data-menu-close></div>

	<div
		class="mobile-nav__panel"
		role="dialog"
		aria-modal="true"
		aria-label="<?php esc_attr_e( 'Site menu', 'spn-cabinets' ); ?>"
		data-menu-panel
	>
		<div class="mobile-nav__head">
			<span class="mobile-nav__title"><?php esc_html_e( 'Menu', 'spn-cabinets' ); ?></span>
			<button class="mobile-nav__close" type="button" data-menu-close>
				<?php spn_cabinets_the_icon( 'close', array( 'class' => 'mobile-nav__close-icon' ) ); ?>
				<span class="screen-reader-text"><?php esc_html_e( 'Close menu', 'spn-cabinets' ); ?></span>
			</button>
		</div>

		<nav class="mobile-nav__nav" aria-label="<?php esc_attr_e( 'Mobile primary', 'spn-cabinets' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'mobile-menu',
					'menu_class'     => 'mobile-menu',
					'container'      => false,
					'depth'          => 2,
					'walker'         => new SPN_Cabinets_Walker_Nav_Menu(),
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>

		<div class="mobile-nav__actions">
			<?php
			// Conversion cluster mirrored inside the panel.
			spn_cabinets_contact_item( 'phone', array( 'class' => 'mobile-nav__phone' ) );

			get_template_part( 'template-parts/buttons/whatsapp', null, array( 'block' => true, 'size' => 'md' ) );

			$cta = spn_cabinets_cta();
			if ( ! empty( $cta['label'] ) ) {
				spn_cabinets_component(
					'buttons/button',
					array(
						'label'   => $cta['label'],
						'url'     => $cta['url'],
						'variant' => 'primary',
						'size'    => 'md',
						'classes' => array( 'button--block', 'mobile-nav__cta' ),
					)
				);
			}
			?>
		</div>
	</div><!-- .mobile-nav__panel -->
</div><!-- #mobile-nav -->
