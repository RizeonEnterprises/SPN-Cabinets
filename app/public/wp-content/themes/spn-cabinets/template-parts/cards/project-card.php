<?php
/**
 * Template part: Project Card.
 *
 * A luxury full-bleed image tile for the gallery/portfolio: the photo fills the
 * card (fixed 4:5 crop) with the category + title overlaid at the bottom over a
 * gradient scrim. Args-driven, escaped, bails without a title or image.
 *
 * When a `url` is supplied the whole card is clickable (base card
 * `.card__link::after` block); otherwise it renders as a static gallery image.
 * The image zoom-on-hover and rounded clipping come from the base card.
 *
 * Usage:
 *   spn_cabinets_component( 'cards/project-card', array(
 *       'title'     => __( 'Placeholder project', 'spn-cabinets' ),
 *       'image_url' => 'https://…/project.jpg',
 *       'category'  => __( 'Placeholder category', 'spn-cabinets' ),
 *       'url'       => '/project/example/',   // optional
 *       'image_alt' => '',                    // optional; defaults to title
 *   ) );
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 *
 * @var array $args Arguments passed from spn_cabinets_component().
 */

defined( 'ABSPATH' ) || exit;

$defaults = array(
	'title'     => '',
	'image_url' => '',
	'category'  => '',
	'url'       => '',
	'image_alt' => '', // Optional dedicated alt; falls back to the title.
);

$card = wp_parse_args( $args ?? array(), $defaults );

// Title + image are required.
if ( '' === trim( (string) $card['title'] ) || '' === trim( (string) $card['image_url'] ) ) {
	return;
}

$has_link     = '' !== trim( (string) $card['url'] );
$has_category = '' !== trim( (string) $card['category'] );
$image_alt    = '' !== trim( (string) $card['image_alt'] ) ? $card['image_alt'] : $card['title'];
?>
<article class="card card--project">

	<img
		class="card__image"
		src="<?php echo esc_url( $card['image_url'] ); ?>"
		alt="<?php echo esc_attr( $image_alt ); ?>"
		loading="lazy"
		decoding="async"
	>

	<div class="card__overlay" aria-hidden="true"></div>

	<div class="card__caption">
		<?php if ( $has_category ) : ?>
			<span class="card__category"><?php echo esc_html( $card['category'] ); ?></span>
		<?php endif; ?>

		<h3 class="card__title">
			<?php if ( $has_link ) : ?>
				<a class="card__link" href="<?php echo esc_url( $card['url'] ); ?>"><?php echo esc_html( $card['title'] ); ?></a>
			<?php else : ?>
				<?php echo esc_html( $card['title'] ); ?>
			<?php endif; ?>
		</h3>
	</div><!-- .card__caption -->

</article><!-- .card--project -->
