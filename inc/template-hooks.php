<?php
/**
 * Template Hooks — connects actions to template-part functions
 *
 * @package ClassiPressPro
 */

defined( 'ABSPATH' ) || exit;

// ── HEADER ────────────────────────────────────────────────
add_action( 'classipress_header',       'classipress_template_header_inner', 10 );

function classipress_template_header_inner() {
    get_template_part( 'template-parts/header/header', 'inner' );
}

// ── FOOTER ────────────────────────────────────────────────
add_action( 'classipress_footer',       'classipress_template_footer_inner', 10 );

function classipress_template_footer_inner() {
    get_template_part( 'template-parts/footer/footer', 'inner' );
}

// ── LISTING ARCHIVE ───────────────────────────────────────
add_action( 'classipress_before_listings_loop', 'classipress_listing_archive_header', 10 );

function classipress_listing_archive_header() {
    get_template_part( 'template-parts/listing/archive', 'header' );
}

// ── SCHEMA MARKUP ─────────────────────────────────────────
add_action( 'wp_head', 'classipress_schema_markup' );

function classipress_schema_markup() {
    if ( is_singular( 'listing' ) ) {
        $post_id  = get_the_ID();
        $price    = get_post_meta( $post_id, '_cp_price',    true );
        $currency = get_post_meta( $post_id, '_cp_currency', true ) ?: 'USD';
        $city     = get_post_meta( $post_id, '_cp_city',     true );
        $country  = get_post_meta( $post_id, '_cp_country',  true );

        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Product',
            'name'        => get_the_title(),
            'description' => wp_strip_all_tags( get_the_excerpt() ),
            'url'         => get_permalink(),
        ];

        if ( has_post_thumbnail() ) {
            $schema['image'] = get_the_post_thumbnail_url( null, 'full' );
        }

        if ( $price ) {
            $schema['offers'] = [
                '@type'         => 'Offer',
                'price'         => $price,
                'priceCurrency' => $currency,
                'availability'  => 'https://schema.org/InStock',
                'url'           => get_permalink(),
            ];
        }

        if ( $city || $country ) {
            $schema['locationCreated'] = [
                '@type'          => 'Place',
                'addressLocality'=> $city,
                'addressCountry' => $country,
            ];
        }

        echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
    }
}

// ── BODY CLASSES ─────────────────────────────────────────
add_filter( 'body_class', 'classipress_body_classes' );

function classipress_body_classes( $classes ) {
    if ( is_singular( 'listing' ) ) $classes[] = 'cp-single-listing';
    if ( is_post_type_archive( 'listing' ) ) $classes[] = 'cp-archive-listing';
    if ( is_tax( [ 'listing_category', 'listing_location' ] ) ) $classes[] = 'cp-tax-listing';
    if ( get_theme_mod( 'cp_sticky_header', true ) ) $classes[] = 'cp-sticky-header';
    return $classes;
}

// ── TITLE ─────────────────────────────────────────────────
add_filter( 'the_title', 'classipress_listing_title_expired', 10, 2 );

function classipress_listing_title_expired( $title, $post_id ) {
    if ( get_post_type( $post_id ) === 'listing' && cp_is_listing_expired( $post_id ) ) {
        $title .= ' <span class="cp-badge cp-badge-expired">' . esc_html__( 'Expired', 'classipress-pro' ) . '</span>';
    }
    return $title;
}

// ── SEARCH QUERY FIX ─────────────────────────────────────
add_action( 'pre_get_posts', 'classipress_modify_search_query' );

function classipress_modify_search_query( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) {

        // Include listings in search
        if ( $query->is_search() ) {
            $query->set( 'post_type', [ 'post', 'page', 'listing' ] );
        }

        // Listings per page from customizer
        if ( $query->is_post_type_archive( 'listing' ) || $query->is_tax( 'listing_category' ) ) {
            $per_page = get_theme_mod( 'cp_listings_per_page', 12 );
            $query->set( 'posts_per_page', $per_page );

            // Default sort: featured first, then date
            if ( ! isset( $_GET['orderby'] ) ) {
                $query->set( 'meta_key', '_cp_featured' );
                $query->set( 'orderby', [ 'meta_value' => 'DESC', 'date' => 'DESC' ] );
            }
        }
    }
}
