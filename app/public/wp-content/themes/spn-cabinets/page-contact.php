<?php
/**
 * Template Name: Contact Page
 *
 * The Contact page: Hero → two-column layout (contact details from the
 * site-options helper + the reusable Quote Form). Assembled from reusable
 * components/helpers. The loop runs so the form's get_permalink() redirect
 * resolves to this page.
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
				'title'           => __( 'Contact Us', 'spn-cabinets' ),
				'title_tag'       => 'h1',
				'subtitle'        => __( 'Let\'s discuss your next project.', 'spn-cabinets' ),
				'alignment'       => 'center',
				'background_type' => 'solid',
			)
		);
		?>

		<?php // 2) CONTACT — details + form. ?>
		<section class="section">
			<div class="container">
				<div class="grid grid-md-2 items-start">

					<?php // Column 1 — contact details (from site-options.php). ?>
					<div class="contact-info stack">
						<h2 class="fs-lg"><?php esc_html_e( 'Get in touch', 'spn-cabinets' ); ?></h2>
						<p class="text-muted">
							<?php esc_html_e( 'Prefer to talk it through? Reach us directly and we will get right back to you.', 'spn-cabinets' ); ?>
						</p>

						<div class="contact-info__list flex flex-col gap-sm">
							<?php
							spn_cabinets_contact_item( 'phone' );
							spn_cabinets_contact_item( 'email' );
							spn_cabinets_contact_item( 'whatsapp' );
							spn_cabinets_contact_item( 'address' );
							?>
						</div>
					</div>

					<?php // Column 2 — the reusable Quote Form. ?>
					<div class="contact-form">
						<h2 class="fs-lg"><?php esc_html_e( 'Request a free quote', 'spn-cabinets' ); ?></h2>
						<?php spn_cabinets_component( 'forms/quote-form' ); ?>
					</div>

				</div>
			</div>
		</section>

	</main><!-- #primary -->

	<?php
endwhile;

get_footer();
