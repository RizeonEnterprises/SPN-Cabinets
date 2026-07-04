<?php
/**
 * Template part: Call-to-action (CTA) band.
 *
 * A full-width conversion band (title + optional description + one button).
 * Args-driven, escaped, and bails unless it has a title AND a button (a CTA
 * band without a button is pointless). The button is NOT rebuilt here — it
 * reuses the shared button primitive (template-parts/buttons/button.php) with a
 * variant chosen from the theme so it contrasts against the band background.
 *
 * Usage:
 *   spn_cabinets_component( 'components/cta', array(
 *       'title'       => __( 'Placeholder call to action', 'spn-cabinets' ),
 *       'description' => __( 'Placeholder supporting sentence.', 'spn-cabinets' ),
 *       'button_text' => __( 'Get a Quote', 'spn-cabinets' ),
 *       'button_url'  => '/contact/',
 *       'theme'       => 'primary',   // primary | secondary | dark
 *       'alignment'   => 'center',    // center | left
 *   ) );
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 *
 * @var array $args Arguments passed from spn_cabinets_component().
 */

defined( 'ABSPATH' ) || exit;

$defaults = array(
	'title'       => '',
	'description' => '',
	'button_text' => '',
	'button_url'  => '',
	'theme'       => 'primary',
	'alignment'   => 'center',
);

$cta = wp_parse_args( $args ?? array(), $defaults );

// Title + button are required.
if (
	'' === trim( (string) $cta['title'] )
	|| '' === trim( (string) $cta['button_text'] )
	|| '' === trim( (string) $cta['button_url'] )
) {
	return;
}

/*
 * Theme → button-variant map. Each theme is a dark surface, so the accent
 * button is the high-contrast CTA on all of them. Adding a light theme later
 * would map to a darker button variant here — the template needs no changes.
 */
$theme_button = array(
	'primary'   => 'accent',
	'secondary' => 'accent',
	'dark'      => 'accent',
);

$theme          = array_key_exists( $cta['theme'], $theme_button ) ? $cta['theme'] : 'primary';
$button_variant = $theme_button[ $theme ];
$alignment      = in_array( $cta['alignment'], array( 'left', 'center' ), true ) ? $cta['alignment'] : 'center';

$classes = array(
	'cta',
	'cta--' . $theme,
	'cta--' . $alignment,
);
?>
<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="cta__inner container">

		<div class="cta__content">
			<h2 class="cta__title"><?php echo esc_html( $cta['title'] ); ?></h2>

			<?php if ( '' !== trim( (string) $cta['description'] ) ) : ?>
				<p class="cta__description"><?php echo esc_html( $cta['description'] ); ?></p>
			<?php endif; ?>
		</div><!-- .cta__content -->

		<div class="cta__actions">
			<?php
			// Reuse the shared button primitive — do not rebuild the button.
			spn_cabinets_component(
				'buttons/button',
				array(
					'label'   => $cta['button_text'],
					'url'     => $cta['button_url'],
					'variant' => $button_variant,
					'size'    => 'lg',
					'classes' => array( 'cta__button' ),
				)
			);
			?>
		</div><!-- .cta__actions -->

	</div><!-- .cta__inner -->
</section><!-- .cta -->
