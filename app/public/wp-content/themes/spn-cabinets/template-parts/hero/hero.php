<?php
/**
 * Template part: Hero.
 *
 * A standalone, reusable hero band for the homepage, service pages and beyond.
 * Args-driven (see spn_cabinets_component()); presentation-only, escaped, and
 * bails early if no title is supplied. Reuses the button primitive for CTAs.
 *
 * The background image (when supplied) renders as a real <img> — better for the
 * LCP (allows fetchpriority/decoding, no inline CSS) — with a token-based dark
 * overlay so light text stays readable.
 *
 * Usage:
 *   spn_cabinets_component( 'hero/hero', array(
 *       'title'              => __( 'Placeholder heading', 'spn-cabinets' ),
 *       'subtitle'           => __( 'Placeholder supporting line.', 'spn-cabinets' ),
 *       'alignment'          => 'center',              // left | center
 *       'background_type'    => 'image',               // image | solid
 *       'background_image_url'=> 'https://…/hero.jpg',
 *       'primary_cta_text'   => __( 'Free Quote', 'spn-cabinets' ),
 *       'primary_cta_url'    => '/contact/',
 *       'secondary_cta_text' => __( 'View our work', 'spn-cabinets' ),
 *       'secondary_cta_url'  => '/gallery/',
 *   ) );
 *
 * NOTE ON HEADINGS: `title_tag` defaults to `h1`. Ensure only one <h1> per page —
 * when the hero is the page's main heading (e.g. the homepage), the header
 * branding should NOT also be an <h1>; on pages that already have an <h1>
 * (e.g. the page title), pass `'title_tag' => 'h2'`.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 *
 * @var array $args Arguments passed from spn_cabinets_component().
 */

defined( 'ABSPATH' ) || exit;

$defaults = array(
	'title'                => '',
	'title_tag'            => 'h1',   // h1 | h2 — keep one <h1> per page.
	'subtitle'             => '',
	'alignment'            => 'left', // left | center
	'background_type'      => 'solid', // image | solid
	'background_image_url' => '',
	'background_image_alt' => '',     // Empty = decorative background (default).
	'primary_cta_text'     => '',
	'primary_cta_url'      => '',
	'secondary_cta_text'   => '',
	'secondary_cta_url'    => '',
);

$hero = wp_parse_args( $args ?? array(), $defaults );

// A hero must have a heading; bail cleanly otherwise.
if ( '' === trim( (string) $hero['title'] ) ) {
	return;
}

// Sanitise choice args to known values.
$alignment = in_array( $hero['alignment'], array( 'left', 'center' ), true ) ? $hero['alignment'] : 'left';
$title_tag = in_array( $hero['title_tag'], array( 'h1', 'h2' ), true ) ? $hero['title_tag'] : 'h1';

// Background: only treat as "image" when a URL is actually supplied.
$has_image       = ( 'image' === $hero['background_type'] ) && '' !== trim( (string) $hero['background_image_url'] );
$background_type = $has_image ? 'image' : 'solid';

// CTAs render only when both text and URL are present.
$has_primary   = '' !== trim( (string) $hero['primary_cta_text'] ) && '' !== trim( (string) $hero['primary_cta_url'] );
$has_secondary = '' !== trim( (string) $hero['secondary_cta_text'] ) && '' !== trim( (string) $hero['secondary_cta_url'] );

$classes = array(
	'hero',
	'hero--' . $alignment,
	'hero--' . $background_type,
);
?>
<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

	<?php if ( $has_image ) : ?>
		<img
			class="hero__bg-image"
			src="<?php echo esc_url( $hero['background_image_url'] ); ?>"
			alt="<?php echo esc_attr( $hero['background_image_alt'] ); ?>"
			loading="eager"
			fetchpriority="high"
			decoding="async"
		>
		<div class="hero__overlay" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="hero__inner container">
		<div class="hero__content">

			<<?php echo tag_escape( $title_tag ); ?> class="hero__title">
				<?php echo esc_html( $hero['title'] ); ?>
			</<?php echo tag_escape( $title_tag ); ?>>

			<?php if ( '' !== trim( (string) $hero['subtitle'] ) ) : ?>
				<p class="hero__subtitle"><?php echo esc_html( $hero['subtitle'] ); ?></p>
			<?php endif; ?>

			<?php if ( $has_primary || $has_secondary ) : ?>
				<div class="hero__actions">
					<?php
					if ( $has_primary ) {
						spn_cabinets_component(
							'buttons/button',
							array(
								'label'   => $hero['primary_cta_text'],
								'url'     => $hero['primary_cta_url'],
								'variant' => 'accent',
								'size'    => 'lg',
								'classes' => array( 'hero__cta', 'hero__cta--primary' ),
							)
						);
					}

					if ( $has_secondary ) {
						spn_cabinets_component(
							'buttons/button',
							array(
								'label'   => $hero['secondary_cta_text'],
								'url'     => $hero['secondary_cta_url'],
								'variant' => 'outline',
								'size'    => 'lg',
								'classes' => array( 'hero__cta', 'hero__cta--secondary' ),
							)
						);
					}
					?>
				</div><!-- .hero__actions -->
			<?php endif; ?>

		</div><!-- .hero__content -->
	</div><!-- .hero__inner -->
</section><!-- .hero -->
