<?php
/**
 * Template Functions
 *
 * @package ListingCoreTheme
 */

defined( 'ABSPATH' ) || exit;

// ── PRICE FORMATTING ─────────────────────────────────────

function listingcore_theme_format_price( $price, $currency = 'USD', $price_type = 'fixed' ) {
    if ( $price_type === 'free' ) {
        return '<span class="listingcore-price-free">' . __( 'Free', 'listingcore-theme' ) . '</span>';
    }
    if ( $price_type === 'negotiable' ) {
        return '<span class="listingcore-price-negotiable">' . __( 'Negotiable', 'listingcore-theme' ) . '</span>';
    }
    if ( $price_type === 'on_call' ) {
        return '<span class="listingcore-price-oncall">' . __( 'Contact for Price', 'listingcore-theme' ) . '</span>';
    }

    $symbols = [ 'USD' => '$', 'EUR' => '€', 'GBP' => '£', 'INR' => '₹', 'JPY' => '¥', 'AUD' => 'A$', 'CAD' => 'C$' ];
    $symbol  = $symbols[ $currency ] ?? $currency . ' ';

    return '<span class="listingcore-price-amount">' . $symbol . number_format_i18n( (float) $price, ( $currency === 'JPY' ) ? 0 : 2 ) . '</span>';
}

// ── LISTING CARD ─────────────────────────────────────────

function listingcore_theme_listing_card( $post_id, $args = [] ) {
    $defaults = [
        'show_category' => true,
        'show_location' => true,
        'show_date'     => true,
    ];
    $args = wp_parse_args( $args, $defaults );

    // Maps directly to the ListingCore backend database keys
    $price      = get_post_meta( $post_id, '_listing_price',      true );
    $price_type = get_post_meta( $post_id, '_listing_price_type', true ) ?: 'fixed';
    $currency   = get_post_meta( $post_id, '_listing_currency',   true ) ?: 'INR';
    $city       = get_post_meta( $post_id, '_listing_city',       true );
    $country    = get_post_meta( $post_id, '_listing_country',    true );
    $featured   = get_post_meta( $post_id, '_listing_featured',   true );
    $urgent     = get_post_meta( $post_id, '_listing_urgent',     true );
    $verified   = get_post_meta( $post_id, '_listing_verified',   true );

    $categories = get_the_terms( $post_id, 'listing_category' );
    $cat_name   = ( $categories && ! is_wp_error( $categories ) ) ? $categories[0]->name : '';
    $cat_link   = ( $categories && ! is_wp_error( $categories ) ) ? get_term_link( $categories[0] ) : '';

    $location   = implode( ', ', array_filter( [ $city, $country ] ) );
    ?>
    <article class="listingcore-listing-card" id="listing-<?php echo esc_attr( $post_id ); ?>">

        <div class="listingcore-listing-badge">
            <?php if ( $featured ) : ?>
                <span class="listingcore-badge listingcore-badge-featured"><?php esc_html_e( 'Featured', 'listingcore-theme' ); ?></span>
            <?php endif; ?>
            <?php if ( $urgent ) : ?>
                <span class="listingcore-badge listingcore-badge-urgent"><?php esc_html_e( 'Urgent', 'listingcore-theme' ); ?></span>
            <?php endif; ?>
        </div>

        <button class="listingcore-listing-wishlist" data-id="<?php echo esc_attr( $post_id ); ?>" aria-label="<?php esc_attr_e( 'Save to wishlist', 'listingcore-theme' ); ?>">
            ♡
        </button>

        <div class="listingcore-listing-thumb">
            <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
                    <?php echo get_the_post_thumbnail( $post_id, 'listingcore-listing-grid', [ 'loading' => 'lazy' ] ); ?>
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ); ?>" alt="" loading="lazy" />
                </a>
            <?php endif; ?>
        </div>

        <div class="listingcore-listing-body">
            <?php if ( $args['show_category'] && $cat_name ) : ?>
                <div class="listingcore-listing-category">
                    <a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat_name ); ?></a>
                    <?php if ( $verified ) : ?>
                        <span title="<?php esc_attr_e( 'Verified', 'listingcore-theme' ); ?>"> ✅</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <h3 class="listingcore-listing-title">
                <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a>
            </h3>

            <div class="listingcore-listing-price">
                <?php echo listingcore_theme_format_price( $price, $currency, $price_type ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
            </div>

            <div class="listingcore-listing-meta">
                <?php if ( $args['show_location'] && $location ) : ?>
                    <span>📍 <?php echo esc_html( $location ); ?></span>
                <?php endif; ?>
                <?php if ( $args['show_date'] ) : ?>
                    <span>🕐 <?php echo esc_html( human_time_diff( get_the_date( 'U', $post_id ), current_time( 'timestamp' ) ) . ' ' . __( 'ago', 'listingcore-theme' ) ); ?></span>
                <?php endif; ?>
            </div>
        </div>

    </article>
    <?php
}

