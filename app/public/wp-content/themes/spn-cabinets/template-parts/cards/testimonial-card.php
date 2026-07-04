<?php
/**
 * Template part: Testimonial Card.
 *
 * A customer review card: gold star rating, an italic quote over a faint
 * decorative quotation mark, and an author row with an optional rounded avatar.
 * Args-driven, escaped, bails without a quote or author name.
 *
 * Semantic structure: <blockquote> for the quote, <cite> for the author, so the
 * review reads correctly to assistive technology. The rating is exposed as a
 * single labelled image ("Rated N out of 5") with the individual stars hidden.
 *
 * Usage:
 *   spn_cabinets_component( 'cards/testimonial-card', array(
 *       'quote'        => __( 'Placeholder review text.', 'spn-cabinets' ),
 *       'author_name'  => __( 'Placeholder Name', 'spn-cabinets' ),
 *       'service_name' => __( 'Fitted Kitchen', 'spn-cabinets' ),
 *       'rating'       => 5,                 // 1–5
 *       'avatar_url'   => 'https://…/a.jpg',  // optional
 *   ) );
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 *
 * @var array $args Arguments passed from spn_cabinets_component().
 */

defined( 'ABSPATH' ) || exit;

$defaults = array(
	'quote'        => '',
	'author_name'  => '',
	'service_name' => '',
	'rating'       => 5,
	'avatar_url'   => '',
);

$testimonial = wp_parse_args( $args ?? array(), $defaults );

// Quote + author are required.
if ( '' === trim( (string) $testimonial['quote'] ) || '' === trim( (string) $testimonial['author_name'] ) ) {
	return;
}

// Clamp rating to 1–5; anything invalid falls back to a full 5.
$rating = absint( $testimonial['rating'] );
if ( $rating < 1 || $rating > 5 ) {
	$rating = 5;
}

$has_service = '' !== trim( (string) $testimonial['service_name'] );
$has_avatar  = '' !== trim( (string) $testimonial['avatar_url'] );
?>
<article class="card card--testimonial">

	<div class="card__rating" role="img" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: star rating out of five. */ __( 'Rated %d out of 5', 'spn-cabinets' ), $rating ) ); ?>">
		<?php
		for ( $i = 1; $i <= 5; $i++ ) {
			$state = ( $i <= $rating ) ? 'is-filled' : 'is-empty';
			spn_cabinets_the_icon( 'star', array( 'class' => 'card__star ' . $state ) );
		}
		?>
	</div>

	<blockquote class="card__quote">
		<p><?php echo esc_html( $testimonial['quote'] ); ?></p>
	</blockquote>

	<footer class="card__author">
		<?php if ( $has_avatar ) : ?>
			<img
				class="card__avatar"
				src="<?php echo esc_url( $testimonial['avatar_url'] ); ?>"
				alt=""
				width="48"
				height="48"
				loading="lazy"
				decoding="async"
			>
		<?php endif; ?>

		<span class="card__author-meta">
			<cite class="card__author-name"><?php echo esc_html( $testimonial['author_name'] ); ?></cite>
			<?php if ( $has_service ) : ?>
				<span class="card__author-service"><?php echo esc_html( $testimonial['service_name'] ); ?></span>
			<?php endif; ?>
		</span>
	</footer>

</article><!-- .card--testimonial -->
