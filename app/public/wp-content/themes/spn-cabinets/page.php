<?php
/**
 * The template for displaying single pages.
 *
 * Standard, accessible page shell running the loop. Styling and richer layout
 * are layered on during the build phase.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="primary" class="site-main site-main--page" role="main">

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry--page' ); ?>>

				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header>

				<div class="entry-content">
					<?php
					the_content();

					// Pagination for multi-page content (<!--nextpage-->).
					wp_link_pages(
						array(
							'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'spn-cabinets' ) . '">',
							'after'  => '</nav>',
						)
					);
					?>
				</div><!-- .entry-content -->

			</article><!-- #post-<?php the_ID(); ?> -->

			<?php
			// Comments are typically disabled on brochure pages; render only if open.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

		endwhile;
		?>

	</main><!-- #primary .site-main -->

<?php
get_footer();
