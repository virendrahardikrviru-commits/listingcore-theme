<?php
/**
 * Theme setup.
 *
 * Registers theme supports, menus, sidebars, and image sizes.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'listingcore_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for WordPress features.
	 */
	function listingcore_theme_setup() {

		// ---------------------------------------------------------------------
		// Translations
		// ---------------------------------------------------------------------
		load_theme_textdomain( 'listingcore-theme', LISTINGCORE_THEME_DIR . '/languages' );

		// ---------------------------------------------------------------------
		// Core WordPress supports
		// ---------------------------------------------------------------------
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/editor-style.css' );

		// HTML5 markup.
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		] );

		// ---------------------------------------------------------------------
		// Custom logo
		// ---------------------------------------------------------------------
		add_theme_support( 'custom-logo', [
			'height'      => 60,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => [ 'site-title', 'site-description' ],
		] );

		// ---------------------------------------------------------------------
		// Custom background and header
		// ---------------------------------------------------------------------
		add_theme_support( 'custom-background', [
			'default-color' => 'f3f4f6',
		] );

		add_theme_support( 'custom-header', [
			'default-image'      => '',
			'default-text-color' => '111827',
			'width'              => 1280,
			'height'             => 500,
			'flex-height'        => true,
			'flex-width'         => true,
		] );

		// ---------------------------------------------------------------------
		// Block editor color palette
		// ---------------------------------------------------------------------
		add_theme_support( 'editor-color-palette', [
			[
				'name'  => __( 'Primary', 'listingcore-theme' ),
				'slug'  => 'primary',
				'color' => '#1a56db',
			],
			[
				'name'  => __( 'Accent', 'listingcore-theme' ),
				'slug'  => 'accent',
				'color' => '#f59e0b',
			],
			[
				'name'  => __( 'Success', 'listingcore-theme' ),
				'slug'  => 'success',
				'color' => '#10b981',
			],
			[
				'name'  => __( 'Dark', 'listingcore-theme' ),
				'slug'  => 'dark',
				'color' => '#111827',
			],
			[
				'name'  => __( 'Light', 'listingcore-theme' ),
				'slug'  => 'light',
				'color' => '#f9fafb',
			],
		] );

		// ---------------------------------------------------------------------
		// Block editor font sizes
		// ---------------------------------------------------------------------
		add_theme_support( 'editor-font-sizes', [
			[
				'name' => __( 'Small', 'listingcore-theme' ),
				'slug' => 'small',
				'size' => 14,
			],
			[
				'name' => __( 'Normal', 'listingcore-theme' ),
				'slug' => 'normal',
				'size' => 16,
			],
			[
				'name' => __( 'Large', 'listingcore-theme' ),
				'slug' => 'large',
				'size' => 20,
			],
			[
				'name' => __( 'Huge', 'listingcore-theme' ),
				'slug' => 'huge',
				'size' => 32,
			],
		] );

		// ---------------------------------------------------------------------
		// WooCommerce support (presentation only)
		// ---------------------------------------------------------------------
		add_theme_support( 'woocommerce', [
			'thumbnail_image_width'         => 600,
			'gallery_thumbnail_image_width' => 120,
		] );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// ---------------------------------------------------------------------
		// Navigation menus
		// ---------------------------------------------------------------------
		register_nav_menus( [
			'primary'   => __( 'Primary Menu', 'listingcore-theme' ),
			'secondary' => __( 'Secondary Menu', 'listingcore-theme' ),
			'footer'    => __( 'Footer Menu', 'listingcore-theme' ),
			'mobile'    => __( 'Mobile Menu', 'listingcore-theme' ),
			'dashboard' => __( 'Dashboard Menu', 'listingcore-theme' ),
		] );

		// ---------------------------------------------------------------------
		// Image sizes
		// ---------------------------------------------------------------------
		add_image_size( 'lct-listing-thumb',  600, 450, true );
		add_image_size( 'lct-listing-grid',   400, 300, true );
		add_image_size( 'lct-listing-single', 1200, 800, true );
		add_image_size( 'lct-listing-hero',   1600, 600, true );
		add_image_size( 'lct-category-icon',  120, 120, true );
		add_image_size( 'lct-avatar',          96,  96, true );
		add_image_size( 'lct-blog-thumb',      800, 500, true );
	}
endif;
add_action( 'after_setup_theme', 'listingcore_theme_setup' );

/**
 * Set the content width in pixels.
 */
function listingcore_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'listingcore_theme_content_width', 1280 );
}
add_action( 'after_setup_theme', 'listingcore_theme_content_width', 0 );

/**
 * Register widget areas.
 */
function listingcore_theme_widgets_init() {

	$areas = [
		[
			'name'        => __( 'Primary Sidebar', 'listingcore-theme' ),
			'id'          => 'sidebar-1',
			'description' => __( 'Main sidebar for listings archive and pages.', 'listingcore-theme' ),
		],
		[
			'name'        => __( 'Listing Single Sidebar', 'listingcore-theme' ),
			'id'          => 'sidebar-listing',
			'description' => __( 'Sidebar displayed on single listing pages.', 'listingcore-theme' ),
		],
		[
			'name'        => __( 'Footer Column 1', 'listingcore-theme' ),
			'id'          => 'footer-1',
			'description' => __( 'First footer widget area.', 'listingcore-theme' ),
		],
		[
			'name'        => __( 'Footer Column 2', 'listingcore-theme' ),
			'id'          => 'footer-2',
			'description' => __( 'Second footer widget area.', 'listingcore-theme' ),
		],
		[
			'name'        => __( 'Footer Column 3', 'listingcore-theme' ),
			'id'          => 'footer-3',
			'description' => __( 'Third footer widget area.', 'listingcore-theme' ),
		],
		[
			'name'        => __( 'Footer Column 4', 'listingcore-theme' ),
			'id'          => 'footer-4',
			'description' => __( 'Fourth footer widget area.', 'listingcore-theme' ),
		],
		[
			'name'        => __( 'Homepage Widgets', 'listingcore-theme' ),
			'id'          => 'homepage-widgets',
			'description' => __( 'Widgets displayed on the homepage.', 'listingcore-theme' ),
		],
		[
			'name'        => __( 'Dashboard Sidebar', 'listingcore-theme' ),
			'id'          => 'dashboard-sidebar',
			'description' => __( 'Sidebar on user dashboard.', 'listingcore-theme' ),
		],
	];

	foreach ( $areas as $area ) {
		register_sidebar( array_merge(
			[
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			],
			$area
		) );
	}
}
add_action( 'widgets_init', 'listingcore_theme_widgets_init' );