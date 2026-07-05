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
 * Resolve a locally-hosted Media Library image URL by its key.
 *
 * Keys map to attachment IDs stored in the `spn_cabinets_media_map` option
 * (populated when the client's Wix images were imported into the library, so we
 * serve local uploads instead of hot-linking Wix). Falls back to the supplied
 * URL when the image is not present (e.g. a fresh environment without the map).
 *
 * @since 1.0.0
 * @param string $key      Map key, e.g. 'kitchen', 'bedroom', 'media-wall', 'storage'.
 * @param string $fallback URL to use when the local image is unavailable.
 * @param string $size     Registered image size. Default 'large'.
 * @return string Image URL (local when available, otherwise the fallback).
 */
function spn_cabinets_media_url( $key, $fallback = '', $size = 'large' ) {
	$map = get_option( 'spn_cabinets_media_map', array() );

	if ( is_array( $map ) && ! empty( $map[ $key ] ) ) {
		$url = wp_get_attachment_image_url( (int) $map[ $key ], $size );

		if ( $url ) {
			return $url;
		}
	}

	return $fallback;
}

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
			'title'       => __( 'Kitchens', 'spn-cabinets' ),
			'icon'        => 'home',
			'image_url'   => spn_cabinets_media_url( 'kitchen', 'https://static.wixstatic.com/media/11062b_76ac6b29841d4c7caba353e414ea4391~mv2.jpeg/v1/fill/w_800,h_600,al_c,q_85/kitchen.jpg' ),
			'description' => __( 'As the heart of your home, your kitchen deserves furniture and fittings that last. Create a kitchen that fits your lifestyle, layout, and budget.', 'spn-cabinets' ),
			'url'         => home_url( '/quote/' ),
		),
		array(
			'title'       => __( 'Bedrooms', 'spn-cabinets' ),
			'icon'        => 'layers',
			'image_url'   => spn_cabinets_media_url( 'bedroom', 'https://static.wixstatic.com/media/11062b_f2b967d92a3643b68bb61c6d5ac6d111~mv2.jpg/v1/fill/w_800,h_600,al_c,q_85/bedroom.jpg' ),
			'description' => __( 'Create your perfect fitted wardrobe with our expert design and installation service. Every inch is tailored to your needs to add style and elegance.', 'spn-cabinets' ),
			'url'         => home_url( '/quote/' ),
		),
		array(
			'title'       => __( 'Media Walls', 'spn-cabinets' ),
			'icon'        => 'monitor',
			'image_url'   => spn_cabinets_media_url( 'media-wall', 'https://static.wixstatic.com/media/11062b_9be2d47ecfb542d5b88f6562ad1b9639~mv2.jpg/v1/fill/w_800,h_600,al_c,q_85/media-wall.jpg' ),
			'description' => __( 'We design and fit custom media walls that bring together modern design and practical storage, tailored perfectly to your space and lifestyle.', 'spn-cabinets' ),
			'url'         => home_url( '/quote/' ),
		),
		array(
			'title'       => __( 'Custom Storage', 'spn-cabinets' ),
			'icon'        => 'briefcase',
			'image_url'   => spn_cabinets_media_url( 'storage', 'https://static.wixstatic.com/media/11062b_ee5add250ee643d1abc55ec22f16cf66~mv2.jpg/v1/fill/w_800,h_600,al_c,q_85/storage.jpg' ),
			'description' => __( 'From bespoke home offices to hallway storage, we design and manufacture high-quality furniture tailored specifically to the dimensions of your home.', 'spn-cabinets' ),
			'url'         => home_url( '/quote/' ),
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
