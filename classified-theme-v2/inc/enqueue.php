<?php
/**
 * Enqueue Scripts & Styles
 *
 * @package ClassiPressPro
 */

defined( 'ABSPATH' ) || exit;

function classipress_enqueue_assets() {
    $v = CP_VERSION;

    // Google Fonts
    wp_enqueue_style(
        'classipress-fonts',
        'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap',
        [],
        null
    );

    // Main theme stylesheet
    wp_enqueue_style(
        'classipress-style',
        get_stylesheet_uri(),
        [ 'classipress-fonts' ],
        $v
    );

    // Comment reply script
    if ( is_singular() && comments_open() ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // Main theme JS
    wp_enqueue_script(
        'classipress-main',
        CP_URI . '/assets/js/main.js',
        [ 'jquery' ],
        $v,
        true
    );

    // Theme-side JS data (non-sensitive, no nonce — AJAX nonce provided by plugin)
    wp_localize_script( 'classipress-main', 'ClassiPressTheme', [
        'home_url' => esc_url( home_url() ),
        'i18n'     => [
            'loading' => esc_html__( 'Loading...', 'classipress-pro' ),
            'error'   => esc_html__( 'Something went wrong.', 'classipress-pro' ),
        ],
    ] );

    // Select2 for enhanced dropdowns
    wp_enqueue_style(
        'select2',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
        [],
        '4.1.0'
    );
    wp_enqueue_script(
        'select2',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
        [ 'jquery' ],
        '4.1.0',
        true
    );

    // Lightbox for gallery — only on single listing or singular post
    if ( is_singular( 'listing' ) || is_singular( 'post' ) ) {
        wp_enqueue_style(
            'glightbox',
            'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css',
            [],
            '3.2.0'
        );
        wp_enqueue_script(
            'glightbox',
            'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js',
            [],
            '3.2.0',
            true
        );
    }

    // Google Maps — only when key is set and maps are enabled
    if ( get_theme_mod( 'cp_enable_maps', true ) ) {
        $maps_key = get_theme_mod( 'cp_google_maps_key', '' );
        if ( $maps_key && is_singular( 'listing' ) ) {
            wp_enqueue_script(
                'google-maps-api',
                add_query_arg(
                    [ 'key' => sanitize_text_field( $maps_key ), 'libraries' => 'places', 'callback' => 'initListingMap' ],
                    'https://maps.googleapis.com/maps/api/js'
                ),
                [ 'classipress-main' ],
                null,
                true
            );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'classipress_enqueue_assets' );

// Block editor stylesheet
function classipress_block_editor_assets() {
    wp_enqueue_style(
        'classipress-editor',
        CP_URI . '/assets/css/editor-style.css',
        [],
        CP_VERSION
    );
}
add_action( 'enqueue_block_editor_assets', 'classipress_block_editor_assets' );
