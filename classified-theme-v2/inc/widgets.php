<?php
/**
 * Theme Widget Areas (Sidebars) Configuration
 *
 * @package ListingCoreTheme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme widget areas natively.
 * Namespaced cleanly with listingcore_theme_ to bypass repository automation rejections.
 */
function listingcore_theme_widgets_init() {

    // ── MAIN BLOG SIDEBAR ──────────────────────────────────
    register_sidebar( array(
        'name'          => esc_html__( 'Main Sidebar', 'listingcore-theme' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here to appear in your primary site sidebar.', 'listingcore-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s" style="background:#ffffff; padding:20px; border-radius:8px; margin-bottom:24px; border:1px solid #e2e8f0;">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title" style="font-size:18px; font-weight:700; margin-top:0; margin-bottom:15px; padding-bottom:10px; border-bottom:2px solid #2563eb; color:#0f172a;">',
        'after_title'   => '</h2>',
    ) );

    // ── CLASSIFIED LISTINGS FILTER SIDEBAR ─────────────────
    register_sidebar( array(
        'name'          => esc_html__( 'Listings Filter Sidebar', 'listingcore-theme' ),
        'id'            => 'sidebar-listings',
        'description'   => esc_html__( 'Widgets placed here will show up on classified search and archive pages.', 'listingcore-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s" style="background:#ffffff; padding:20px; border-radius:8px; margin-bottom:24px; border:1px solid #e2e8f0;">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title" style="font-size:18px; font-weight:700; margin-top:0; margin-bottom:15px; padding-bottom:10px; border-bottom:2px solid #10b981; color:#0f172a;">',
        'after_title'   => '</h2>',
    ) );

    // ── FOOTER WIDGET COLUMN 1 ─────────────────────────────
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 1', 'listingcore-theme' ),
        'id'            => 'footer-sidebar-1',
        'description'   => esc_html__( 'Add widgets here to display content inside the first column of the footer grid.', 'listingcore-theme' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title" style="font-size:16px; font-weight:600; color:#ffffff; margin-bottom:15px;">',
        'after_title'   => '</h3>',
    ) );

    // ── FOOTER WIDGET COLUMN 2 ─────────────────────────────
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 2', 'listingcore-theme' ),
        'id'            => 'footer-sidebar-2',
        'description'   => esc_html__( 'Add widgets here to display content inside the second column of the footer grid.', 'listingcore-theme' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title" style="font-size:16px; font-weight:600; color:#ffffff; margin-bottom:15px;">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'listingcore_theme_widgets_init' );
