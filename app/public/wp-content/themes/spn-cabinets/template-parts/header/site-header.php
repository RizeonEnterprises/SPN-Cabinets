<?php
/**
 * Template part: Site header.
 *
 * Premium, minimal, sticky header. Orchestrates branding, the desktop primary
 * navigation, the header actions (phone / WhatsApp / CTA) and the mobile menu
 * toggle. The actual off-canvas panel is rendered separately (mobile-nav.php)
 * so it can sit outside the inert background when open.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<header id="masthead" class="site-header" data-header role="banner">
	<div class="site-header__inner">

		<div class="site-header__branding">
			<?php
			// Logo, or linked site title. Rendered as a <p> (not <h1>) — the
			// page's <h1> belongs to its main content (hero / entry title), so
			// there is exactly one <h1> per page.
			spn_cabinets_site_branding(
				array(
					'is_home_heading' => false,
				)
			);
			?>
		</div>

		<?php
		// Desktop primary navigation (also the no-JS mobile fallback).
		get_template_part( 'template-parts/header/navigation-primary' );

		// Header actions: phone, WhatsApp, CTA button.
		get_template_part( 'template-parts/header/header-actions' );
		?>

		<?php
		// Mobile toggle only renders when there's a primary menu (and therefore
		// an off-canvas panel) for it to control.
		if ( spn_cabinets_has_menu( 'primary' ) ) :
			?>
			<button
				class="menu-toggle"
				type="button"
				aria-controls="mobile-nav"
				aria-expanded="false"
				data-menu-toggle
			>
				<?php spn_cabinets_the_icon( 'menu', array( 'class' => 'menu-toggle__icon' ) ); ?>
				<span class="screen-reader-text"><?php esc_html_e( 'Open menu', 'spn-cabinets' ); ?></span>
			</button>
		<?php endif; ?>

	</div><!-- .site-header__inner -->
</header><!-- #masthead -->
