<?php
/**
 * Template part: WhatsApp button.
 *
 * Reusable WhatsApp click-to-chat button. Renders a real link when a WhatsApp
 * number is configured (see spn_cabinets_contact()); otherwise renders a
 * clearly-marked placeholder button so the shell stays visible without a dead
 * link. Uses the shared button classes + WhatsApp icon.
 *
 * Usage:
 *   get_template_part( 'template-parts/buttons/whatsapp', null, array( 'block' => true ) );
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 *
 * @var array $args Optional { @type bool $block; @type string $size; }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'block' => false,
		'size'  => 'sm',
	)
);

$contact = spn_cabinets_contact();
$href    = spn_cabinets_whatsapp_href( $contact['whatsapp'] );
$label   = __( 'WhatsApp', 'spn-cabinets' );

$classes = array(
	'button',
	'button--accent',
	'button--' . sanitize_html_class( $args['size'] ),
	'whatsapp-button',
);
if ( $args['block'] ) {
	$classes[] = 'button--block';
}
$class_attr = implode( ' ', $classes );

if ( $href ) :
	?>
	<a class="<?php echo esc_attr( $class_attr ); ?>" href="<?php echo esc_url( $href ); ?>" target="_blank" rel="noopener noreferrer">
		<?php spn_cabinets_the_icon( 'whatsapp', array( 'class' => 'button__icon' ) ); ?>
		<span class="button__label"><?php echo esc_html( $label ); ?></span>
	</a>
	<?php
else :
	// Placeholder: non-interactive, marked, so no dead link ships in the shell.
	?>
	<span class="<?php echo esc_attr( $class_attr ); ?> is-placeholder" aria-disabled="true">
		<?php spn_cabinets_the_icon( 'whatsapp', array( 'class' => 'button__icon' ) ); ?>
		<span class="button__label"><?php echo esc_html( $label ); ?></span>
	</span>
	<?php
endif;
