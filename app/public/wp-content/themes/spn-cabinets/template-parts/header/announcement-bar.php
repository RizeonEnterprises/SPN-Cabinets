<?php
/**
 * Template part: Announcement bar.
 *
 * A slim, full-width promo/notice bar above the header. DISABLED by default —
 * it renders nothing unless enabled via the `spn_cabinets_announcement` filter
 * (see inc/helpers/site-options.php). Structural only; content is placeholder.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$announcement = spn_cabinets_announcement();

// Bail entirely when disabled or empty — no markup, no cost.
if ( empty( $announcement['enabled'] ) || '' === trim( (string) $announcement['text'] ) ) {
	return;
}
?>
<div class="announcement-bar" role="region" aria-label="<?php esc_attr_e( 'Announcement', 'spn-cabinets' ); ?>">
	<div class="announcement-bar__inner container">
		<p class="announcement-bar__text">
			<?php echo esc_html( $announcement['text'] ); ?>

			<?php if ( ! empty( $announcement['url'] ) && ! empty( $announcement['link_label'] ) ) : ?>
				<a class="announcement-bar__link" href="<?php echo esc_url( $announcement['url'] ); ?>">
					<?php echo esc_html( $announcement['link_label'] ); ?>
				</a>
			<?php endif; ?>
		</p>
	</div>
</div><!-- .announcement-bar -->
