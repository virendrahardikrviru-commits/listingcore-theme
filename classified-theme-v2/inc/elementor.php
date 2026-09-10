<?php
/**
 * Elementor Compatibility (presentation only)
 *
 * @package ClassiPressPro
 */

defined( 'ABSPATH' ) || exit;

// Register Elementor theme locations
add_action( 'elementor/theme/register_locations', function ( $manager ) {
    $manager->register_location( 'header' );
    $manager->register_location( 'footer' );
    $manager->register_location( 'single' );
    $manager->register_location( 'archive' );
} );

add_theme_support( 'elementor' );
// Note: SVG upload support must be handled via a plugin, not the theme.
