<?php
/**
 * Template Name: About Us
 *
 * The About page: Hero → "media & text" story (image + the_content()) →
 * testimonials → CTA. Assembled from reusable components; the client writes
 * their story in the block editor (rendered by the_content()).
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<main id="primary" class="site-main site-main--flush" role="main">

		<?php
		// 1) HERO.
		spn_cabinets_component(
			'hero/hero',
			array(
				'title'           => __( 'About SPN Cabinets', 'spn-cabinets' ),
				'title_tag'       => 'h1',
				'alignment'       => 'center',
				'background_type' => 'solid',
			)
		);
		?>

		<?php
		// 2) STORY — media & text (the About page's featured image + editor
		// content). The image is editable in the block editor; omit it cleanly
		// if none is set.
		$spn_about_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		?>
		<section class="section">
			<div class="container">
				<div class="grid grid-md-2 items-center">

					<?php if ( $spn_about_image ) : ?>
						<div class="about-story__media ratio-square">
							<img
								class="radius-lg object-cover"
								src="<?php echo esc_url( $spn_about_image ); ?>"
								alt="<?php esc_attr_e( 'A bespoke fitted bedroom crafted by SPN Cabinets', 'spn-cabinets' ); ?>"
								width="800"
								height="600"
								loading="lazy"
								decoding="async"
							>
						</div>
					<?php endif; ?>

					<div class="about-story__content entry-content">
						<?php the_content(); ?>
					</div>

				</div>
			</div>
		</section>

		<?php // 3) TESTIMONIALS (muted section to break the flow). ?>
		<section class="section section--surface">
			<div class="container stack stack--lg">

				<?php
				spn_cabinets_component(
					'components/section-heading',
					array(
						'kicker'    => __( 'Testimonials', 'spn-cabinets' ),
						'title'     => __( 'Client Stories', 'spn-cabinets' ),
						'alignment' => 'center',
					)
				);
				?>

				<div class="grid grid-md-2 grid-lg-3">
					<?php
					foreach ( spn_cabinets_mock_testimonials( 3 ) as $testimonial ) {
						spn_cabinets_component( 'cards/testimonial-card', $testimonial );
					}
					?>
				</div>

			</div>
		</section>

		<?php
		// 4) CTA.
		spn_cabinets_component(
			'components/cta',
			array(
				'title'       => __( 'Ready to start your project?', 'spn-cabinets' ),
				'button_text' => __( 'Get a Free Quote', 'spn-cabinets' ),
				'button_url'  => home_url( '/quote/' ),
				'theme'       => 'dark',
				'alignment'   => 'center',
			)
		);
		?>

	</main><!-- #primary -->

	<?php
endwhile;

get_footer();
