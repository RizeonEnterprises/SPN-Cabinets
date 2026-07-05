<?php
/**
 * Single Project template (spn_project).
 *
 * Displays one portfolio item, assembled entirely from reusable components:
 * Hero (image + category subtitle) → Project specs (description + ACF details
 * card) → Project gallery (Section Heading + Gallery Grid) → CTA band.
 *
 * ACF fields are read through spn_cabinets_field() so the page degrades
 * gracefully (no fatal) when ACF is inactive.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	// --- Gather data -------------------------------------------------------

	// Hero subtitle: the primary (first) project category term.
	$terms        = get_the_terms( get_the_ID(), 'spn_project_category' );
	$primary_term = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';

	// Hero background: the featured image (hero falls back to solid if empty).
	$hero_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	$hero_image = $hero_image ? $hero_image : '';

	// ACF details (null-safe; only shown when present).
	$location  = spn_cabinets_field( 'project_location' );
	$materials = spn_cabinets_field( 'project_materials' );
	$client    = spn_cabinets_field( 'project_client' );
	$year      = spn_cabinets_field( 'project_completion_year' );
	$has_details = ( $location || $materials || $client || $year );

	// ACF gallery → project-card args for the Gallery Grid.
	$gallery       = spn_cabinets_field( 'project_gallery' );
	$gallery_items = array();
	if ( is_array( $gallery ) ) {
		foreach ( $gallery as $image ) {
			if ( ! is_array( $image ) ) {
				continue;
			}
			$img_url = '';
			if ( ! empty( $image['sizes']['large'] ) ) {
				$img_url = $image['sizes']['large'];
			} elseif ( ! empty( $image['url'] ) ) {
				$img_url = $image['url'];
			}
			if ( '' === $img_url ) {
				continue;
			}
			// Caption: alt → title → caption → project title.
			$caption = '';
			foreach ( array( 'alt', 'title', 'caption' ) as $field ) {
				if ( ! empty( $image[ $field ] ) ) {
					$caption = $image[ $field ];
					break;
				}
			}
			if ( '' === $caption ) {
				$caption = get_the_title();
			}
			$gallery_items[] = array(
				'title'     => $caption,
				'image_url' => $img_url,
				'image_alt' => ! empty( $image['alt'] ) ? $image['alt'] : $caption,
			);
		}
	}
	?>

	<main id="primary" class="site-main site-main--flush" role="main">

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'project-single' ); ?>>

			<?php
			// 1) HERO — the project title (page h1) over the featured image.
			spn_cabinets_component(
				'hero/hero',
				array(
					'title'                => get_the_title(),
					'title_tag'            => 'h1',
					'subtitle'             => $primary_term,
					'alignment'            => 'center',
					'background_type'      => 'image',
					'background_image_url' => $hero_image,
				)
			);
			?>

			<?php // 2) PROJECT SPECS — description + details card. ?>
			<section class="section">
				<div class="container">
					<div class="project-specs<?php echo $has_details ? ' grid grid-md-2' : ''; ?>">

						<div class="entry-content">
							<?php the_content(); ?>
						</div>

						<?php if ( $has_details ) : ?>
							<aside class="project-details bg-surface radius-md p-lg stack">
								<h2 class="project-details__title fs-lg"><?php esc_html_e( 'Project Details', 'spn-cabinets' ); ?></h2>
								<dl class="project-details__list">
									<?php if ( $location ) : ?>
										<dt><?php esc_html_e( 'Location', 'spn-cabinets' ); ?></dt>
										<dd><?php echo esc_html( $location ); ?></dd>
									<?php endif; ?>
									<?php if ( $materials ) : ?>
										<dt><?php esc_html_e( 'Materials', 'spn-cabinets' ); ?></dt>
										<dd><?php echo esc_html( $materials ); ?></dd>
									<?php endif; ?>
									<?php if ( $client ) : ?>
										<dt><?php esc_html_e( 'Client', 'spn-cabinets' ); ?></dt>
										<dd><?php echo esc_html( $client ); ?></dd>
									<?php endif; ?>
									<?php if ( $year ) : ?>
										<dt><?php esc_html_e( 'Completion Year', 'spn-cabinets' ); ?></dt>
										<dd><?php echo esc_html( $year ); ?></dd>
									<?php endif; ?>
								</dl>
							</aside>
						<?php endif; ?>

					</div>
				</div>
			</section>

			<?php // 3) PROJECT GALLERY — only when the ACF gallery has images. ?>
			<?php if ( ! empty( $gallery_items ) ) : ?>
				<section class="section section--surface">
					<div class="container stack stack--lg">
						<?php
						spn_cabinets_component(
							'components/section-heading',
							array(
								'title'     => __( 'Project Gallery', 'spn-cabinets' ),
								'title_tag' => 'h2',
								'alignment' => 'center',
							)
						);

						spn_cabinets_component(
							'components/gallery-grid',
							array(
								'columns'  => 3,
								'projects' => $gallery_items,
							)
						);
						?>
					</div>
				</section>
			<?php endif; ?>

		</article>

		<?php
		// 4) CTA — conversion band before the footer.
		spn_cabinets_component(
			'components/cta',
			array(
				'title'       => __( 'Ready to start your project?', 'spn-cabinets' ),
				'button_text' => __( 'Get a Free Quote', 'spn-cabinets' ),
				'button_url'  => home_url( '/quote/' ),
				'theme'       => 'primary',
				'alignment'   => 'center',
			)
		);
		?>

	</main><!-- #primary -->

	<?php
endwhile;

get_footer();
