<?php
/**
 * Project Archive template (spn_project) — the /portfolio/ page.
 *
 * Hero → portfolio grid (main query looped into the reusable Gallery Grid) →
 * pagination → CTA band. Assembled from reusable components; all output escaped.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main site-main--flush" role="main">

	<?php
	// 1) HERO — solid brand band (the hero's solid variant is the primary theme).
	spn_cabinets_component(
		'hero/hero',
		array(
			'title'           => __( 'Our Portfolio', 'spn-cabinets' ),
			'title_tag'       => 'h1',
			'alignment'       => 'center',
			'background_type' => 'solid',
		)
	);
	?>

	<section class="section">
		<div class="container">

			<?php if ( have_posts() ) : ?>

				<?php
				// 2) Build the project card data from the main query.
				$portfolio_projects = array();

				while ( have_posts() ) :
					the_post();

					$terms    = get_the_terms( get_the_ID(), 'spn_project_category' );
					$category = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';

					$portfolio_projects[] = array(
						'title'     => get_the_title(),
						'image_url' => get_the_post_thumbnail_url( get_the_ID(), 'large' ),
						'category'  => $category,
						'url'       => get_permalink(),
					);
				endwhile;

				// 3) Hand the collected data to the reusable Gallery Grid.
				spn_cabinets_component(
					'components/gallery-grid',
					array(
						'columns'  => 3,
						'projects' => $portfolio_projects,
					)
				);

				// 4) Native pagination (styled via components/pagination.css).
				the_posts_pagination(
					array(
						'mid_size'           => 1,
						'prev_text'          => __( 'Previous', 'spn-cabinets' ),
						'next_text'          => __( 'Next', 'spn-cabinets' ),
						'screen_reader_text' => __( 'Projects navigation', 'spn-cabinets' ),
						'aria_label'         => __( 'Projects', 'spn-cabinets' ),
					)
				);
				?>

			<?php else : ?>

				<p class="text-center text-muted">
					<?php esc_html_e( 'No projects have been added yet. Please check back soon.', 'spn-cabinets' ); ?>
				</p>

			<?php endif; ?>

		</div>
	</section>

	<?php
	// 5) CTA — conversion band before the footer.
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
