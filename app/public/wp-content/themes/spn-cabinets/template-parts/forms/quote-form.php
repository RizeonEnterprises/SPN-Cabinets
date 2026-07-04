<?php
/**
 * Template part: Free Quote form.
 *
 * A native, secure lead-capture form. Posts to admin-post.php (handled in
 * inc/form-handlers.php). On the way back it reads `?status=success|error`:
 * success shows a confirmation; error reads a one-time transient (keyed by the
 * `sqf` token) to repopulate values and show per-field messages.
 *
 * Uses the shared forms.css hooks (.field / .input / .select / .textarea /
 * .field__error / .form-message / .field--honeypot) and the button primitive
 * for the submit control. No inline styles.
 *
 * Usage:
 *   spn_cabinets_component( 'forms/quote-form' );
 *   spn_cabinets_component( 'forms/quote-form', array( 'submit_label' => '…' ) );
 *
 * @package SPN_Cabinets
 * @since   1.0.0
 *
 * @var array $args Optional { @type string $submit_label }.
 */

defined( 'ABSPATH' ) || exit;

$config = wp_parse_args(
	$args ?? array(),
	array(
		'submit_label' => __( 'Request My Free Quote', 'spn-cabinets' ),
	)
);

$services = spn_cabinets_quote_services();

// Read the post-submission status (read-only display; no state change here).
$status = isset( $_GET['status'] ) ? sanitize_key( wp_unslash( $_GET['status'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only status flag.
$errors = array();
$values = array();

if ( 'error' === $status && isset( $_GET['sqf'] ) ) {
	$token  = sanitize_key( wp_unslash( $_GET['sqf'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- One-time lookup key.
	$stored = get_transient( 'spn_cabinets_quote_err_' . $token );
	if ( is_array( $stored ) ) {
		$errors = isset( $stored['errors'] ) ? (array) $stored['errors'] : array();
		$values = isset( $stored['values'] ) ? (array) $stored['values'] : array();
		delete_transient( 'spn_cabinets_quote_err_' . $token ); // Consume once.
	}
}

// Small helpers for repopulation / error lookups.
$sqf_value = static function ( $key ) use ( $values ) {
	return isset( $values[ $key ] ) ? $values[ $key ] : '';
};
$sqf_error = static function ( $key ) use ( $errors ) {
	return isset( $errors[ $key ] ) ? $errors[ $key ] : '';
};

// Redirect the handler back to this page.
$redirect_url = get_permalink();
if ( ! $redirect_url ) {
	$redirect_url = home_url( '/' );
}
?>
<div class="quote-form-wrap" id="quote-form">

	<?php if ( 'success' === $status ) : ?>
		<p class="form-message form-message--success" role="status">
			<?php esc_html_e( 'Thank you — your request has been sent. We will be in touch shortly.', 'spn-cabinets' ); ?>
		</p>
	<?php elseif ( ! empty( $errors ) ) : ?>
		<p class="form-message form-message--error" role="alert">
			<?php esc_html_e( 'Please check the highlighted fields and try again.', 'spn-cabinets' ); ?>
		</p>
	<?php endif; ?>

	<form class="quote-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">

		<p class="field__hint"><?php esc_html_e( 'Fields marked * are required.', 'spn-cabinets' ); ?></p>

		<?php wp_nonce_field( 'spn_cabinets_quote_submit', 'spn_cabinets_quote_nonce' ); ?>
		<input type="hidden" name="action" value="spn_cabinets_quote">
		<input type="hidden" name="_redirect" value="<?php echo esc_url( $redirect_url ); ?>">

		<?php // Honeypot — hidden from users & AT; bots fill it. ?>
		<div class="field--honeypot" aria-hidden="true">
			<label for="quote-website"><?php esc_html_e( 'Leave this field blank', 'spn-cabinets' ); ?></label>
			<input type="text" id="quote-website" name="quote_website" tabindex="-1" autocomplete="off">
		</div>

		<?php // Full name. ?>
		<div class="field<?php echo $sqf_error( 'name' ) ? ' is-error' : ''; ?>">
			<label class="field__label" for="quote-name">
				<?php esc_html_e( 'Full Name', 'spn-cabinets' ); ?> <span class="field__required">*</span>
			</label>
			<input class="input" type="text" id="quote-name" name="quote_name" autocomplete="name" required
				value="<?php echo esc_attr( $sqf_value( 'name' ) ); ?>"
				<?php if ( $sqf_error( 'name' ) ) : ?>aria-invalid="true" aria-describedby="quote-name-error"<?php endif; ?>>
			<?php if ( $sqf_error( 'name' ) ) : ?>
				<span class="field__error" id="quote-name-error"><?php echo esc_html( $sqf_error( 'name' ) ); ?></span>
			<?php endif; ?>
		</div>

		<?php // Email. ?>
		<div class="field<?php echo $sqf_error( 'email' ) ? ' is-error' : ''; ?>">
			<label class="field__label" for="quote-email">
				<?php esc_html_e( 'Email Address', 'spn-cabinets' ); ?> <span class="field__required">*</span>
			</label>
			<input class="input" type="email" id="quote-email" name="quote_email" autocomplete="email" required
				value="<?php echo esc_attr( $sqf_value( 'email' ) ); ?>"
				<?php if ( $sqf_error( 'email' ) ) : ?>aria-invalid="true" aria-describedby="quote-email-error"<?php endif; ?>>
			<?php if ( $sqf_error( 'email' ) ) : ?>
				<span class="field__error" id="quote-email-error"><?php echo esc_html( $sqf_error( 'email' ) ); ?></span>
			<?php endif; ?>
		</div>

		<?php // Phone. ?>
		<div class="field<?php echo $sqf_error( 'phone' ) ? ' is-error' : ''; ?>">
			<label class="field__label" for="quote-phone">
				<?php esc_html_e( 'Phone Number', 'spn-cabinets' ); ?> <span class="field__required">*</span>
			</label>
			<input class="input" type="tel" id="quote-phone" name="quote_phone" autocomplete="tel" required
				value="<?php echo esc_attr( $sqf_value( 'phone' ) ); ?>"
				<?php if ( $sqf_error( 'phone' ) ) : ?>aria-invalid="true" aria-describedby="quote-phone-error"<?php endif; ?>>
			<?php if ( $sqf_error( 'phone' ) ) : ?>
				<span class="field__error" id="quote-phone-error"><?php echo esc_html( $sqf_error( 'phone' ) ); ?></span>
			<?php endif; ?>
		</div>

		<?php // Postcode. ?>
		<div class="field<?php echo $sqf_error( 'postcode' ) ? ' is-error' : ''; ?>">
			<label class="field__label" for="quote-postcode">
				<?php esc_html_e( 'Postcode', 'spn-cabinets' ); ?> <span class="field__required">*</span>
			</label>
			<input class="input" type="text" id="quote-postcode" name="quote_postcode" autocomplete="postal-code" required
				value="<?php echo esc_attr( $sqf_value( 'postcode' ) ); ?>"
				<?php if ( $sqf_error( 'postcode' ) ) : ?>aria-invalid="true" aria-describedby="quote-postcode-error"<?php endif; ?>>
			<?php if ( $sqf_error( 'postcode' ) ) : ?>
				<span class="field__error" id="quote-postcode-error"><?php echo esc_html( $sqf_error( 'postcode' ) ); ?></span>
			<?php endif; ?>
		</div>

		<?php // Service required. ?>
		<div class="field<?php echo $sqf_error( 'service' ) ? ' is-error' : ''; ?>">
			<label class="field__label" for="quote-service">
				<?php esc_html_e( 'Service Required', 'spn-cabinets' ); ?> <span class="field__required">*</span>
			</label>
			<select class="select" id="quote-service" name="quote_service" required
				<?php if ( $sqf_error( 'service' ) ) : ?>aria-invalid="true" aria-describedby="quote-service-error"<?php endif; ?>>
				<option value=""><?php esc_html_e( 'Please choose…', 'spn-cabinets' ); ?></option>
				<?php foreach ( $services as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $sqf_value( 'service' ), $value ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
			<?php if ( $sqf_error( 'service' ) ) : ?>
				<span class="field__error" id="quote-service-error"><?php echo esc_html( $sqf_error( 'service' ) ); ?></span>
			<?php endif; ?>
		</div>

		<?php // Project details (optional). ?>
		<div class="field">
			<label class="field__label" for="quote-details"><?php esc_html_e( 'Project Details', 'spn-cabinets' ); ?></label>
			<textarea class="textarea" id="quote-details" name="quote_details" rows="5"><?php echo esc_textarea( $sqf_value( 'details' ) ); ?></textarea>
		</div>

		<div class="quote-form__actions">
			<?php
			spn_cabinets_component(
				'buttons/button',
				array(
					'label'   => $config['submit_label'],
					'type'    => 'submit',
					'variant' => 'primary',
					'size'    => 'lg',
					'classes' => array( 'button--block', 'quote-form__submit' ),
				)
			);
			?>
		</div>

	</form>
</div><!-- #quote-form -->
