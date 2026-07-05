<?php
/**
 * Template Name: Services Page
 *
 * The Services hub: Hero → services grid → testimonials → CTA, assembled from
 * reusable components. Uses MOCK data for the services and testimonials (clearly
 * placeholder — to be replaced by real content / a services source later). All
 * output is escaped inside the components it is passed to.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

// Placeholder services + testimonials (shared demo-content module).
$mock_services     = spn_cabinets_mock_services();
$mock_testimonials = spn_cabinets_mock_testimonials();

while ( have_posts() ) :
	the_post();
	?>

	<main id="primary" class="site-main site-main--flush" role="main">

		<?php
		// 1) HERO.
		spn_cabinets_component(
			'hero/hero',
			array(
				'title'           => get_the_title(),
				'title_tag'       => 'h1',
				'subtitle'        => __( 'We design, build, and install premium bespoke cabinetry.', 'spn-cabinets' ),
				'alignment'       => 'center',
				'background_type' => 'solid',
			)
		);
		?>

		<?php // 2) SERVICES GRID. ?>
		<section class="section">
			<div class="container stack stack--lg">

				<?php
				spn_cabinets_component(
					'components/section-heading',
					array(
						'title'       => __( 'Our Expertise', 'spn-cabinets' ),
						'description' => __( 'Discover our range of custom fitted furniture solutions.', 'spn-cabinets' ),
						'alignment'   => 'center',
					)
				);
				?>

				<div class="grid grid-md-2 grid-lg-3">
					<?php
					foreach ( $mock_services as $service ) {
						spn_cabinets_component( 'cards/service-card', $service );
					}
					?>
				</div>

			</div>
		</section>

		<?php // 3) CLIENT TESTIMONIALS (muted section to break the flow). ?>
		<section class="section section--surface">
			<div class="container stack stack--lg">

				<?php
				spn_cabinets_component(
					'components/section-heading',
					array(
						'kicker'    => __( 'Testimonials', 'spn-cabinets' ),
						'title'     => __( 'What Our Clients Say', 'spn-cabinets' ),
						'alignment' => 'center',
					)
				);
				?>

				<div class="grid grid-md-2 grid-lg-3">
					<?php
					foreach ( $mock_testimonials as $testimonial ) {
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
				'title'       => __( 'Ready to transform your home?', 'spn-cabinets' ),
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
