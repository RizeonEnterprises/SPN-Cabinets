<?php
/**
 * Template part: Reusable button / call-to-action.
 *
 * A single, args-driven button primitive so every CTA across the site shares
 * consistent, accessible markup and class hooks. Renders as an <a> when a URL
 * is supplied, otherwise as a <button>.
 *
 * Usage:
 *   spn_cabinets_component( 'buttons/button', array(
 *       'label'   => __( 'Get a free quote', 'spn-cabinets' ),
 *       'url'     => '/contact/',
 *       'variant' => 'primary',        // primary | secondary | ghost …
 *       'size'    => 'lg',             // sm | md | lg
 *       'attrs'   => array( 'data-track' => 'hero-cta' ),
 *   ) );
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 *
 * @var array $args Data passed from spn_cabinets_component().
 */

defined( 'ABSPATH' ) || exit;

$defaults = array(
	'label'    => '',
	'url'      => '',
	'variant'  => 'primary',
	'size'     => 'md',
	'type'     => 'button', // Only used when rendered as a <button>.
	'new_tab'  => false,
	'classes'  => array(),   // Extra class strings.
	'attrs'    => array(),   // Extra HTML attributes (key => value).
);

$button = wp_parse_args( $args, $defaults );

// Nothing to render without a label.
if ( '' === trim( (string) $button['label'] ) ) {
	return;
}

// Compose BEM-friendly class list.
$classes = array_merge(
	array(
		'button',
		'button--' . sanitize_html_class( $button['variant'] ),
		'button--' . sanitize_html_class( $button['size'] ),
	),
	array_map( 'sanitize_html_class', (array) $button['classes'] )
);
$class_attr = implode( ' ', array_filter( $classes ) );

// Build any additional attributes safely.
$extra_attrs = '';
foreach ( (array) $button['attrs'] as $key => $value ) {
	$extra_attrs .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( $value ) );
}

if ( '' !== $button['url'] ) :
	$target = $button['new_tab'] ? ' target="_blank" rel="noopener noreferrer"' : '';
	?>
	<a
		class="<?php echo esc_attr( $class_attr ); ?>"
		href="<?php echo esc_url( $button['url'] ); ?>"
		<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static, pre-escaped string. ?>
		<?php echo $extra_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped per-attribute above. ?>
	><?php echo esc_html( $button['label'] ); ?></a>
	<?php
else :
	?>
	<button
		class="<?php echo esc_attr( $class_attr ); ?>"
		type="<?php echo esc_attr( $button['type'] ); ?>"
		<?php echo $extra_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped per-attribute above. ?>
	><?php echo esc_html( $button['label'] ); ?></button>
	<?php
endif;
