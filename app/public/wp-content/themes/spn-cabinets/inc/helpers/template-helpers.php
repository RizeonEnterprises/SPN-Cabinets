<?php
/**
 * Reusable template helper functions.
 *
 * Small, focused, escape-safe helpers used across template files and template
 * parts. Keeping them here keeps the templates themselves clean and readable.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Render a template part while passing data to it.
 *
 * Thin wrapper around get_template_part() that gives our component parts a
 * consistent, self-documenting call signature. Uses the WP 5.5+ `$args`
 * mechanism so parts receive data via the `$args` variable.
 *
 * @since 1.0.0
 *
 * @param string $slug Directory + slug relative to /template-parts, e.g. "cards/card".
 * @param array  $args Optional. Data made available to the part as `$args`.
 * @return void
 */
function spn_cabinets_component( $slug, array $args = array() ) {
	get_template_part( 'template-parts/' . $slug, null, $args );
}

/**
 * Determine whether a given nav-menu location has an assigned menu.
 *
 * Handy for conditionally rendering navigation wrappers only when the client
 * has actually populated a menu location.
 *
 * @since 1.0.0
 *
 * @param string $location The registered nav-menu location slug.
 * @return bool True if a menu is assigned to the location.
 */
function spn_cabinets_has_menu( $location ) {
	$locations = get_nav_menu_locations();
	return isset( $locations[ $location ] ) && (bool) $locations[ $location ];
}

/**
 * Output the site logo, falling back to a linked site title.
 *
 * Centralises branding output so header/footer parts stay consistent. If a
 * custom logo has been set it is used; otherwise the site title is printed as
 * an accessible, home-linked heading appropriate to the current view.
 *
 * @since 1.0.0
 *
 * @param array $args {
 *     Optional. Branding options.
 *
 *     @type bool   $is_home_heading Whether to wrap the title in <h1> (front page).
 *                                   Default false (uses <p>).
 *     @type string $class           Extra class for the wrapper. Default ''.
 * }
 * @return void
 */
function spn_cabinets_site_branding( array $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'is_home_heading' => false,
			'class'           => '',
		)
	);

	$wrapper_class = trim( 'site-branding ' . $args['class'] );

	echo '<div class="' . esc_attr( $wrapper_class ) . '">';

	if ( has_custom_logo() ) {
		the_custom_logo();
	} else {
		$tag         = $args['is_home_heading'] ? 'h1' : 'p';
		$site_name   = get_bloginfo( 'name', 'display' );
		$description = get_bloginfo( 'description', 'display' );

		printf(
			'<%1$s class="site-title"><a href="%2$s" rel="home">%3$s</a></%1$s>',
			tag_escape( $tag ),
			esc_url( home_url( '/' ) ),
			esc_html( $site_name )
		);

		if ( $description ) {
			printf(
				'<p class="site-description">%s</p>',
				esc_html( $description )
			);
		}
	}

	echo '</div><!-- .site-branding -->';
}

/**
 * Return a trimmed, safe excerpt of arbitrary length.
 *
 * @since 1.0.0
 *
 * @param int         $words  Number of words to keep. Default 24.
 * @param int|WP_Post $post   Optional. Post ID or object. Default current post.
 * @return string Escaped, trimmed excerpt text.
 */
function spn_cabinets_get_excerpt( $words = 24, $post = null ) {
	$post = get_post( $post );

	if ( ! $post ) {
		return '';
	}

	$text = has_excerpt( $post ) ? $post->post_excerpt : $post->post_content;
	$text = wp_strip_all_tags( strip_shortcodes( $text ) );

	return esc_html( wp_trim_words( $text, absint( $words ), '&hellip;' ) );
}

/**
 * Echo the current year, for copyright notices.
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_copyright_year() {
	echo esc_html( wp_date( 'Y' ) );
}

/**
 * Get an ACF field value safely, whether or not ACF is active.
 *
 * Wraps get_field() with a function_exists() guard so templates that read ACF
 * data never fatal when the plugin is deactivated — they just get null.
 *
 * @since 1.0.0
 *
 * @param string   $selector The ACF field name or key.
 * @param int|bool $post_id  Optional. Post ID. Default current post.
 * @return mixed|null Field value, or null if ACF is unavailable.
 */
function spn_cabinets_field( $selector, $post_id = false ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}
	return get_field( $selector, $post_id );
}

/**
 * Render a footer navigation menu, or a placeholder list if none is assigned.
 *
 * Keeps the footer columns visibly populated in the shell before the client has
 * built their menus, without shipping dead links (placeholders are non-links).
 *
 * @since 1.0.0
 *
 * @param string $location          Registered nav-menu location slug.
 * @param int    $placeholder_count Number of placeholder items to show. Default 4.
 * @return void
 */
function spn_cabinets_footer_menu( $location, $placeholder_count = 4 ) {
	if ( spn_cabinets_has_menu( $location ) ) {
		wp_nav_menu(
			array(
				'theme_location' => $location,
				'menu_class'     => 'footer-menu',
				'container'      => false,
				'depth'          => 1,
				'fallback_cb'    => false,
			)
		);
		return;
	}

	// Placeholder list (non-interactive) until a menu is assigned.
	echo '<ul class="footer-menu footer-menu--placeholder">';
	for ( $i = 0; $i < absint( $placeholder_count ); $i++ ) {
		echo '<li class="menu-item is-placeholder"><span>' . esc_html__( 'Menu item', 'spn-cabinets' ) . '</span></li>';
	}
	echo '</ul>';
}
