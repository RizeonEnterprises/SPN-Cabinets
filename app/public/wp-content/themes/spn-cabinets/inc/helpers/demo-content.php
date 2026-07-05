<?php
/**
 * Demo / placeholder content.
 *
 * TEMPORARY mock data used to build out pages (Services hub, Homepage) before
 * real content exists. Shared so the two templates never drift.
 *
 * REMOVE this module (and its functions.php loader entry) once services and
 * testimonials are sourced from real content / CPTs / ACF.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Placeholder services (feeds the Service Card component).
 *
 * @since 1.0.0
 * @param int $limit Optional. Max items to return (0 = all).
 * @return array[] Array of service-card arg arrays.
 */
function spn_cabinets_mock_services( $limit = 0 ) {
	$services = array(
		array(
			'title'       => __( 'Bespoke Kitchens', 'spn-cabinets' ),
			'icon'        => 'home',
			'image_url'   => 'https://placehold.co/800x600/eeeeee/555555?text=Bespoke+Kitchens',
			'description' => __( 'Handcrafted kitchens designed around how you live — from classic shaker to sleek handleless.', 'spn-cabinets' ),
			'url'         => home_url( '/services/fitted-kitchens/' ),
		),
		array(
			'title'       => __( 'Fitted Bedrooms', 'spn-cabinets' ),
			'icon'        => 'layers',
			'image_url'   => 'https://placehold.co/800x600/eeeeee/555555?text=Fitted+Bedrooms',
			'description' => __( 'Made-to-measure wardrobes and storage that make the most of every inch of your space.', 'spn-cabinets' ),
			'url'         => home_url( '/services/fitted-bedrooms/' ),
		),
		array(
			'title'       => __( 'Home Offices', 'spn-cabinets' ),
			'icon'        => 'briefcase',
			'image_url'   => 'https://placehold.co/800x600/eeeeee/555555?text=Home+Offices',
			'description' => __( 'Purpose-built desks, shelving and storage for a workspace that works as hard as you do.', 'spn-cabinets' ),
			'url'         => home_url( '/services/home-offices/' ),
		),
		array(
			'title'       => __( 'Media Walls', 'spn-cabinets' ),
			'icon'        => 'monitor',
			'image_url'   => 'https://placehold.co/800x600/eeeeee/555555?text=Media+Walls',
			'description' => __( 'Statement media walls with integrated storage and hidden cable management, built to fit.', 'spn-cabinets' ),
			'url'         => home_url( '/services/media-walls/' ),
		),
	);

	return ( $limit > 0 ) ? array_slice( $services, 0, (int) $limit ) : $services;
}

/**
 * Placeholder testimonials (feeds the Testimonial Card component).
 *
 * @since 1.0.0
 * @param int $limit Optional. Max items to return (0 = all).
 * @return array[] Array of testimonial-card arg arrays.
 */
function spn_cabinets_mock_testimonials( $limit = 0 ) {
	$testimonials = array(
		array(
			'quote'        => __( 'The team transformed our kitchen beyond our expectations. The craftsmanship is impeccable and the whole process, from design to installation, was seamless.', 'spn-cabinets' ),
			'author_name'  => __( 'Sarah & James Thompson', 'spn-cabinets' ),
			'service_name' => __( 'Fitted Kitchen', 'spn-cabinets' ),
			'rating'       => 5,
		),
		array(
			'quote'        => __( 'Our new fitted wardrobes are stunning and have completely changed how we use our bedroom. Professional, tidy and a pleasure to work with throughout.', 'spn-cabinets' ),
			'author_name'  => __( 'Emma Roberts', 'spn-cabinets' ),
			'service_name' => __( 'Fitted Bedroom', 'spn-cabinets' ),
			'rating'       => 5,
		),
		array(
			'quote'        => __( 'SPN built a bespoke media wall and home office for us. The attention to detail is second to none — we honestly could not be happier with the result.', 'spn-cabinets' ),
			'author_name'  => __( 'David Chen', 'spn-cabinets' ),
			'service_name' => __( 'Bespoke Cabinets', 'spn-cabinets' ),
			'rating'       => 5,
		),
	);

	return ( $limit > 0 ) ? array_slice( $testimonials, 0, (int) $limit ) : $testimonials;
}
