<?php
/**
 * Advanced Custom Fields — field groups (registered in PHP).
 *
 * Field definitions live in code (committed to the repo), not the database, so
 * they deploy with the theme and stay version-controlled. Everything is guarded
 * by function_exists() so the theme never fatals if ACF is deactivated.
 *
 * NOTE: the `gallery` field type requires **ACF PRO**. With ACF free the group
 * still registers, but the gallery control won't render.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the "Project Details" field group for the spn_project CPT.
 *
 * Hooked to `acf/init` (fires only when ACF is loaded) AND guarded with
 * function_exists() for belt-and-braces safety.
 *
 * @since 1.0.0
 * @return void
 */
function spn_cabinets_register_project_fields() {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_spn_project_details',
			'title'                 => __( 'Project Details', 'spn-cabinets' ),
			'fields'                => array(

				// Gallery — the portfolio images (ACF PRO). Return an array of
				// image data so templates can build responsive markup.
				array(
					'key'           => 'field_spn_project_gallery',
					'label'         => __( 'Project Gallery', 'spn-cabinets' ),
					'name'          => 'project_gallery',
					'type'          => 'gallery',
					'instructions'  => __( 'Upload the photos of this installation. Used by the gallery/masonry layout. The featured image is the card thumbnail.', 'spn-cabinets' ),
					'required'      => 0,
					'return_format' => 'array',
					'preview_size'  => 'medium',
					'insert'        => 'append',
					'library'       => 'all',
					'min'           => '',
					'max'           => '',
					'mime_types'    => '',
				),

				// Location.
				array(
					'key'          => 'field_spn_project_location',
					'label'        => __( 'Location', 'spn-cabinets' ),
					'name'         => 'project_location',
					'type'         => 'text',
					'instructions' => __( 'e.g. Manchester, UK', 'spn-cabinets' ),
					'required'     => 0,
				),

				// Materials.
				array(
					'key'          => 'field_spn_project_materials',
					'label'        => __( 'Materials', 'spn-cabinets' ),
					'name'         => 'project_materials',
					'type'         => 'textarea',
					'instructions' => __( 'e.g. Solid Oak, Quartz Worktops', 'spn-cabinets' ),
					'required'     => 0,
					'rows'         => 3,
					'new_lines'    => 'wpautop',
				),

				// Client (optional).
				array(
					'key'          => 'field_spn_project_client',
					'label'        => __( 'Client', 'spn-cabinets' ),
					'name'         => 'project_client',
					'type'         => 'text',
					'instructions' => __( 'Optional — the client or household name.', 'spn-cabinets' ),
					'required'     => 0,
				),

				// Completion year (optional).
				array(
					'key'          => 'field_spn_project_completion_year',
					'label'        => __( 'Completion Year', 'spn-cabinets' ),
					'name'         => 'project_completion_year',
					'type'         => 'text',
					'instructions' => __( 'Optional — e.g. 2025', 'spn-cabinets' ),
					'required'     => 0,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'spn_project',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => true, // Expose fields to REST (future-proofing).
			'description'           => '',
		)
	);
}
add_action( 'acf/init', 'spn_cabinets_register_project_fields' );
