<?php
/**
 * The template for displaying 404 (page not found) errors.
 *
 * Provides accessible fallbacks — a heading, a search form and a link home —
 * so a lost visitor can quickly recover. Styling is applied during the build.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="primary" class="site-main site-main--404" role="main">

		<section class="error-404 not-found">

			<header class="page-header">
				<h1 class="page-title">
					<?php esc_html_e( 'Page not found', 'spn-cabinets' ); ?>
				</h1>
			</header>

			<div class="page-content">
				<p>
					<?php esc_html_e( 'Sorry, the page you were looking for could not be found. It may have moved, or the address may be incorrect.', 'spn-cabinets' ); ?>
				</p>

				<?php get_search_form(); ?>

				<p>
					<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php esc_html_e( 'Back to homepage', 'spn-cabinets' ); ?>
					</a>
				</p>
			</div><!-- .page-content -->

		</section><!-- .error-404 -->

	</main><!-- #primary .site-main -->

<?php
get_footer();
