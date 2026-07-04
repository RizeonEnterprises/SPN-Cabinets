<?php
/**
 * The site header.
 *
 * Opens the document and the global shell: announcement bar, site header,
 * off-canvas mobile navigation, then the main content wrapper (+ breadcrumb
 * placeholder). Everything here is inherited by every page. Closed in footer.php.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); // The `js` PE flag is printed here via spn_cabinets_js_detection(). ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

	<a class="skip-link screen-reader-text" href="#primary">
		<?php esc_html_e( 'Skip to main content', 'spn-cabinets' ); ?>
	</a>

	<div id="page" class="site">

		<?php
		// Announcement bar (disabled by default — see inc/helpers/site-options.php).
		get_template_part( 'template-parts/header/announcement-bar' );

		// Site header: branding, primary navigation, actions, mobile toggle.
		get_template_part( 'template-parts/header/site-header' );

		// Off-canvas mobile navigation panel (progressive enhancement).
		get_template_part( 'template-parts/header/mobile-nav' );
		?>

		<div id="content" class="site-content">

			<?php
			// Breadcrumb placeholder (renders on inner pages only).
			get_template_part( 'template-parts/global/breadcrumbs' );
			?>
