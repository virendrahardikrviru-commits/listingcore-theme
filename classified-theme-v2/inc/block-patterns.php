<?php
/**
 * Block Patterns & Block Styles
 *
 * @package ClassiPressPro
 */

defined( 'ABSPATH' ) || exit;

// ── BLOCK STYLES ─────────────────────────────────────────
add_action( 'init', function () {

    // Button: Accent style
    register_block_style( 'core/button', [
        'name'  => 'cp-accent',
        'label' => __( 'Accent', 'classipress-pro' ),
    ] );

    // Button: Ghost/outline style
    register_block_style( 'core/button', [
        'name'  => 'cp-outline',
        'label' => __( 'Outline', 'classipress-pro' ),
    ] );

    // Group: Card style
    register_block_style( 'core/group', [
        'name'  => 'cp-card',
        'label' => __( 'Card', 'classipress-pro' ),
    ] );

    // Image: Rounded
    register_block_style( 'core/image', [
        'name'  => 'cp-rounded',
        'label' => __( 'Rounded', 'classipress-pro' ),
    ] );

    // Separator: Wide
    register_block_style( 'core/separator', [
        'name'  => 'cp-wide',
        'label' => __( 'Wide', 'classipress-pro' ),
    ] );
} );

// ── BLOCK PATTERNS ────────────────────────────────────────
add_action( 'init', function () {

    register_block_pattern_category( 'classipress', [
        'label' => __( 'ClassiPress Pro', 'classipress-pro' ),
    ] );

    // Pattern: Hero CTA
    register_block_pattern( 'classipress-pro/hero-cta', [
        'title'       => __( 'Hero Call-to-Action', 'classipress-pro' ),
        'description' => __( 'A full-width hero section with heading, description, and button.', 'classipress-pro' ),
        'categories'  => [ 'classipress', 'featured' ],
        'content'     => '<!-- wp:group {"style":{"color":{"background":"#1a56db"},"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-background" style="background-color:#1a56db;padding-top:5rem;padding-bottom:5rem;">
<!-- wp:heading {"textAlign":"center","level":1,"style":{"color":{"text":"#ffffff"},"typography":{"fontWeight":"800","fontSize":"2.5rem"}}} -->
<h1 class="wp-block-heading has-text-align-center" style="color:#ffffff;font-size:2.5rem;font-weight:800;">' . esc_html__( 'Find What You Need, Sell What You Have', 'classipress-pro' ) . '</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","style":{"color":{"text":"rgba(255,255,255,0.8)"},"typography":{"fontSize":"1.125rem"}}} -->
<p class="has-text-align-center" style="color:rgba(255,255,255,0.8);font-size:1.125rem;">' . esc_html__( 'Browse thousands of local classified ads. Post your own for free.', 'classipress-pro' ) . '</p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"accent","style":{"border":{"radius":"0.75rem"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-accent-background-color has-background wp-element-button" style="border-radius:0.75rem">' . esc_html__( 'Browse Listings', 'classipress-pro' ) . '</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline","style":{"border":{"radius":"0.75rem"},"color":{"text":"#ffffff","border":"#ffffff"}}} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" style="border-radius:0.75rem;color:#ffffff;border-color:#ffffff">' . esc_html__( 'Post Free Ad', 'classipress-pro' ) . '</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
    ] );

    // Pattern: Two-column feature section
    register_block_pattern( 'classipress-pro/two-col-features', [
        'title'       => __( 'Two-Column Feature Section', 'classipress-pro' ),
        'description' => __( 'Two columns with icon, heading, and description for feature highlights.', 'classipress-pro' ),
        'categories'  => [ 'classipress', 'columns' ],
        'content'     => '<!-- wp:columns {"style":{"spacing":{"blockGap":"2rem"}}} -->
<div class="wp-block-columns">
<!-- wp:column {"style":{"spacing":{"padding":{"all":"2rem"}},"border":{"radius":"1rem","width":"1px","color":"#e5e7eb"}}} -->
<div class="wp-block-column" style="border-radius:1rem;border:1px solid #e5e7eb;padding:2rem;">
<!-- wp:paragraph {"style":{"typography":{"fontSize":"2.5rem"},"spacing":{"margin":{"bottom":"1rem"}}}} --><p style="font-size:2.5rem;margin-bottom:1rem;">📋</p><!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"style":{"typography":{"fontWeight":"700"}}} --><h3 class="wp-block-heading" style="font-weight:700;">' . esc_html__( 'Easy Listing', 'classipress-pro' ) . '</h3><!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"#6b7280"}}} --><p style="color:#6b7280;">' . esc_html__( 'Post your ad in minutes. Add photos, set your price, and reach buyers instantly.', 'classipress-pro' ) . '</p><!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"style":{"spacing":{"padding":{"all":"2rem"}},"border":{"radius":"1rem","width":"1px","color":"#e5e7eb"}}} -->
<div class="wp-block-column" style="border-radius:1rem;border:1px solid #e5e7eb;padding:2rem;">
<!-- wp:paragraph {"style":{"typography":{"fontSize":"2.5rem"},"spacing":{"margin":{"bottom":"1rem"}}}} --><p style="font-size:2.5rem;margin-bottom:1rem;">🔍</p><!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"style":{"typography":{"fontWeight":"700"}}} --><h3 class="wp-block-heading" style="font-weight:700;">' . esc_html__( 'Smart Search', 'classipress-pro' ) . '</h3><!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"#6b7280"}}} --><p style="color:#6b7280;">' . esc_html__( 'Filter by location, category, price range and more to find exactly what you need.', 'classipress-pro' ) . '</p><!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->',
    ] );

    // Pattern: Simple CTA Banner
    register_block_pattern( 'classipress-pro/cta-banner', [
        'title'       => __( 'CTA Banner', 'classipress-pro' ),
        'description' => __( 'A centered call-to-action banner with button.', 'classipress-pro' ),
        'categories'  => [ 'classipress', 'call-to-action' ],
        'content'     => '<!-- wp:group {"style":{"color":{"background":"#f3f4f6"},"spacing":{"padding":{"top":"3rem","bottom":"3rem"},"blockGap":"1rem"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-background" style="background-color:#f3f4f6;padding-top:3rem;padding-bottom:3rem;">
<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontWeight":"800"}}} -->
<h2 class="wp-block-heading has-text-align-center" style="font-weight:800;">' . esc_html__( 'Ready to list your item?', 'classipress-pro' ) . '</h2>
<!-- /wp:heading -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Post a Free Ad', 'classipress-pro' ) . '</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
    ] );
} );
