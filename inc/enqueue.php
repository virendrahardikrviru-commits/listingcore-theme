<?php
/**
 * Enqueue scripts and styles.
 *
 * Loads front-end and editor assets for the ListingCore Theme.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue front-end styles and scripts.
 */
function listingcore_theme_enqueue_assets() {

	$theme_version = LISTINGCORE_THEME_VERSION;
	$theme_uri     = LISTINGCORE_THEME_URI;

	// -------------------------------------------------------------------------
	// Styles
	// -------------------------------------------------------------------------

	// Main stylesheet.
	wp_enqueue_style(
		'listingcore-theme-style',
		get_stylesheet_uri(),
		[],
		$theme_version
	);

	// Optional: Google Fonts (preconnect handles performance).
	wp_enqueue_style(
		'listingcore-theme-fonts',
		'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap',
		[],
		null
	);

	// -------------------------------------------------------------------------
	// Scripts
	// -------------------------------------------------------------------------

	// Main theme JS.
	wp_enqueue_script(
		'listingcore-theme-main',
		$theme_uri . '/assets/js/main.js',
		[],
		$theme_version,
		true
	);

	// Comment reply (only when needed).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// -------------------------------------------------------------------------
	// Localize script for AJAX and translatable strings
	// -------------------------------------------------------------------------
		wp_localize_script(
		'listingcore-theme-main',
		'listingcoreThemeData',
		[
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'listingcore_theme_nonce' ),
			'strings' => [
				'loading'   => __( 'Loading…', 'listingcore-theme' ),
				'error'     => __( 'Something went wrong. Please try again.', 'listingcore-theme' ),
				'confirm'   => __( 'Are you sure?', 'listingcore-theme' ),
				'searching' => __( 'Searching…', 'listingcore-theme' ),
				'noResults' => __( 'No results found.', 'listingcore-theme' ),
			],
		]
	);
}
add_action( 'wp_enqueue_scripts', 'listingcore_theme_enqueue_assets' );

/**
 * Add preconnect for Google Fonts.
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed for.
 * @return array Modified URLs.
 */
function listingcore_theme_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = [
			'href' => 'https://fonts.googleapis.com',
		];
		$urls[] = [
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		];
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'listingcore_theme_resource_hints', 10, 2 );

/**
 * Enqueue block editor styles.
 */
function listingcore_theme_editor_assets() {
	wp_enqueue_style(
		'listingcore-theme-editor-style',
		LISTINGCORE_THEME_URI . '/assets/css/editor-style.css',
		[],
		LISTINGCORE_THEME_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'listingcore_theme_editor_assets' );