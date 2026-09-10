<?php
/**
 * Theme Customizer Configuration
 *
 * @package ListingCoreTheme
 */

defined( 'ABSPATH' ) || exit;

function listingcore_theme_customize_register( $wp_customize ) {

    // ── PANEL: CLASSIFIED ADS ─────────────────────────────
    $wp_customize->add_panel( 'listingcore_classified_panel', [
        'title'    => __( 'ListingCore Settings', 'listingcore-theme' ),
        'priority' => 30,
    ] );

    // ── SECTION: GENERAL ─────────────────────────────────
    $wp_customize->add_section( 'listingcore_general', [
        'title'    => __( 'General Colors & Options', 'listingcore-theme' ),
        'panel'    => 'listingcore_classified_panel',
        'priority' => 10,
    ] );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_primary_color', '#1a56db', 'listingcore_general',
        __( 'Primary Color', 'listingcore-theme' ), 'WP_Customize_Color_Control' );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_accent_color', '#f59e0b', 'listingcore_general',
        __( 'Accent Color', 'listingcore-theme' ), 'WP_Customize_Color_Control' );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_listings_per_page', 12, 'listingcore_general',
        __( 'Listings Per Page', 'listingcore-theme' ) );

    // ── SECTION: HOMEPAGE ─────────────────────────────────
    $wp_customize->add_section( 'listingcore_homepage', [
        'title' => __( 'Homepage Settings', 'listingcore-theme' ),
        'panel' => 'listingcore_classified_panel',
    ] );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_hero_title', __( 'Find What You Need, Sell What You Have', 'listingcore-theme' ), 'listingcore_homepage',
        __( 'Hero Title', 'listingcore-theme' ) );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_hero_subtitle', __( 'Browse thousands of local classified ads. Post your own for free.', 'listingcore-theme' ), 'listingcore_homepage',
        __( 'Hero Subtitle', 'listingcore-theme' ), 'WP_Customize_Control', 'textarea' );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_hero_bg_image', '', 'listingcore_homepage',
        __( 'Hero Background Image', 'listingcore-theme' ), 'WP_Customize_Image_Control' );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_show_featured_cats', true, 'listingcore_homepage',
        __( 'Show Featured Categories', 'listingcore-theme' ), 'WP_Customize_Control', 'checkbox' );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_show_stats', true, 'listingcore_homepage',
        __( 'Show Statistics Bar', 'listingcore-theme' ), 'WP_Customize_Control', 'checkbox' );

    // ── SECTION: HEADER ───────────────────────────────────
    $wp_customize->add_section( 'listingcore_header_section', [
        'title' => __( 'Header Configuration', 'listingcore-theme' ),
        'panel' => 'listingcore_classified_panel',
    ] );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_show_header_search', true, 'listingcore_header_section',
        __( 'Show Search in Header', 'listingcore-theme' ), 'WP_Customize_Control', 'checkbox' );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_post_listing_btn_text', __( 'Post Ad', 'listingcore-theme' ), 'listingcore_header_section',
        __( '"Post Listing" Button Text', 'listingcore-theme' ) );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_sticky_header', true, 'listingcore_header_section',
        __( 'Sticky Header', 'listingcore-theme' ), 'WP_Customize_Control', 'checkbox' );

    // ── SECTION: LISTINGS ─────────────────────────────────
    $wp_customize->add_section( 'listingcore_listings_section', [
        'title' => __( 'Listings Display Options', 'listingcore-theme' ),
        'panel' => 'listingcore_classified_panel',
    ] );

    $wp_customize->add_setting( 'listingcore_default_view', [ 'default' => 'grid', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp_customize->add_control( 'listingcore_default_view', [
        'label'   => __( 'Default View Layout', 'listingcore-theme' ),
        'section' => 'listingcore_listings_section',
        'type'    => 'radio',
        'choices' => [ 'grid' => __( 'Grid Layout', 'listingcore-theme' ), 'list' => __( 'List Layout', 'listingcore-theme' ) ],
    ] );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_show_sidebar_listings', true, 'listingcore_listings_section',
        __( 'Show Sidebar on Listings', 'listingcore-theme' ), 'WP_Customize_Control', 'checkbox' );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_enable_maps', true, 'listingcore_listings_section',
        __( 'Enable Content Maps', 'listingcore-theme' ), 'WP_Customize_Control', 'checkbox' );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_google_maps_key', '', 'listingcore_listings_section',
        __( 'Google Maps API Key', 'listingcore-theme' ) );

    // ── SECTION: FOOTER ───────────────────────────────────
    $wp_customize->add_section( 'listingcore_footer_section', [
        'title' => __( 'Footer Details', 'listingcore-theme' ),
        'panel' => 'listingcore_classified_panel',
    ] );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_footer_copyright', '© {year} ListingCore. All rights reserved.', 'listingcore_footer_section',
        __( 'Copyright Custom Text', 'listingcore-theme' ) );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_footer_facebook',  '', 'listingcore_footer_section', __( 'Facebook Link', 'listingcore-theme' ) );
    listingcore_theme_add_setting( $wp_customize, 'listingcore_footer_twitter',   '', 'listingcore_footer_section', __( 'Twitter/X Link', 'listingcore-theme' ) );
    listingcore_theme_add_setting( $wp_customize, 'listingcore_footer_instagram', '', 'listingcore_footer_section', __( 'Instagram Link', 'listingcore-theme' ) );
    listingcore_theme_add_setting( $wp_customize, 'listingcore_footer_linkedin',  '', 'listingcore_footer_section', __( 'LinkedIn Link',  'listingcore-theme' ) );
    listingcore_theme_add_setting( $wp_customize, 'listingcore_footer_youtube',   '', 'listingcore_footer_section', __( 'YouTube Link',   'listingcore-theme' ) );

    // ── SECTION: MONETIZATION ─────────────────────────────
    $wp_customize->add_section( 'listingcore_monetization', [
        'title' => __( 'Monetization Options', 'listingcore-theme' ),
        'panel' => 'listingcore_classified_panel',
    ] );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_paid_listings', false, 'listingcore_monetization',
        __( 'Enable Dynamic Paid Listings', 'listingcore-theme' ), 'WP_Customize_Control', 'checkbox' );

    listingcore_theme_add_setting( $wp_customize, 'listingcore_free_listings_limit', 3, 'listingcore_monetization',
        __( 'Maximum Free Listings Allowed Per User', 'listingcore-theme' ) );
}
add_action( 'customize_register', 'listingcore_theme_customize_register' );

