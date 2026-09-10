<?php
/**
 * Block patterns.
 *
 * Registers reusable block patterns for the theme.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the block pattern category.
 */
function listingcore_theme_register_pattern_category() {
	if ( ! function_exists( 'register_block_pattern_category' ) ) {
		return;
	}

	register_block_pattern_category(
		'listingcore-theme',
		[
			'label'       => __( 'ListingCore Theme', 'listingcore-theme' ),
			'description' => __( 'Patterns for building classified ads, marketplace, and directory pages.', 'listingcore-theme' ),
		]
	);
}
add_action( 'init', 'listingcore_theme_register_pattern_category' );

/**
 * Register block patterns.
 */
function listingcore_theme_register_block_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	// -------------------------------------------------------------------------
	// Hero Search
	// -------------------------------------------------------------------------
	register_block_pattern(
		'listingcore-theme/hero-search',
		[
			'title'       => __( 'Hero with Search', 'listingcore-theme' ),
			'description' => __( 'A full-width hero section with a headline and the ListingCore search form.', 'listingcore-theme' ),
			'categories'  => [ 'listingcore-theme', 'header' ],
			'content'     => '<!-- wp:cover {"overlayColor":"primary","minHeight":420,"align":"full"} -->
<div class="wp-block-cover alignfull" style="min-height:420px"><span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontSize":"48px","fontWeight":"800"}}} -->
<h1 class="wp-block-heading has-text-align-center" style="font-size:48px;font-weight:800">' . esc_html__( 'Find What You Need', 'listingcore-theme' ) . '</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"18px"}}} -->
<p class="has-text-align-center" style="font-size:18px">' . esc_html__( 'Browse thousands of listings across categories.', 'listingcore-theme' ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[listingcore_search_form]
<!-- /wp:shortcode --></div></div>
<!-- /wp:cover -->',
		]
	);

	// -------------------------------------------------------------------------
	// Categories Grid
	// -------------------------------------------------------------------------
	register_block_pattern(
		'listingcore-theme/categories-grid',
		[
			'title'       => __( 'Categories Grid', 'listingcore-theme' ),
			'description' => __( 'A section displaying ListingCore listing categories in a grid.', 'listingcore-theme' ),
			'categories'  => [ 'listingcore-theme' ],
			'content'     => '<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"60px","bottom":"60px"}}}} -->
<div class="wp-block-group alignwide" style="padding-top:60px;padding-bottom:60px"><!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="wp-block-heading has-text-align-center">' . esc_html__( 'Browse by Category', 'listingcore-theme' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:shortcode -->
[listingcore_categories]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->',
		]
	);

	// -------------------------------------------------------------------------
	// Featured Listings
	// -------------------------------------------------------------------------
	register_block_pattern(
		'listingcore-theme/featured-listings',
		[
			'title'       => __( 'Featured Listings', 'listingcore-theme' ),
			'description' => __( 'A section showing the latest listings from the ListingCore plugin.', 'listingcore-theme' ),
			'categories'  => [ 'listingcore-theme' ],
			'content'     => '<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"60px","bottom":"60px"}}}} -->
<div class="wp-block-group alignwide" style="padding-top:60px;padding-bottom:60px"><!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="wp-block-heading has-text-align-center">' . esc_html__( 'Latest Listings', 'listingcore-theme' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:shortcode -->
[listingcore_listings count="6"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->',
		]
	);

	// -------------------------------------------------------------------------
	// Call to Action
	// -------------------------------------------------------------------------
	register_block_pattern(
		'listingcore-theme/cta',
		[
			'title'       => __( 'Call to Action', 'listingcore-theme' ),
			'description' => __( 'A call-to-action section with a Post Listing button.', 'listingcore-theme' ),
			'categories'  => [ 'listingcore-theme', 'call-to-action' ],
			'content'     => '<!-- wp:group {"align":"full","backgroundColor":"dark","style":{"spacing":{"padding":{"top":"60px","bottom":"60px"}}}} -->
<div class="wp-block-group alignfull has-dark-background-color has-background" style="padding-top:60px;padding-bottom:60px"><!-- wp:heading {"textAlign":"center","level":2,"textColor":"light"} -->
<h2 class="wp-block-heading has-text-align-center has-light-color has-text-color">' . esc_html__( 'Ready to Sell Something?', 'listingcore-theme' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"light"} -->
<p class="has-text-align-center has-light-color has-text-color">' . esc_html__( 'Post your listing in minutes. It is free and easy.', 'listingcore-theme' ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[listingcore_post_listing_button]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->',
		]
	);

	// -------------------------------------------------------------------------
	// Two-Column: Content + Sidebar
	// -------------------------------------------------------------------------
	register_block_pattern(
		'listingcore-theme/content-with-sidebar',
		[
			'title'       => __( 'Content with Sidebar', 'listingcore-theme' ),
			'description' => __( 'A two-column layout with main content and a sidebar.', 'listingcore-theme' ),
			'categories'  => [ 'listingcore-theme' ],
			'content'     => '<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:heading -->
<h2 class="wp-block-heading">' . esc_html__( 'Main Content', 'listingcore-theme' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . esc_html__( 'Add your content here.', 'listingcore-theme' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . esc_html__( 'Sidebar', 'listingcore-theme' ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . esc_html__( 'Add sidebar widgets or content here.', 'listingcore-theme' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
		]
	);

	// -------------------------------------------------------------------------
	// Full-width CTA Banner
	// -------------------------------------------------------------------------
	register_block_pattern(
		'listingcore-theme/banner-cta',
		[
			'title'       => __( 'Banner CTA', 'listingcore-theme' ),
			'description' => __( 'A compact banner with headline and button.', 'listingcore-theme' ),
			'categories'  => [ 'listingcore-theme', 'banner' ],
			'content'     => '<!-- wp:group {"align":"full","backgroundColor":"primary","style":{"spacing":{"padding":{"top":"40px","bottom":"40px"}}}} -->
<div class="wp-block-group alignfull has-primary-background-color has-background" style="padding-top:40px;padding-bottom:40px"><!-- wp:columns {"verticalAlignment":"center","align":"wide"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading {"level":3,"textColor":"light"} -->
<h3 class="wp-block-heading has-light-color has-text-color">' . esc_html__( 'Start listing today', 'listingcore-theme' ) . '</h3>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"33.33%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:33.33%"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"right"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"light","textColor":"dark"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-dark-color has-light-background-color has-text-color has-background wp-element-button" href="#">' . esc_html__( 'Get Started', 'listingcore-theme' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
		]
	);
}
add_action( 'init', 'listingcore_theme_register_block_patterns' );