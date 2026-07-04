<?php
/**
 * Template part: Reusable content card.
 *
 * An args-driven card primitive used for services, portfolio/project items and
 * archive results. Structural markup + class hooks only; all styling is applied
 * via assets/css/main.css during the build phase.
 *
 * Usage:
 *   spn_cabinets_component( 'cards/card', array(
 *       'title'      => get_the_title(),
 *       'url'        => get_permalink(),
 *       'image_id'   => get_post_thumbnail_id(),
 *       'image_size' => 'medium_large',
 *       'excerpt'    => spn_cabinets_get_excerpt( 24 ),
 *       'cta_label'  => __( 'Read more', 'spn-cabinets' ),
 *   ) );
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 *
 * @var array $args Data passed from spn_cabinets_component().
 */

defined( 'ABSPATH' ) || exit;

$defaults = array(
	'title'      => '',
	'url'        => '',
	'image_id'   => 0,
	'image_size' => 'medium_large',
	'excerpt'    => '',
	'cta_label'  => '',
	'classes'    => array(),
);

$card = wp_parse_args( $args, $defaults );

// A card needs at least a title to be meaningful.
if ( '' === trim( (string) $card['title'] ) ) {
	return;
}

$classes    = array_merge( array( 'card' ), array_map( 'sanitize_html_class', (array) $card['classes'] ) );
$class_attr = implode( ' ', array_filter( $classes ) );
$has_link   = '' !== $card['url'];
?>
<article class="<?php echo esc_attr( $class_attr ); ?>">

	<?php if ( $card['image_id'] ) : ?>
		<div class="card__media">
			<?php
			echo wp_get_attachment_image(
				absint( $card['image_id'] ),
				$card['image_size'],
				false,
				array(
					'class'   => 'card__image',
					'loading' => 'lazy',
				)
			);
			?>
		</div><!-- .card__media -->
	<?php endif; ?>

	<div class="card__body">

		<h3 class="card__title">
			<?php if ( $has_link ) : ?>
				<a class="card__link" href="<?php echo esc_url( $card['url'] ); ?>">
					<?php echo esc_html( $card['title'] ); ?>
				</a>
			<?php else : ?>
				<?php echo esc_html( $card['title'] ); ?>
			<?php endif; ?>
		</h3>

		<?php if ( '' !== $card['excerpt'] ) : ?>
			<p class="card__excerpt"><?php echo esc_html( $card['excerpt'] ); ?></p>
		<?php endif; ?>

		<?php
		if ( $has_link && '' !== $card['cta_label'] ) {
			spn_cabinets_component(
				'buttons/button',
				array(
					'label'   => $card['cta_label'],
					'url'     => $card['url'],
					'variant' => 'ghost',
					'size'    => 'sm',
					'classes' => array( 'card__cta' ),
				)
			);
		}
		?>

	</div><!-- .card__body -->

</article><!-- .card -->
