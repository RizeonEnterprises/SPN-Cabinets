<?php
/**
 * Template Name: Get a Quote
 *
 * A dedicated, focused quote page: Hero → the reusable Quote Form in a narrow,
 * centred column. Wrapped in the loop so the form's get_permalink() redirect
 * resolves back to this page.
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
				'title'           => __( 'Get a Free Quote', 'spn-cabinets' ),
				'title_tag'       => 'h1',
				'subtitle'        => __( 'Tell us about your project and we will get back to you within 24 hours.', 'spn-cabinets' ),
				'alignment'       => 'center',
				'background_type' => 'solid',
			)
		);
		?>

		<?php // 2) FORM — narrow, centred column. ?>
		<section class="section">
			<div class="container container--narrow">
				<?php spn_cabinets_component( 'forms/quote-form' ); ?>
			</div>
		</section>

	</main><!-- #primary -->

	<?php
endwhile;

get_footer();
