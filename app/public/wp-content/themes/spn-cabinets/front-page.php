<?php
/**
 * The front page (homepage) template.
 *
 * Used automatically when the site's front page is set to display a static
 * page (Settings → Reading). This is a structural shell only — the individual
 * homepage sections (hero, services, portfolio, testimonials, quote CTA, etc.)
 * will be added as reusable template parts during the build phase.
 *
 * Intentionally contains NO placeholder sections or design.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="primary" class="site-main site-main--front-page" role="main">

		<?php
		/*
		 * Homepage sections will be composed here during the build phase, e.g.:
		 *
		 *   spn_cabinets_component( 'hero/hero', array( ... ) );
		 *   spn_cabinets_component( 'sections/services', array( ... ) );
		 *   spn_cabinets_component( 'sections/portfolio', array( ... ) );
		 *   spn_cabinets_component( 'forms/quote-cta', array( ... ) );
		 *
		 * Left empty for now so the foundation ships without placeholder content.
		 */
		?>

	</main><!-- #primary .site-main -->

<?php
get_footer();
