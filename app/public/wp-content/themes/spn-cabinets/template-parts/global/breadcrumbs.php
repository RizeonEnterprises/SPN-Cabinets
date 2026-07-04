<?php
/**
 * Template part: Breadcrumbs (placeholder / baseline).
 *
 * A lightweight, accessible breadcrumb trail for inner pages. This is a
 * baseline placeholder: it covers the common cases (pages + ancestors, single
 * posts, archives, search, 404) so the shell has a working breadcrumb, and it
 * can be disabled via the `spn_cabinets_show_breadcrumbs` filter when an SEO
 * plugin takes over. Emits a structure ready for BreadcrumbList schema later.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// Never on the front page; allow disabling via filter (e.g. SEO plugin owns it).
$show = ! is_front_page() && ! is_home();
if ( ! apply_filters( 'spn_cabinets_show_breadcrumbs', $show ) ) {
	return;
}

$home_label = __( 'Home', 'spn-cabinets' );
$crumbs     = array();

// Always start at Home.
$crumbs[] = array(
	'label' => $home_label,
	'url'   => home_url( '/' ),
);

if ( is_page() ) {
	// Page ancestors (top-down), then the current page.
	$ancestors = array_reverse( get_post_ancestors( get_queried_object_id() ) );
	foreach ( $ancestors as $ancestor_id ) {
		$crumbs[] = array(
			'label' => get_the_title( $ancestor_id ),
			'url'   => get_permalink( $ancestor_id ),
		);
	}
	$crumbs[] = array( 'label' => get_the_title(), 'url' => '' );

} elseif ( is_singular() ) {
	// Single post / CPT: link the post type archive if it has one.
	$post_type   = get_post_type();
	$archive_link = get_post_type_archive_link( $post_type );
	if ( $archive_link && 'post' !== $post_type ) {
		$obj = get_post_type_object( $post_type );
		$crumbs[] = array(
			'label' => $obj && isset( $obj->labels->name ) ? $obj->labels->name : $post_type,
			'url'   => $archive_link,
		);
	}
	$crumbs[] = array( 'label' => get_the_title(), 'url' => '' );

} elseif ( is_search() ) {
	$crumbs[] = array(
		/* translators: %s: search query. */
		'label' => sprintf( __( 'Search results for "%s"', 'spn-cabinets' ), get_search_query() ),
		'url'   => '',
	);

} elseif ( is_404() ) {
	$crumbs[] = array( 'label' => __( 'Page not found', 'spn-cabinets' ), 'url' => '' );

} elseif ( is_archive() ) {
	$crumbs[] = array( 'label' => wp_strip_all_tags( get_the_archive_title() ), 'url' => '' );
}

/**
 * Filter the breadcrumb items before rendering.
 *
 * @since 1.0.0
 * @param array $crumbs Ordered list of { label, url } items.
 */
$crumbs = apply_filters( 'spn_cabinets_breadcrumbs_items', $crumbs );

if ( count( $crumbs ) < 2 ) {
	return; // Only "Home" — nothing useful to show.
}

$last = count( $crumbs ) - 1;
?>
<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'spn-cabinets' ); ?>">
	<div class="breadcrumbs__inner container">
		<ol class="breadcrumbs__list">
			<?php foreach ( $crumbs as $index => $crumb ) : ?>
				<li class="breadcrumbs__item">
					<?php if ( $index !== $last && ! empty( $crumb['url'] ) ) : ?>
						<a class="breadcrumbs__link" href="<?php echo esc_url( $crumb['url'] ); ?>">
							<?php echo esc_html( $crumb['label'] ); ?>
						</a>
					<?php else : ?>
						<span class="breadcrumbs__current" aria-current="page">
							<?php echo esc_html( $crumb['label'] ); ?>
						</span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</nav><!-- .breadcrumbs -->
