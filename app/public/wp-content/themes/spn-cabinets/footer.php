<?php
/**
 * The site footer.
 *
 * Closes the main content wrapper opened in header.php, renders the site footer,
 * closes the global #page wrapper, then prints wp_footer() and closes the
 * document.
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
		</div><!-- #content .site-content -->

		<?php
		// Site footer: 4-column layout + bottom bar.
		get_template_part( 'template-parts/footer/site-footer' );
		?>

	</div><!-- #page .site -->

<?php wp_footer(); ?>
</body>
</html>
