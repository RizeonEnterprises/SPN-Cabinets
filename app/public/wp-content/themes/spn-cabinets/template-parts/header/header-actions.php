<?php
/**
 * Template part: Header actions.
 *
 * The conversion cluster in the header: phone, WhatsApp and the primary CTA.
 * All values come from the central, filterable site-options config so they are
 * never duplicated between header and footer. Contact values are placeholders
 * until wired to ACF/the Customizer.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$cta = spn_cabinets_cta();
?>
<div class="header-actions">

	<?php spn_cabinets_contact_item( 'phone', array( 'class' => 'header-actions__phone' ) ); ?>

	<?php
	// Reusable WhatsApp button (renders only when a number is configured).
	get_template_part( 'template-parts/buttons/whatsapp' );
	?>

	<?php
	if ( ! empty( $cta['label'] ) ) {
		spn_cabinets_component(
			'buttons/button',
			array(
				'label'   => $cta['label'],
				'url'     => $cta['url'],
				'variant' => 'primary',
				'size'    => 'sm',
				'classes' => array( 'header-actions__cta' ),
			)
		);
	}
	?>

</div><!-- .header-actions -->