// ── BREADCRUMBS ───────────────────────────────────────────

function listingcore_theme_breadcrumbs() {
    if ( is_front_page() ) return;
    ?>
    <nav class="listingcore-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'listingcore-theme' ); ?>">
        <div class="listingcore-container">
            <ol class="listingcore-breadcrumb-list">
                <li><a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'listingcore-theme' ); ?></a></li>
                <?php
                if ( is_single() ) {
                    if ( get_post_type() === 'listingcore' ) {
                        echo '<li><a href="' . esc_url( get_post_type_archive_link( 'listingcore' ) ) . '">' . esc_html__( 'Listings', 'listingcore-theme' ) . '</a></li>';
                        $terms = get_the_terms( get_the_ID(), 'listing_category' );
                        if ( $terms && ! is_wp_error( $terms ) ) {
                            echo '<li><a href="' . esc_url( get_term_link( $terms[0] ) ) . '">' . esc_html( $terms[0]->name ) . '</a></li>';
                        }
                    } else {
                        echo '<li><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . esc_html__( 'Blog', 'listingcore-theme' ) . '</a></li>';
                    }
                    echo '<li aria-current="page">' . esc_html( get_the_title() ) . '</li>';
                } elseif ( is_archive() ) {
                    echo '<li aria-current="page">' . esc_html( get_the_archive_title() ) . '</li>';
                } elseif ( is_page() ) {
                    echo '<li aria-current="page">' . esc_html( get_the_title() ) . '</li>';
                } elseif ( is_search() ) {
                    echo '<li aria-current="page">' . esc_html__( 'Search Results', 'listingcore-theme' ) . '</li>';
                }
                ?>
            </ol>
        </div>
    </nav>
    <?php
}

// ── PAGINATION ────────────────────────────────────────────

function listingcore_theme_pagination( $query = null ) {
    global $wp_query;
    $q = $query ?: $wp_query;

    echo '<nav class="listingcore-pagination" aria-label="' . esc_attr__( 'Page navigation', 'listingcore-theme' ) . '">';
    echo paginate_links( [
        'base'      => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
        'format'    => '?paged=%#%',
        'current'   => max( 1, get_query_var( 'paged' ) ),
        'total'     => $q->max_num_pages,
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
    ] );
    echo '</nav>';
}

// ── VIEW COUNTER ──────────────────────────────────────────

function listingcore_theme_increment_view_count( $post_id ) {
    if ( is_singular( 'listingcore' ) ) {
        $key    = 'listingcore_viewed_' . $post_id;
        $period = 3600; // 1 hour

        if ( ! isset( $_COOKIE[ $key ] ) ) {
            $views = (int) get_post_meta( $post_id, '_listing_views', true );
            update_post_meta( $post_id, '_listing_views', $views + 1 );
            setcookie( $key, '1', time() + $period, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
        }
    }
}
add_action( 'wp', function() { listingcore_theme_increment_view_count( get_the_ID() ); } );

// ── LISTING EXPIRY CHECK ──────────────────────────────────

function listingcore_theme_is_listing_expired( $post_id ) {
    $expires = get_post_meta( $post_id, '_listing_expires', true );
    if ( ! $expires ) {
        return false;
    }
    return ( current_time( 'timestamp' ) > strtotime( $expires ) );
}
