<?php
/**
 * ClassiPress Pro Theme Functions
 *
 * @package ClassiPressPro
 *
 * ClassiPress Pro WordPress Theme
 * Copyright (C) 2024 Your Name
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

defined( 'ABSPATH' ) || exit;

// ─────────────────────────────────────────────────────────
// CONSTANTS
// ─────────────────────────────────────────────────────────
define( 'CP_VERSION', '1.0.4' );
define( 'CP_DIR',     get_template_directory() );
define( 'CP_URI',     get_template_directory_uri() );
define( 'CP_INC',     CP_DIR . '/inc' );

// ─────────────────────────────────────────────────────────
// THEME FILES  (presentation only — no plugin-territory)
// ─────────────────────────────────────────────────────────
require_once CP_INC . '/theme-setup.php';
require_once CP_INC . '/enqueue.php';
require_once CP_INC . '/template-functions.php';
require_once CP_INC . '/template-hooks.php';
require_once CP_INC . '/widgets.php';
require_once CP_INC . '/customizer.php';
require_once CP_INC . '/block-patterns.php';
require_once CP_INC . '/class-cp-walker-nav-menu.php';

// WooCommerce presentation layer (wrappers, sidebar, styles only)
if ( class_exists( 'WooCommerce' ) ) {
    require_once CP_INC . '/woocommerce.php';
}

// ─────────────────────────────────────────────────────────
// ADMIN NOTICE: companion plugin required
// ─────────────────────────────────────────────────────────
add_action( 'admin_notices', function () {
    if ( ! function_exists( 'cpp_register_post_types' ) ) {
        echo '<div class="notice notice-warning"><p>';
        printf(
            wp_kses(
                __( '<strong>ClassiPress Pro</strong> requires the <strong>ClassiPress Pro Core</strong> plugin for full functionality. Please install and activate it.', 'classipress-pro' ),
                [ 'strong' => [] ]
            )
        );
        echo '</p></div>';
    }
} );
