<?php
/**
 * Template part: Service Card.
 *
 * A whole-card-clickable tile for a service (used inside a grid, e.g. the
 * `.auto-grid` layout primitive). Args-driven, escaped, bails without a title
 * or URL. Supports an optional top image (uniform 4:3 crop) and/or an accent
 * icon from the theme icon set.
 *
 * The clickable-block pattern comes from the base card: the title's
 * `.card__link` stretches a pseudo-element over the whole card, so a click
 * anywhere navigates while keeping a single, accessible link (the title).
 *
 * Usage:
 *   spn_cabinets_component( 'cards/service-card', array(
 *       'title'       => __( 'Placeholder service', 'spn-cabinets' ),
 *       'description' => __( 'Placeholder summary sentence.', 'spn-cabinets' ),
 *       'image_url'   => 'https://…/service.jpg',
 *       'icon'        => 'map-pin',           // any spn_cabinets_icon() slug
 *       'url'         => '/services/example/',
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
	'image_url'   => '',
	'icon'        => '',
	'url'         => '',
);

$card = wp_parse_args( $args ?? array(), $defaults );

// Title + URL are required (the whole card is a link).
if ( '' === trim( (string) $card['title'] ) || '' === trim( (string) $card['url'] ) ) {
	return;
}

$has_image = '' !== trim( (string) $card['image_url'] );

// Resolve the icon once; empty string if none / unknown slug.
$icon_svg = '' !== trim( (string) $card['icon'] )
	? spn_cabinets_icon( $card['icon'], array( 'class' => 'card__icon' ) )
	: '';
?>
<article class="card card--service">

	<?php if ( $has_image ) : ?>
		<div class="card__media">
			<img
				class="card__image"
				src="<?php echo esc_url( $card['image_url'] ); ?>"
				alt=""
				loading="lazy"
				decoding="async"
			>
		</div>
	<?php endif; ?>

	<div class="card__body">

		<?php
		if ( '' !== $icon_svg ) {
			echo $icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Trusted static SVG icon.
		}
		?>

		<h3 class="card__title">
			<a class="card__link" href="<?php echo esc_url( $card['url'] ); ?>"><?php echo esc_html( $card['title'] ); ?></a>
		</h3>

		<?php if ( '' !== trim( (string) $card['description'] ) ) : ?>
			<p class="card__excerpt"><?php echo esc_html( $card['description'] ); ?></p>
		<?php endif; ?>

		<span class="card__arrow" aria-hidden="true">
			<?php spn_cabinets_the_icon( 'arrow-right', array( 'class' => 'card__arrow-icon' ) ); ?>
		</span>

	</div><!-- .card__body -->
</article><!-- .card--service -->
