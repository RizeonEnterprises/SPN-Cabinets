<?php
/**
 * Custom post types & taxonomies.
 *
 * Registers the portfolio content model:
 *   - `spn_project`          — a completed installation (singular /project/{slug}/,
 *                              archive /portfolio/).
 *   - `spn_project_category` — hierarchical categories for projects
 *                              (/project-category/{term}/).
 *
 * Registered on `init`. Rewrite rules are flushed on theme (re)activation via
 * `after_switch_theme`; there is no per-request flush (that would be a
 * performance bug).
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the Project custom post type.
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_register_project_post_type() {

	$labels = array(
		'name'                  => _x( 'Projects', 'post type general name', 'spn-cabinets' ),
		'singular_name'         => _x( 'Project', 'post type singular name', 'spn-cabinets' ),
		'menu_name'             => _x( 'Projects', 'admin menu', 'spn-cabinets' ),
		'name_admin_bar'        => _x( 'Project', 'add new on admin bar', 'spn-cabinets' ),
		'add_new'               => __( 'Add New', 'spn-cabinets' ),
		'add_new_item'          => __( 'Add New Project', 'spn-cabinets' ),
		'new_item'              => __( 'New Project', 'spn-cabinets' ),
		'edit_item'             => __( 'Edit Project', 'spn-cabinets' ),
		'view_item'             => __( 'View Project', 'spn-cabinets' ),
		'view_items'            => __( 'View Projects', 'spn-cabinets' ),
		'all_items'             => __( 'All Projects', 'spn-cabinets' ),
		'search_items'          => __( 'Search Projects', 'spn-cabinets' ),
		'parent_item_colon'     => __( 'Parent Projects:', 'spn-cabinets' ),
		'not_found'             => __( 'No projects found.', 'spn-cabinets' ),
		'not_found_in_trash'    => __( 'No projects found in Trash.', 'spn-cabinets' ),
		'archives'              => __( 'Project Archives', 'spn-cabinets' ),
		'insert_into_item'      => __( 'Insert into project', 'spn-cabinets' ),
		'uploaded_to_this_item' => __( 'Uploaded to this project', 'spn-cabinets' ),
		'featured_image'        => __( 'Project image', 'spn-cabinets' ),
		'set_featured_image'    => __( 'Set project image', 'spn-cabinets' ),
		'remove_featured_image' => __( 'Remove project image', 'spn-cabinets' ),
		'use_featured_image'    => __( 'Use as project image', 'spn-cabinets' ),
		'items_list'            => __( 'Projects list', 'spn-cabinets' ),
		'items_list_navigation' => __( 'Projects list navigation', 'spn-cabinets' ),
		'filter_items_list'     => __( 'Filter projects list', 'spn-cabinets' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true, // Block editor + REST (future-proofing).
		'menu_position'      => 20,
		'menu_icon'          => 'dashicons-portfolio',
		'hierarchical'       => false,
		'has_archive'        => 'portfolio', // Archive lives at /portfolio/.
		'rewrite'            => array(
			'slug'       => 'project', // Singles at /project/{slug}/.
			'with_front' => false,
		),
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
	);

	register_post_type( 'spn_project', $args );
}
add_action( 'init', 'spn_cabinets_register_project_post_type' );

/**
 * Register the Project Category taxonomy (hierarchical).
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_register_project_taxonomy() {

	$labels = array(
		'name'              => _x( 'Project Categories', 'taxonomy general name', 'spn-cabinets' ),
		'singular_name'     => _x( 'Project Category', 'taxonomy singular name', 'spn-cabinets' ),
		'menu_name'         => __( 'Categories', 'spn-cabinets' ),
		'all_items'         => __( 'All Categories', 'spn-cabinets' ),
		'parent_item'       => __( 'Parent Category', 'spn-cabinets' ),
		'parent_item_colon' => __( 'Parent Category:', 'spn-cabinets' ),
		'new_item_name'     => __( 'New Category Name', 'spn-cabinets' ),
		'add_new_item'      => __( 'Add New Category', 'spn-cabinets' ),
		'edit_item'         => __( 'Edit Category', 'spn-cabinets' ),
		'update_item'       => __( 'Update Category', 'spn-cabinets' ),
		'view_item'         => __( 'View Category', 'spn-cabinets' ),
		'search_items'      => __( 'Search Categories', 'spn-cabinets' ),
		'not_found'         => __( 'No categories found.', 'spn-cabinets' ),
		'back_to_items'     => __( 'Back to categories', 'spn-cabinets' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true, // Behaves like categories, not tags.
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_in_rest'      => true,
		'rewrite'           => array(
			'slug'         => 'project-category',
			'with_front'   => false,
			'hierarchical' => true,
		),
	);

	register_taxonomy( 'spn_project_category', array( 'spn_project' ), $args );
}
add_action( 'init', 'spn_cabinets_register_project_taxonomy' );

/**
 * Flush rewrite rules on theme (re)activation.
 *
 * Ensures the /portfolio/, /project/{slug}/ and /project-category/{term}/ URLs
 * resolve immediately after the theme is activated — without flushing on every
 * request. Registers the CPT + taxonomy first so their rules exist before the flush.
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_flush_rewrite_on_activation() {
	spn_cabinets_register_project_post_type();
	spn_cabinets_register_project_taxonomy();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'spn_cabinets_flush_rewrite_on_activation' );
