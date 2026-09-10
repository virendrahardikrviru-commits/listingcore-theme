/**
 * ListingCore Theme - Main JavaScript
 *
 * Handles front-end interactions: mobile menu, search toggle,
 * back-to-top, and other UI enhancements.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

( function () {
	'use strict';

	/**
	 * Wait for DOM to be ready.
	 */
	document.addEventListener( 'DOMContentLoaded', function () {
		initMobileMenu();
		initSearchToggle();
		initBackToTop();
		initSubmenuToggles();
		initSmoothScroll();
	} );

	/**
	 * Mobile menu toggle.
	 */
	function initMobileMenu() {
		var toggle = document.querySelector( '.lct-header__menu-toggle' );
		var nav = document.getElementById( 'site-navigation' );

		if ( ! toggle || ! nav ) {
			return;
		}

		toggle.addEventListener( 'click', function () {
			var expanded = toggle.getAttribute( 'aria-expanded' ) === 'true';

			toggle.setAttribute( 'aria-expanded', String( ! expanded ) );
			nav.classList.toggle( 'is-open' );
			document.body.classList.toggle( 'lct-menu-open' );
		} );

		// Close menu on Escape key.
		document.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' && nav.classList.contains( 'is-open' ) ) {
				toggle.setAttribute( 'aria-expanded', 'false' );
				nav.classList.remove( 'is-open' );
				document.body.classList.remove( 'lct-menu-open' );
				toggle.focus();
			}
		} );

		// Close menu when clicking outside.
		document.addEventListener( 'click', function ( event ) {
			if (
				nav.classList.contains( 'is-open' ) &&
				! nav.contains( event.target ) &&
				! toggle.contains( event.target )
			) {
				toggle.setAttribute( 'aria-expanded', 'false' );
				nav.classList.remove( 'is-open' );
				document.body.classList.remove( 'lct-menu-open' );
			}
		} );
	}

	/**
	 * Header search toggle.
	 */
	function initSearchToggle() {
		var toggle = document.querySelector( '.lct-header__search-toggle' );
		var search = document.getElementById( 'lct-header-search' );

		if ( ! toggle || ! search ) {
			return;
		}

		toggle.addEventListener( 'click', function () {
			var expanded = toggle.getAttribute( 'aria-expanded' ) === 'true';

			toggle.setAttribute( 'aria-expanded', String( ! expanded ) );
			search.hidden = expanded;

			if ( ! expanded ) {
				var input = search.querySelector( 'input[type="search"]' );
				if ( input ) {
					input.focus();
				}
			}
		} );

		// Close on Escape.
		document.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' && ! search.hidden ) {
				toggle.setAttribute( 'aria-expanded', 'false' );
				search.hidden = true;
				toggle.focus();
			}
		} );
	}

	/**
	 * Back-to-top button.
	 */
	function initBackToTop() {
		var button = document.querySelector( '.lct-back-to-top' );

		if ( ! button ) {
			return;
		}

		var scrollThreshold = 300;

		function toggleButton() {
			if ( window.scrollY > scrollThreshold ) {
				button.hidden = false;
				button.classList.add( 'is-visible' );
			} else {
				button.classList.remove( 'is-visible' );
				// Keep hidden after animation ends.
				setTimeout( function () {
					if ( window.scrollY <= scrollThreshold ) {
						button.hidden = true;
					}
				}, 200 );
			}
		}

		window.addEventListener( 'scroll', toggleButton, { passive: true } );
		toggleButton();

		button.addEventListener( 'click', function () {
			window.scrollTo( {
				top: 0,
				behavior: 'smooth',
			} );
		} );
	}

	/**
	 * Accessible submenu toggles.
	 */
	function initSubmenuToggles() {
		var toggles = document.querySelectorAll( '.lct-menu__toggle' );

		if ( ! toggles.length ) {
			return;
		}

		toggles.forEach( function ( toggle ) {
			toggle.addEventListener( 'click', function ( event ) {
				event.preventDefault();

				var expanded = toggle.getAttribute( 'aria-expanded' ) === 'true';
				var parentItem = toggle.closest( '.lct-menu__item--has-children' );

				toggle.setAttribute( 'aria-expanded', String( ! expanded ) );

				if ( parentItem ) {
					parentItem.classList.toggle( 'is-open' );
				}
			} );
		} );
	}

	/**
	 * Smooth scroll for in-page anchor links.
	 */
	function initSmoothScroll() {
		var links = document.querySelectorAll( 'a[href^="#"]:not([href="#"])' );

		if ( ! links.length ) {
			return;
		}

		links.forEach( function ( link ) {
			link.addEventListener( 'click', function ( event ) {
				var targetId = link.getAttribute( 'href' );

				if ( ! targetId || targetId.length < 2 ) {
					return;
				}

				var target = document.querySelector( targetId );

				if ( ! target ) {
					return;
				}

				event.preventDefault();

				target.scrollIntoView( {
					behavior: 'smooth',
					block: 'start',
				} );

				// Update URL without jumping.
				if ( history.pushState ) {
					history.pushState( null, '', targetId );
				}
			} );
		} );
	}
} )();