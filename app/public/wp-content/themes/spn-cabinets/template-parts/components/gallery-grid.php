<?php
/**
 * Template part: Gallery Grid.
 *
 * Lays out a set of project cards in a pure-CSS-grid "masonry-lite" grid: on
 * desktop the offset column is nudged down to break the rigid horizontal line;
 * on mobile it collapses to a single, un-staggered column. Args-driven; bails
 * without projects. Each project entry is passed straight to the project-card
 * component, so this part contains no card markup of its own.
 *
 * Usage:
 *   spn_cabinets_component( 'components/gallery-grid', array(
 *       'columns'  => 3,               // desktop columns (1–4)
 *       'projects' => array(
 *           array( 'title' => '…', 'image_url' => '…', 'category' => '…', 'url' => '…' ),
 *           array( 'title' => '…', 'image_url' => '…' ),
 *           …
 *       ),
 *   ) );
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 *
 * @var array $args Arguments passed from spn_cabinets_component().
 */

defined( 'ABSPATH' ) || exit;

$defaults = array(
	'projects' => array(),
	'columns'  => 3,
);

$gallery = wp_parse_args( $args ?? array(), $defaults );

// Nothing to lay out without projects.
if ( empty( $gallery['projects'] ) || ! is_array( $gallery['projects'] ) ) {
	return;
}

// Clamp columns to a sensible 1–4 range.
$columns = absint( $gallery['columns'] );
if ( $columns < 1 ) {
	$columns = 3;
}
if ( $columns > 4 ) {
	$columns = 4;
}

$classes = array(
	'gallery-grid',
	'gallery-grid--cols-' . $columns,
);
?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php
	foreach ( $gallery['projects'] as $project ) {
		// Each entry is the args array for a project card; skip anything else.
		if ( is_array( $project ) ) {
			spn_cabinets_component( 'cards/project-card', $project );
		}
	}
	?>
</div><!-- .gallery-grid -->
