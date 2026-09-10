<?php
/**
 * Theme Setup
 *
 * @package ClassiPressPro
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'classipress_setup' ) ) :
    function classipress_setup() {

        // Text domain
        load_theme_textdomain( 'classipress-pro', CP_DIR . '/languages' );

        // Automatic feed links
        add_theme_support( 'automatic-feed-links' );

        // Title tag
        add_theme_support( 'title-tag' );

        // Post thumbnails
        add_theme_support( 'post-thumbnails' );

        // HTML5
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

        // Custom logo
        add_theme_support( 'custom-logo', [
            'height'      => 60,
            'width'       => 200,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => [ 'site-title', 'site-description' ],
        ] );

        // Custom background
        add_theme_support( 'custom-background', [
            'default-color' => 'f3f4f6',
        ] );

        // Custom header
        add_theme_support( 'custom-header', [
            'default-image'      => '',
            'default-text-color' => '111827',
            'width'              => 1280,
            'height'             => 500,
            'flex-height'        => true,
            'flex-width'         => true,
        ] );

        // Selective refresh for widgets
        add_theme_support( 'customize-selective-refresh-widgets' );

        // Editor styles
        add_theme_support( 'editor-styles' );
        add_editor_style( 'assets/css/editor-style.css' );

        // Block editor colors
        add_theme_support( 'editor-color-palette', [
            [ 'name' => __( 'Primary',   'classipress-pro' ), 'slug' => 'primary',   'color' => '#1a56db' ],
            [ 'name' => __( 'Accent',    'classipress-pro' ), 'slug' => 'accent',    'color' => '#f59e0b' ],
            [ 'name' => __( 'Success',   'classipress-pro' ), 'slug' => 'success',   'color' => '#10b981' ],
            [ 'name' => __( 'Dark',      'classipress-pro' ), 'slug' => 'dark',      'color' => '#111827' ],
            [ 'name' => __( 'Light',     'classipress-pro' ), 'slug' => 'light',     'color' => '#f9fafb' ],
        ] );

        add_theme_support( 'editor-font-sizes', [
            [ 'name' => __( 'Small',   'classipress-pro' ), 'slug' => 'small',  'size' => 14 ],
            [ 'name' => __( 'Normal',  'classipress-pro' ), 'slug' => 'normal', 'size' => 16 ],
            [ 'name' => __( 'Large',   'classipress-pro' ), 'slug' => 'large',  'size' => 20 ],
            [ 'name' => __( 'Huge',    'classipress-pro' ), 'slug' => 'huge',   'size' => 32 ],
        ] );

        // Full-width alignment blocks
        add_theme_support( 'align-wide' );

        // Responsive embeds
        add_theme_support( 'responsive-embeds' );

        // Block styles
        add_theme_support( 'wp-block-styles' );

        // WooCommerce support
        add_theme_support( 'woocommerce', [
            'thumbnail_image_width' => 600,
            'gallery_thumbnail_image_width' => 120,
        ] );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );

        // Nav menus
        register_nav_menus( [
            'primary'   => __( 'Primary Menu',    'classipress-pro' ),
            'secondary' => __( 'Secondary Menu',  'classipress-pro' ),
            'footer'    => __( 'Footer Menu',     'classipress-pro' ),
            'mobile'    => __( 'Mobile Menu',     'classipress-pro' ),
            'dashboard' => __( 'Dashboard Menu',  'classipress-pro' ),
        ] );

        // Image sizes
        add_image_size( 'cp-listing-thumb',   600,  450, true );
        add_image_size( 'cp-listing-grid',    400,  300, true );
        add_image_size( 'cp-listing-single', 1200,  800, true );
        add_image_size( 'cp-listing-hero',   1600,  600, true );
        add_image_size( 'cp-category-icon',   120,  120, true );
        add_image_size( 'cp-avatar',           96,   96, true );
        add_image_size( 'cp-blog-thumb',      800,  500, true );
    }
endif;
add_action( 'after_setup_theme', 'classipress_setup' );

// Content width
function classipress_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'classipress_content_width', 1280 );
}
add_action( 'after_setup_theme', 'classipress_content_width', 0 );

// Register widget areas
function classipress_widgets_init() {
    $areas = [
        [
            'name'          => __( 'Primary Sidebar', 'classipress-pro' ),
            'id'            => 'sidebar-1',
            'description'   => __( 'Main sidebar for listings archive and pages.', 'classipress-pro' ),
        ],
        [
            'name'          => __( 'Listing Single Sidebar', 'classipress-pro' ),
            'id'            => 'sidebar-listing',
            'description'   => __( 'Sidebar displayed on single listing pages.', 'classipress-pro' ),
        ],
        [
            'name'          => __( 'Footer Column 1', 'classipress-pro' ),
            'id'            => 'footer-1',
            'description'   => __( 'First footer widget area.', 'classipress-pro' ),
        ],
        [
            'name'          => __( 'Footer Column 2', 'classipress-pro' ),
            'id'            => 'footer-2',
            'description'   => __( 'Second footer widget area.', 'classipress-pro' ),
        ],
        [
            'name'          => __( 'Footer Column 3', 'classipress-pro' ),
            'id'            => 'footer-3',
            'description'   => __( 'Third footer widget area.', 'classipress-pro' ),
        ],
        [
            'name'          => __( 'Footer Column 4', 'classipress-pro' ),
            'id'            => 'footer-4',
            'description'   => __( 'Fourth footer widget area.', 'classipress-pro' ),
        ],
        [
            'name'          => __( 'Homepage Widgets', 'classipress-pro' ),
            'id'            => 'homepage-widgets',
            'description'   => __( 'Widgets displayed on the homepage.', 'classipress-pro' ),
        ],
        [
            'name'          => __( 'Dashboard Sidebar', 'classipress-pro' ),
            'id'            => 'dashboard-sidebar',
            'description'   => __( 'Sidebar on user dashboard.', 'classipress-pro' ),
        ],
    ];

    foreach ( $areas as $area ) {
        register_sidebar( array_merge( [
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ], $area ) );
    }
}
add_action( 'widgets_init', 'classipress_widgets_init' );
