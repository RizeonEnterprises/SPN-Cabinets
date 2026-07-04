/**
 * SPN Cabinets — Global navigation & header behaviour.
 * -----------------------------------------------------------------------------
 * Progressive enhancement for the site shell:
 *   - Off-canvas mobile menu: open/close, focus trap, Escape, outside-click,
 *     body scroll-lock, and background `inert` for assistive tech.
 *   - Sticky header: adds `.is-scrolled` once the page is scrolled.
 *   - Submenu toggles: desktop dropdowns and mobile accordions (aria-expanded).
 *
 * Vanilla JS only (no jQuery). Deferred, so the DOM is already parsed.
 * -----------------------------------------------------------------------------
 */
( function () {
	'use strict';

	// Flag that JS is available (also set inline in <head> to avoid layout shift).
	document.documentElement.classList.add( 'js' );

	var FOCUSABLE =
		'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

	/**
	 * Return the visible, focusable elements within a container.
	 *
	 * @param {HTMLElement} container
	 * @returns {HTMLElement[]}
	 */
	function getFocusable( container ) {
		return Array.prototype.slice
			.call( container.querySelectorAll( FOCUSABLE ) )
			.filter( function ( el ) {
				return el.offsetParent !== null || el === document.activeElement;
			} );
	}

	/* =========================================================================
	 * Off-canvas mobile navigation
	 * ====================================================================== */
	function initMobileNav() {
		var toggle = document.querySelector( '[data-menu-toggle]' );
		var mobileNav = document.getElementById( 'mobile-nav' );
		var page = document.getElementById( 'page' );

		if ( ! toggle || ! mobileNav ) {
			return;
		}

		var panel = mobileNav.querySelector( '[data-menu-panel]' ) || mobileNav;
		var closers = mobileNav.querySelectorAll( '[data-menu-close]' );
		var lastFocused = null;
		var supportsInert = 'inert' in HTMLElement.prototype;

		/**
		 * Make everything except the panel inert while the menu is open.
		 * @param {boolean} state
		 */
		function setBackgroundInert( state ) {
			if ( ! supportsInert || ! page ) {
				return;
			}
			Array.prototype.forEach.call( page.children, function ( child ) {
				if ( child !== mobileNav ) {
					child.inert = state;
				}
			} );
		}

		function onKeydown( event ) {
			if ( 'Escape' === event.key ) {
				closeMenu();
				return;
			}

			if ( 'Tab' !== event.key ) {
				return;
			}

			// Trap focus within the panel.
			var focusables = getFocusable( panel );
			if ( ! focusables.length ) {
				return;
			}

			var first = focusables[ 0 ];
			var last = focusables[ focusables.length - 1 ];

			if ( event.shiftKey && document.activeElement === first ) {
				event.preventDefault();
				last.focus();
			} else if ( ! event.shiftKey && document.activeElement === last ) {
				event.preventDefault();
				first.focus();
			}
		}

		function openMenu() {
			lastFocused = document.activeElement;
			mobileNav.classList.add( 'is-open' );
			document.body.classList.add( 'is-menu-open' );
			toggle.setAttribute( 'aria-expanded', 'true' );
			setBackgroundInert( true );

			var focusables = getFocusable( panel );
			( focusables[ 0 ] || panel ).focus();

			document.addEventListener( 'keydown', onKeydown, true );
		}

		function closeMenu() {
			if ( ! mobileNav.classList.contains( 'is-open' ) ) {
				return;
			}
			mobileNav.classList.remove( 'is-open' );
			document.body.classList.remove( 'is-menu-open' );
			toggle.setAttribute( 'aria-expanded', 'false' );
			setBackgroundInert( false );

			document.removeEventListener( 'keydown', onKeydown, true );

			if ( lastFocused && typeof lastFocused.focus === 'function' ) {
				lastFocused.focus();
			}
		}

		// Expose a reference so the resize handler can close the menu.
		mobileNav.__close = closeMenu;

		toggle.addEventListener( 'click', function () {
			if ( mobileNav.classList.contains( 'is-open' ) ) {
				closeMenu();
			} else {
				openMenu();
			}
		} );

		Array.prototype.forEach.call( closers, function ( el ) {
			el.addEventListener( 'click', closeMenu );
		} );

		// Close after choosing a destination (but not when toggling a submenu).
		Array.prototype.forEach.call(
			mobileNav.querySelectorAll( '.mobile-menu a' ),
			function ( link ) {
				link.addEventListener( 'click', closeMenu );
			}
		);
	}

	/* =========================================================================
	 * Sticky header — elevate on scroll
	 * ====================================================================== */
	function initStickyHeader() {
		var header = document.querySelector( '[data-header]' );
		if ( ! header ) {
			return;
		}

		var ticking = false;
		function update() {
			header.classList.toggle( 'is-scrolled', window.scrollY > 8 );
			ticking = false;
		}

		update();
		window.addEventListener(
			'scroll',
			function () {
				if ( ! ticking ) {
					window.requestAnimationFrame( update );
					ticking = true;
				}
			},
			{ passive: true }
		);
	}

	/* =========================================================================
	 * Submenu toggles — desktop dropdowns + mobile accordions
	 * ====================================================================== */
	function initSubmenuToggles() {
		var toggles = document.querySelectorAll( '.submenu-toggle' );
		Array.prototype.forEach.call( toggles, function ( btn ) {
			btn.addEventListener( 'click', function ( event ) {
				event.preventDefault();
				var expanded = 'true' === btn.getAttribute( 'aria-expanded' );
				btn.setAttribute( 'aria-expanded', String( ! expanded ) );

				var parent = btn.closest( '.has-submenu' );
				if ( parent ) {
					parent.classList.toggle( 'is-expanded', ! expanded );
				}
			} );
		} );
	}

	/* =========================================================================
	 * Close the mobile menu if the viewport grows to desktop
	 * ====================================================================== */
	function initResizeGuard() {
		if ( ! window.matchMedia ) {
			return;
		}
		var desktop = window.matchMedia( '(min-width: 1024px)' );
		var handler = function ( event ) {
			var mobileNav = document.getElementById( 'mobile-nav' );
			if ( event.matches && mobileNav && mobileNav.__close ) {
				mobileNav.__close();
			}
		};
		// addEventListener on MediaQueryList (with older addListener fallback).
		if ( desktop.addEventListener ) {
			desktop.addEventListener( 'change', handler );
		} else if ( desktop.addListener ) {
			desktop.addListener( handler );
		}
	}

	initMobileNav();
	initStickyHeader();
	initSubmenuToggles();
	initResizeGuard();
}() );
