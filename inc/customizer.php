<?php
/**
 * Customizer options.
 *
 * Registers theme options in the WordPress Customizer.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function listingcore_theme_customize_register( $wp_customize ) {

	// -------------------------------------------------------------------------
	// Panel: ListingCore Theme Options
	// -------------------------------------------------------------------------
	$wp_customize->add_panel(
		'listingcore_theme_options',
		[
			'title'       => __( 'ListingCore Theme Options', 'listingcore-theme' ),
			'description' => __( 'Customize your ListingCore Theme appearance and features.', 'listingcore-theme' ),
			'priority'    => 30,
		]
	);

	// -------------------------------------------------------------------------
	// Section: Colors
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'listingcore_theme_colors',
		[
			'title' => __( 'Brand Colors', 'listingcore-theme' ),
			'panel' => 'listingcore_theme_options',
		]
	);

	// Primary color.
	$wp_customize->add_setting(
		'listingcore_theme_primary_color',
		[
			'default'           => '#1a56db',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		]
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'listingcore_theme_primary_color',
			[
				'label'   => __( 'Primary Color', 'listingcore-theme' ),
				'section' => 'listingcore_theme_colors',
			]
		)
	);

	// Accent color.
	$wp_customize->add_setting(
		'listingcore_theme_accent_color',
		[
			'default'           => '#f59e0b',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		]
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'listingcore_theme_accent_color',
			[
				'label'   => __( 'Accent Color', 'listingcore-theme' ),
				'section' => 'listingcore_theme_colors',
			]
		)
	);

	// -------------------------------------------------------------------------
	// Section: Layout
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'listingcore_theme_layout',
		[
			'title' => __( 'Layout', 'listingcore-theme' ),
			'panel' => 'listingcore_theme_options',
		]
	);

	// Sidebar position.
	$wp_customize->add_setting(
		'listingcore_theme_sidebar_position',
		[
			'default'           => 'right',
			'sanitize_callback' => 'listingcore_theme_sanitize_sidebar_position',
		]
	);
	$wp_customize->add_control(
		'listingcore_theme_sidebar_position',
		[
			'label'   => __( 'Sidebar Position', 'listingcore-theme' ),
			'section' => 'listingcore_theme_layout',
			'type'    => 'select',
			'choices' => [
				'right' => __( 'Right', 'listingcore-theme' ),
				'left'  => __( 'Left', 'listingcore-theme' ),
				'none'  => __( 'No Sidebar', 'listingcore-theme' ),
			],
		]
	);

	// -------------------------------------------------------------------------
	// Section: Listing Display
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'listingcore_theme_listings',
		[
			'title'       => __( 'Listing Display', 'listingcore-theme' ),
			'panel'       => 'listingcore_theme_options',
			'description' => __( 'These options only apply when the ListingCore plugin is active.', 'listingcore-theme' ),
		]
	);

	// Listings per page.
	$wp_customize->add_setting(
		'listingcore_theme_listings_per_page',
		[
			'default'           => 12,
			'sanitize_callback' => 'absint',
		]
	);
	$wp_customize->add_control(
		'listingcore_theme_listings_per_page',
		[
			'label'       => __( 'Listings Per Page', 'listingcore-theme' ),
			'section'     => 'listingcore_theme_listings',
			'type'        => 'number',
			'input_attrs' => [
				'min'  => 1,
				'max'  => 100,
				'step' => 1,
			],
		]
	);

	// Listings grid columns.
	$wp_customize->add_setting(
		'listingcore_theme_grid_columns',
		[
			'default'           => 3,
			'sanitize_callback' => 'listingcore_theme_sanitize_grid_columns',
		]
	);
	$wp_customize->add_control(
		'listingcore_theme_grid_columns',
		[
			'label'   => __( 'Grid Columns', 'listingcore-theme' ),
			'section' => 'listingcore_theme_listings',
			'type'    => 'select',
			'choices' => [
				2 => __( '2 Columns', 'listingcore-theme' ),
				3 => __( '3 Columns', 'listingcore-theme' ),
				4 => __( '4 Columns', 'listingcore-theme' ),
			],
		]
	);

	// -------------------------------------------------------------------------
	// Section: Footer
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'listingcore_theme_footer',
		[
			'title' => __( 'Footer', 'listingcore-theme' ),
			'panel' => 'listingcore_theme_options',
		]
	);

	// Copyright text.
	$wp_customize->add_setting(
		'listingcore_theme_copyright',
		[
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		]
	);
	$wp_customize->add_control(
		'listingcore_theme_copyright',
		[
			'label'       => __( 'Custom Copyright Text', 'listingcore-theme' ),
			'description' => __( 'Leave empty to use the default "© Year Site Name" text.', 'listingcore-theme' ),
			'section'     => 'listingcore_theme_footer',
			'type'        => 'text',
		]
	);
}
add_action( 'customize_register', 'listingcore_theme_customize_register' );

/**
 * Sanitize sidebar position.
 *
 * @param string $value Input value.
 * @return string
 */
function listingcore_theme_sanitize_sidebar_position( $value ) {
	$allowed = [ 'left', 'right', 'none' ];

	return in_array( $value, $allowed, true ) ? $value : 'right';
}

/**
 * Sanitize grid columns.
 *
 * @param int $value Input value.
 * @return int
 */
function listingcore_theme_sanitize_grid_columns( $value ) {
	$allowed = [ 2, 3, 4 ];
	$value   = absint( $value );

	return in_array( $value, $allowed, true ) ? $value : 3;
}

/**
 * Output customizer CSS on the front-end.
 */
function listingcore_theme_customizer_css() {
	$primary = get_theme_mod( 'listingcore_theme_primary_color', '#1a56db' );
	$accent  = get_theme_mod( 'listingcore_theme_accent_color', '#f59e0b' );

	// Only output if either color has been changed from default.
	if ( '#1a56db' === $primary && '#f59e0b' === $accent ) {
		return;
	}

	$css = ':root {';
	if ( $primary ) {
		$css .= '--listingcore-primary: ' . sanitize_hex_color( $primary ) . ';';
	}
	if ( $accent ) {
		$css .= '--listingcore-accent: ' . sanitize_hex_color( $accent ) . ';';
	}
	$css .= '}';

	wp_add_inline_style( 'listingcore-theme-style', $css );
}
add_action( 'wp_enqueue_scripts', 'listingcore_theme_customizer_css', 20 );

/**
 * Live preview JS for the Customizer.
 */
function listingcore_theme_customize_preview_js() {
	// Only load if we add JS preview later. Currently using refresh transport.
	// Kept as a placeholder so the hook can be used in the future.
}
add_action( 'customize_preview_init', 'listingcore_theme_customize_preview_js' );