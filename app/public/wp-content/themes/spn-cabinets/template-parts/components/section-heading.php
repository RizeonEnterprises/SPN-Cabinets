<?php
/**
 * Template part: Section Heading.
 *
 * A small, reusable heading block used above service grids, galleries,
 * testimonials and standard page sections. Args-driven, escaped, and bails
 * early if no title is supplied. Presentation-only — the caller wraps it in a
 * container/section and decides its width.
 *
 * Usage:
 *   spn_cabinets_component( 'components/section-heading', array(
 *       'kicker'      => __( 'Placeholder kicker', 'spn-cabinets' ),
 *       'title'       => __( 'Placeholder heading', 'spn-cabinets' ),
 *       'title_tag'   => 'h2',            // h1–h6, for SEO hierarchy
 *       'description' => __( 'Placeholder supporting sentence.', 'spn-cabinets' ),
 *       'alignment'   => 'center',        // left | center
 *   ) );
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 *
 * @var array $args Arguments passed from spn_cabinets_component().
 */

defined( 'ABSPATH' ) || exit;

$defaults = array(
	'kicker'      => '',
	'title'       => '',
	'title_tag'   => 'h2',
	'description' => '',
	'alignment'   => 'center',
);

$heading = wp_parse_args( $args ?? array(), $defaults );

// The title is required; render nothing without it.
if ( '' === trim( (string) $heading['title'] ) ) {
	return;
}

// Sanitise choice args to known values.
$alignment    = in_array( $heading['alignment'], array( 'left', 'center' ), true ) ? $heading['alignment'] : 'center';
$allowed_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' );
$title_tag    = in_array( $heading['title_tag'], $allowed_tags, true ) ? $heading['title_tag'] : 'h2';

$classes = array(
	'section-heading',
	'section-heading--' . $alignment,
);
?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

	<?php if ( '' !== trim( (string) $heading['kicker'] ) ) : ?>
		<p class="section-heading__kicker"><?php echo esc_html( $heading['kicker'] ); ?></p>
	<?php endif; ?>

	<<?php echo tag_escape( $title_tag ); ?> class="section-heading__title"><?php echo esc_html( $heading['title'] ); ?></<?php echo tag_escape( $title_tag ); ?>>

	<?php if ( '' !== trim( (string) $heading['description'] ) ) : ?>
		<p class="section-heading__description"><?php echo esc_html( $heading['description'] ); ?></p>
	<?php endif; ?>

</div><!-- .section-heading -->
