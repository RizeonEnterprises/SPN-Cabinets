<?php
/**
 * Accessible navigation walker.
 *
 * Extends the core Walker_Nav_Menu to add accessibility affordances that a
 * lead-generation site benefits from:
 *   - `aria-current="page"` on the active item.
 *   - A real <button> toggle for each submenu (keyboard + screen-reader friendly)
 *     instead of relying on hover-only reveal.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class SPN_Cabinets_Walker_Nav_Menu
 *
 * @since 1.0.0
 */
class SPN_Cabinets_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Starts the submenu (<ul>) output.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of the menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent  = str_repeat( "\t", $depth );
		$classes = array( 'sub-menu', 'sub-menu--depth-' . ( $depth + 1 ) );

		$output .= "\n{$indent}<ul class=\"" . esc_attr( implode( ' ', $classes ) ) . "\">\n";
	}

	/**
	 * Starts an element (<li>) output.
	 *
	 * Adds an aria-current attribute to the active item and injects an
	 * accessible submenu toggle button after items that have children.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $output            Used to append additional content (by reference).
	 * @param WP_Post  $data_object       Menu item data object.
	 * @param int      $depth             Depth of menu item. Used for padding.
	 * @param stdClass $args              An object of wp_nav_menu() arguments.
	 * @param int      $current_object_id Optional. ID of the current menu item. Default 0.
	 * @return void
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$item   = $data_object;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$has_children = in_array( 'menu-item-has-children', $classes, true );
		if ( $has_children ) {
			$classes[] = 'has-submenu';
		}

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		// Assemble the anchor attributes.
		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		if ( '_blank' === $item->target && empty( $item->xfn ) ) {
			$atts['rel'] = 'noopener noreferrer';
		} else {
			$atts['rel'] = $item->xfn;
		}
		$atts['href'] = ! empty( $item->url ) ? $item->url : '';

		// Accessibility: flag the current page for assistive technology.
		if ( in_array( 'current-menu-item', $classes, true ) ) {
			$atts['aria-current'] = 'page';
		}

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );
		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output  = isset( $args->before ) ? $args->before : '';
		$item_output .= '<a' . $attributes . '>';
		$item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . $title . ( isset( $args->link_after ) ? $args->link_after : '' );
		$item_output .= '</a>';

		// Accessible submenu toggle — progressively enhanced by navigation.js.
		if ( $has_children && 0 === $depth ) {
			$chevron = function_exists( 'spn_cabinets_icon' )
				? spn_cabinets_icon( 'chevron-down', array( 'class' => 'submenu-toggle__chevron' ) )
				: '';

			$item_output .= sprintf(
				'<button type="button" class="submenu-toggle" aria-expanded="false" aria-label="%1$s"><span class="submenu-toggle__icon" aria-hidden="true">%2$s</span></button>',
				esc_attr(
					/* translators: %s: parent menu item title. */
					sprintf( __( 'Open %s submenu', 'spn-cabinets' ), wp_strip_all_tags( $title ) )
				),
				$chevron // Trusted static SVG from the theme icon set.
			);
		}

		$item_output .= isset( $args->after ) ? $args->after : '';

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
