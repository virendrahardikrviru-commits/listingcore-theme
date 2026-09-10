<?php
/**
 * ListingCore Theme functions and definitions.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// -----------------------------------------------------------------------------
// Theme constants
// -----------------------------------------------------------------------------
if ( ! defined( 'LISTINGCORE_THEME_VERSION' ) ) {
	define( 'LISTINGCORE_THEME_VERSION', '1.0.0' );
}

if ( ! defined( 'LISTINGCORE_THEME_DIR' ) ) {
	define( 'LISTINGCORE_THEME_DIR', get_template_directory() );
}

if ( ! defined( 'LISTINGCORE_THEME_URI' ) ) {
	define( 'LISTINGCORE_THEME_URI', get_template_directory_uri() );
}

if ( ! defined( 'LISTINGCORE_THEME_INC' ) ) {
	define( 'LISTINGCORE_THEME_INC', LISTINGCORE_THEME_DIR . '/inc' );
}

// -----------------------------------------------------------------------------
// Load theme modules (presentation only — no plugin territory).
// -----------------------------------------------------------------------------
$listingcore_theme_modules = [
	'/theme-setup.php',              // Theme supports, menus, sidebars, image sizes.
	'/enqueue.php',                  // Front-end and editor styles/scripts.
	'/template-functions.php',       // Reusable template helpers.
	'/template-hooks.php',           // Header/footer/content hooks.
	'/widgets.php',                  // Custom widgets.
	'/customizer.php',               // Customizer options.
	'/block-patterns.php',           // Block patterns.
	'/class-listingcore-theme-walker-nav-menu.php', // Nav menu walker.
	'/plugin-recommendation.php',    // Admin notice recommending ListingCore plugin.
];

foreach ( $listingcore_theme_modules as $listingcore_theme_module ) {
	$listingcore_theme_module_path = LISTINGCORE_THEME_INC . $listingcore_theme_module;

	if ( file_exists( $listingcore_theme_module_path ) ) {
		require_once $listingcore_theme_module_path;
	}
}

unset( $listingcore_theme_modules, $listingcore_theme_module, $listingcore_theme_module_path );

// -----------------------------------------------------------------------------
// WooCommerce presentation layer (wrappers, sidebar, styles only).
// -----------------------------------------------------------------------------
if ( class_exists( 'WooCommerce' ) ) {
	$listingcore_theme_wc = LISTINGCORE_THEME_INC . '/woocommerce.php';

	if ( file_exists( $listingcore_theme_wc ) ) {
		require_once $listingcore_theme_wc;
	}

	unset( $listingcore_theme_wc );
}