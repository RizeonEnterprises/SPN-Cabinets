<?php
/**
 * The front page (homepage) template.
 *
 * WordPress uses this automatically for the site's front page. A fully composed
 * landing page built from reusable components: Hero → Featured Services →
 * Recent Projects (dynamic WP_Query) → Testimonials → CTA.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main site-main--front-page site-main--flush" role="main">

	<?php
	// 1) HERO — the homepage <h1> + dual CTAs. Background is the Home page's
	// featured image (editable in the block editor); falls back to the solid
	// variant if none is set.
	$spn_hero_image = get_the_post_thumbnail_url( get_queried_object_id(), 'full' );
	spn_cabinets_component(
		'hero/hero',
		array(
			'title'                => __( 'Bespoke Kitchens & Fitted Bedrooms', 'spn-cabinets' ),
			'title_tag'            => 'h1',
			'subtitle'             => __( 'Expertly crafted cabinetry designed and installed to perfection.', 'spn-cabinets' ),
			'alignment'            => 'center',
			'background_type'      => $spn_hero_image ? 'image' : 'solid',
			'background_image_url' => $spn_hero_image ? $spn_hero_image : '',
			'primary_cta_text'     => __( 'View Our Work', 'spn-cabinets' ),
			'primary_cta_url'      => home_url( '/portfolio/' ),
			'secondary_cta_text'   => __( 'Get a Quote', 'spn-cabinets' ),
			'secondary_cta_url'    => home_url( '/quote/' ),
		)
	);
	?>

	<?php // 2) FEATURED SERVICES. ?>
	<section class="section">
		<div class="container stack stack--lg">

			<?php
			spn_cabinets_component(
				'components/section-heading',
				array(
					'kicker'    => __( 'What We Do', 'spn-cabinets' ),
					'title'     => __( 'Our Services', 'spn-cabinets' ),
					'alignment' => 'center',
				)
			);
			?>

			<div class="grid grid-md-2 grid-lg-4">
				<?php
				foreach ( spn_cabinets_mock_services( 4 ) as $service ) {
					spn_cabinets_component( 'cards/service-card', $service );
				}
				?>
			</div>

		</div>
	</section>

	<?php
	// 3) RECENT PROJECTS — 6 most recent spn_project posts, rendered only when
	// projects exist. Uses a scoped WP_Query and restores the main query after.
	$recent_projects_query = new WP_Query(
		array(
			'post_type'           => 'spn_project',
			'post_status'         => 'publish',
			'posts_per_page'      => 6,
			'no_found_rows'       => true, // No pagination here → skip the row count.
			'ignore_sticky_posts' => true,
		)
	);

	if ( $recent_projects_query->have_posts() ) :

		$recent_projects = array();

		while ( $recent_projects_query->have_posts() ) :
			$recent_projects_query->the_post();

			$terms    = get_the_terms( get_the_ID(), 'spn_project_category' );
			$category = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';

			$recent_projects[] = array(
				'title'     => get_the_title(),
				'image_url' => get_the_post_thumbnail_url( get_the_ID(), 'large' ),
				'category'  => $category,
				'url'       => get_permalink(),
			);
		endwhile;

		wp_reset_postdata();
		?>

		<section class="section section--surface">
			<div class="container stack stack--lg">

				<?php
				spn_cabinets_component(
					'components/section-heading',
					array(
						'kicker'      => __( 'Portfolio', 'spn-cabinets' ),
						'title'       => __( 'Recent Installations', 'spn-cabinets' ),
						'description' => __( 'Explore our latest custom builds.', 'spn-cabinets' ),
						'alignment'   => 'center',
					)
				);

				spn_cabinets_component(
					'components/gallery-grid',
					array(
						'columns'  => 3,
						'projects' => $recent_projects,
					)
				);
				?>

				<div class="text-center">
					<?php
					spn_cabinets_component(
						'buttons/button',
						array(
							'label'   => __( 'View All Projects', 'spn-cabinets' ),
							'url'     => home_url( '/portfolio/' ),
							'variant' => 'outline',
							'size'    => 'lg',
						)
					);
					?>
				</div>

			</div>
		</section>

		<?php
	endif;
	?>

	<?php // 5) TESTIMONIALS. ?>
	<section class="section">
		<div class="container stack stack--lg">

			<?php
			spn_cabinets_component(
				'components/section-heading',
				array(
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
	// 6) FINAL CTA.
	spn_cabinets_component(
		'components/cta',
		array(
			'title'       => __( 'Ready to start your dream project?', 'spn-cabinets' ),
			'button_text' => __( 'Get a Free Quote', 'spn-cabinets' ),
			'button_url'  => home_url( '/quote/' ),
			'theme'       => 'primary',
			'alignment'   => 'center',
		)
	);
	?>

</main><!-- #primary -->

<?php
get_footer();
