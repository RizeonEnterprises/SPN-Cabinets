<?php
/**
 * The template for displaying archive pages.
 *
 * Covers category, tag, date, author and custom-post-type archives. Uses core
 * helpers (the_archive_title / the_archive_description) so it works for any
 * archive type without modification.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="primary" class="site-main site-main--archive" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="archive-header">
				<?php
				the_archive_title( '<h1 class="archive-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header>

			<div class="archive-list">
				<?php
				while ( have_posts() ) :
					the_post();

					/*
					 * Each result is rendered with the reusable card component so
					 * archives stay visually consistent with the rest of the site.
					 * Populated with the current post's data.
					 */
					spn_cabinets_component(
						'cards/card',
						array(
							'title'     => get_the_title(),
							'url'       => get_permalink(),
							'image_id'  => get_post_thumbnail_id(),
							'image_size' => 'medium_large',
							'excerpt'   => spn_cabinets_get_excerpt( 24 ),
						)
					);

				endwhile;
				?>
			</div><!-- .archive-list -->

			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => esc_html__( 'Previous', 'spn-cabinets' ),
					'next_text' => esc_html__( 'Next', 'spn-cabinets' ),
				)
			);
			?>

		<?php else : ?>

			<p><?php esc_html_e( 'No results found.', 'spn-cabinets' ); ?></p>

		<?php endif; ?>

	</main><!-- #primary .site-main -->

<?php
get_footer();
