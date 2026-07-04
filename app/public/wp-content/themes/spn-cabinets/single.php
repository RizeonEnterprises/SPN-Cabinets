<?php
/**
 * The template for displaying single posts.
 *
 * Used for blog posts and — until a dedicated single-{cpt}.php is added — any
 * future custom post type such as portfolio "projects".
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="primary" class="site-main site-main--single" role="main">

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry--single' ); ?>>

				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					<div class="entry-meta">
						<?php
						printf(
							/* translators: %s: post publish date. */
							esc_html__( 'Published %s', 'spn-cabinets' ),
							'<time class="entry-date" datetime="' . esc_attr( get_the_date( DATE_W3C ) ) . '">' . esc_html( get_the_date() ) . '</time>'
						);
						?>
					</div><!-- .entry-meta -->
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="entry-thumbnail">
						<?php the_post_thumbnail( 'large' ); ?>
					</figure>
				<?php endif; ?>

				<div class="entry-content">
					<?php
					the_content();

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
			// Post-to-post navigation.
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous', 'spn-cabinets' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next', 'spn-cabinets' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

		endwhile;
		?>

	</main><!-- #primary .site-main -->

<?php
get_footer();
