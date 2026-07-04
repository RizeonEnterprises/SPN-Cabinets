<?php
/**
 * The main template file — universal fallback.
 *
 * This is the most generic template in the WordPress hierarchy and is used
 * whenever a more specific template (front-page, page, single, archive…) is
 * not matched. It is intentionally minimal: it establishes the page landmarks
 * and runs the loop. No design or placeholder sections are included here — the
 * visual layer is added during the build phase.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="primary" class="site-main" role="main">

		<?php
		if ( have_posts() ) :

			while ( have_posts() ) :
				the_post();

				/*
				 * Content is rendered via a reusable template part so post,
				 * page and archive views share consistent markup. The part
				 * receives the current post from the loop.
				 */
				the_title( '<h2 class="entry-title">', '</h2>' );
				the_content();

			endwhile;

			// Paginated archives / blog index navigation.
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => esc_html__( 'Previous', 'spn-cabinets' ),
					'next_text' => esc_html__( 'Next', 'spn-cabinets' ),
				)
			);

		else :

			echo '<p>' . esc_html__( 'Nothing found.', 'spn-cabinets' ) . '</p>';

		endif;
		?>

	</main><!-- #primary .site-main -->

<?php
get_footer();
