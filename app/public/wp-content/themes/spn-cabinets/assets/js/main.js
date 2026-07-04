/**
 * SPN Cabinets — Main site script.
 * -----------------------------------------------------------------------------
 * Entry point for general, site-wide interactions. Kept intentionally lean; add
 * feature modules as small, self-contained functions and call them from init().
 *
 * A localized `spnCabinets` object (ajaxUrl, restUrl, nonce) is available on
 * `window` — see inc/enqueue-assets.php. Vanilla JS only, deferred.
 * -----------------------------------------------------------------------------
 */
( function () {
	'use strict';

	/**
	 * Site bootstrap. Wire up feature modules here as they are built.
	 */
	function init() {
		// Example wiring (features added during the build phase):
		// initSmoothAnchors();
		// initQuoteForm();
	}

	// The script is deferred, so the DOM is already parsed; guard just in case.
	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
}() );
