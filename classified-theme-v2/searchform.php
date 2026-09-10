<?php
/**
 * Search Form Template
 * Rendered by get_search_form(). Supports both the simple header search
 * and the extended hero search (with category and location fields).
 * The hero wrapper (.cp-hero-search) triggers the extended layout via CSS.
 *
 * @package ClassiPressPro
 */

$unique_id   = esc_attr( uniqid( 'search-form-' ) );
$archive_url = get_post_type_archive_link( 'listing' ) ?: home_url( '/' );
?>
<form role="search" method="get" class="search-form cp-search-form" action="<?php echo esc_url( $archive_url ); ?>">

    <?php /* Keyword field */ ?>
    <div class="cp-search-field cp-search-field--keyword">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" aria-hidden="true" focusable="false">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <label for="<?php echo $unique_id; ?>" class="screen-reader-text">
            <?php echo esc_html_x( 'Search for:', 'label', 'classipress-pro' ); ?>
        </label>
        <input
            type="search"
            id="<?php echo $unique_id; ?>"
            class="search-field cp-search-input"
            placeholder="<?php echo esc_attr_x( 'What are you looking for?', 'placeholder', 'classipress-pro' ); ?>"
            value="<?php echo esc_attr( get_search_query() ); ?>"
            name="s"
            autocomplete="off"
        >
    </div>

    <?php /* Category field — visible in hero layout, hidden in compact header */ ?>
    <div class="cp-search-field cp-search-field--cat cp-search-field--extended">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" aria-hidden="true" focusable="false">
            <path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z"/>
        </svg>
        <label for="<?php echo $unique_id; ?>-cat" class="screen-reader-text">
            <?php esc_html_e( 'Category', 'classipress-pro' ); ?>
        </label>
        <select id="<?php echo $unique_id; ?>-cat" name="listing_category">
            <option value=""><?php esc_html_e( 'All Categories', 'classipress-pro' ); ?></option>
            <?php
            $cats = get_terms( [
                'taxonomy'   => 'listing_category',
                'parent'     => 0,
                'hide_empty' => false,
                'number'     => 100,
            ] );
            if ( $cats && ! is_wp_error( $cats ) ) {
                foreach ( $cats as $cat ) {
                    echo '<option value="' . esc_attr( $cat->slug ) . '">' . esc_html( $cat->name ) . '</option>';
                }
            }
            ?>
        </select>
    </div>

    <div class="cp-search-divider cp-search-field--extended" aria-hidden="true"></div>

    <?php /* Location field — visible in hero layout only */ ?>
    <div class="cp-search-field cp-search-field--loc cp-search-field--extended">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" aria-hidden="true" focusable="false">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
            <circle cx="12" cy="10" r="3"/>
        </svg>
        <label for="<?php echo $unique_id; ?>-loc" class="screen-reader-text">
            <?php esc_html_e( 'Location', 'classipress-pro' ); ?>
        </label>
        <input
            type="text"
            id="<?php echo $unique_id; ?>-loc"
            class="cp-location-input"
            name="cp_location"
            placeholder="<?php esc_attr_e( 'City or Location', 'classipress-pro' ); ?>"
            autocomplete="off"
            value="<?php echo esc_attr( sanitize_text_field( wp_unslash( $_GET['cp_location'] ?? '' ) ) ); ?>"
        >
    </div>

    <button type="submit" class="search-submit cp-search-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'classipress-pro' ); ?></span>
        <span class="cp-search-btn-label cp-search-field--extended"><?php esc_html_e( 'Search', 'classipress-pro' ); ?></span>
    </button>

</form>
