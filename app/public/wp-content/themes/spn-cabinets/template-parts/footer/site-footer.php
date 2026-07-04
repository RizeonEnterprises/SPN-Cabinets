<?php
/**
 * Template part: Site footer.
 *
 * Four-column footer + bottom bar. Structural only — all text is placeholder and
 * all contact details come from the central site-options config. Menus render
 * from their assigned locations, or as placeholders until the client builds them.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="site-footer__inner">

		<div class="footer-grid">

			<?php // Column 1 — Brand + description. ?>
			<div class="footer-col footer-col--brand">
				<?php spn_cabinets_site_branding( array( 'class' => 'footer-branding' ) ); ?>
				<p class="footer-col__description">
					<?php esc_html_e( 'Company description placeholder — a short line about SPN Cabinets, supplied by the client.', 'spn-cabinets' ); ?>
				</p>
			</div>

			<?php // Column 2 — Quick Links. ?>
			<div class="footer-col footer-col--links">
				<h2 class="footer-col__title"><?php esc_html_e( 'Quick Links', 'spn-cabinets' ); ?></h2>
				<?php spn_cabinets_footer_menu( 'footer', 5 ); ?>
			</div>

			<?php // Column 3 — Services. ?>
			<div class="footer-col footer-col--services">
				<h2 class="footer-col__title"><?php esc_html_e( 'Services', 'spn-cabinets' ); ?></h2>
				<?php spn_cabinets_footer_menu( 'footer_services', 4 ); ?>
			</div>

			<?php // Column 4 — Contact. ?>
			<div class="footer-col footer-col--contact">
				<h2 class="footer-col__title"><?php esc_html_e( 'Contact', 'spn-cabinets' ); ?></h2>
				<address class="footer-contact">
					<?php
					spn_cabinets_contact_item( 'phone', array( 'class' => 'footer-contact__item' ) );
					spn_cabinets_contact_item( 'email', array( 'class' => 'footer-contact__item' ) );
					spn_cabinets_contact_item( 'whatsapp', array( 'class' => 'footer-contact__item' ) );
					spn_cabinets_contact_item( 'address', array( 'class' => 'footer-contact__item' ) );
					?>
				</address>
			</div>

		</div><!-- .footer-grid -->

		<div class="site-footer__bottom">
			<p class="site-footer__copyright">
				&copy; <?php spn_cabinets_copyright_year(); ?>
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>.
				<?php esc_html_e( 'All rights reserved.', 'spn-cabinets' ); ?>
			</p>

			<?php if ( spn_cabinets_has_menu( 'footer_legal' ) ) : ?>
				<nav class="site-footer__legal" aria-label="<?php esc_attr_e( 'Legal', 'spn-cabinets' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer_legal',
							'menu_class'     => 'legal-menu',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>
			<?php else : ?>
				<nav class="site-footer__legal" aria-label="<?php esc_attr_e( 'Legal', 'spn-cabinets' ); ?>">
					<ul class="legal-menu legal-menu--placeholder">
						<li class="is-placeholder"><span><?php esc_html_e( 'Privacy Policy', 'spn-cabinets' ); ?></span></li>
						<li class="is-placeholder"><span><?php esc_html_e( 'Terms', 'spn-cabinets' ); ?></span></li>
					</ul>
				</nav>
			<?php endif; ?>
		</div><!-- .site-footer__bottom -->

	</div><!-- .site-footer__inner -->
</footer><!-- #colophon -->