/**
 * Customizer UI Field Registration Helper.
 */
function listingcore_theme_add_setting( $wp_customize, $id, $default, $section, $label, $control_class = 'WP_Customize_Control', $type = 'text' ) {
    $wp_customize->add_setting( $id, [
        'default'           => $default,
        'sanitize_callback' => 'listingcore_theme_sanitize_custom',
        'transport'         => 'refresh',
    ] );

    $control_args = [
        'label'   => $label,
        'section' => $section,
        'type'    => $type,
    ];

    $wp_customize->add_control( new $control_class( $wp_customize, $id, $control_args ) );
}

/**
 * Universal Data Sanitization Handler.
 */
function listingcore_theme_sanitize_custom( $value ) {
    if ( is_bool( $value ) ) {
        return (bool) $value;
    }
    if ( is_numeric( $value ) ) {
        return absint( $value );
    }
    return wp_kses_post( $value );
}

/**
 * Dynamic Inline Head CSS Wrapper Block.
 */
function listingcore_theme_customizer_css() {
    $primary = sanitize_hex_color( get_theme_mod( 'listingcore_primary_color', '#1a56db' ) );
    $accent  = sanitize_hex_color( get_theme_mod( 'listingcore_accent_color',  '#f59e0b' ) );

    if ( $primary || $accent ) {
        echo '<style id="listingcore-theme-custom-colors">:root{';
        if ( $primary ) {
            echo '--listingcore-primary:' . esc_attr( $primary ) . ';';
        }
        if ( $accent ) {
            echo '--listingcore-accent:'  . esc_attr( $accent )  . ';';
        }
        echo '}</style>';
    }
}
add_action( 'wp_head', 'listingcore_theme_customizer_css' );
