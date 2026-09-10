<?php
/**
 * WooCommerce Compatibility
 *
 * @package ClassiPressPro
 */

defined( 'ABSPATH' ) || exit;

// Remove default WooCommerce wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',     10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );

// Add our own wrappers
add_action( 'woocommerce_before_main_content', 'classipress_woo_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content',  'classipress_woo_wrapper_end',   10 );

function classipress_woo_wrapper_start() {
    echo '<div class="cp-woo-wrapper"><main id="main" class="site-main">';
}

function classipress_woo_wrapper_end() {
    echo '</main></div>';
}

// Add sidebar to WooCommerce pages
add_action( 'woocommerce_sidebar', 'classipress_woo_sidebar', 10 );

function classipress_woo_sidebar() {
    get_sidebar();
}

// Breadcrumbs compatibility
add_filter( 'woocommerce_breadcrumb_defaults', function( $defaults ) {
    $defaults['delimiter'] = ' &rsaquo; ';
    return $defaults;
} );

// Paid listings via WooCommerce
if ( get_theme_mod( 'cp_paid_listings', false ) ) {

    // Create listing product on checkout
    add_action( 'woocommerce_order_status_completed', 'classipress_activate_listing_on_purchase' );

    function classipress_activate_listing_on_purchase( $order_id ) {
        $order = wc_get_order( $order_id );
        if ( ! $order ) return;

        $listing_id = $order->get_meta( '_cp_listing_id' );
        if ( ! $listing_id ) return;

        wp_update_post( [
            'ID'          => (int) $listing_id,
            'post_status' => 'publish',
        ] );

        update_post_meta( $listing_id, '_cp_featured', '1' );
        update_post_meta( $listing_id, '_cp_paid_order_id', $order_id );
    }
}
