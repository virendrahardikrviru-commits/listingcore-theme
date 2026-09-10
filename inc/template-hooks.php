<?php
/**
 * Template hooks.
 *
 * Centralized hooks for injecting markup into templates.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// -----------------------------------------------------------------------------
// Body classes
// -----------------------------------------------------------------------------
/**
 * Add custom body classes.
 *
 * @param array $classes Existing body classes.
 * @return array
 */
function listingcore_theme_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'listingcore-hfeed';
	}

	if ( is_page_template( 'template-listings.php' ) ) {
		$classes[] = 'listingcore-page-listings';
	}

	if ( is_page_template( 'template-dashboard.php' ) ) {
		$classes[] = 'listingcore-page-dashboard';
	}

	if ( is_page_template( 'template-submit.php' ) ) {
		$classes[] = 'listingcore-page-submit';
	}

	if ( is_page_template( 'template-wishlist.php' ) ) {
		$classes[] = 'listingcore-page-wishlist';
	}

	if ( ! listingcore_theme_has_plugin() ) {
		$classes[] = 'listingcore-plugin-missing';
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'listingcore-has-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'listingcore_theme_body_classes' );

// -----------------------------------------------------------------------------
// Header hooks
// -----------------------------------------------------------------------------
/**
 * Output the skip link before the header.
 */
function listingcore_theme_skip_link() {
	printf(
		'<a class="listingcore-skip-link screen-reader-text" href="#content">%s</a>',
		esc_html__( 'Skip to content', 'listingcore-theme' )
	);
}
add_action( 'wp_body_open', 'listingcore_theme_skip_link', 5 );

/**
 * Output the header top bar.
 */
function listingcore_theme_header_top() {
	if ( ! has_nav_menu( 'secondary' ) ) {
		return;
	}

	echo '<div class="listingcore-topbar"><div class="listingcore-container">';
	wp_nav_menu( [
		'theme_location'  => 'secondary',
		'container'       => 'nav',
		'container_class' => 'listingcore-nav listingcore-nav--secondary',
		'menu_class'      => 'listingcore-menu listingcore-menu--secondary',
		'depth'           => 1,
		'fallback_cb'     => false,
	] );
	echo '</div></div>';
}
add_action( 'listingcore_theme_before_header', 'listingcore_theme_header_top' );

// -----------------------------------------------------------------------------
// Footer hooks
// -----------------------------------------------------------------------------
/**
 * Output the footer widgets area.
 */
function listingcore_theme_footer_widgets() {
	$columns = [
		'footer-1' => __( 'Footer Column 1', 'listingcore-theme' ),
		'footer-2' => __( 'Footer Column 2', 'listingcore-theme' ),
		'footer-3' => __( 'Footer Column 3', 'listingcore-theme' ),
		'footer-4' => __( 'Footer Column 4', 'listingcore-theme' ),
	];

	$has_widgets = false;

	foreach ( $columns as $id => $name ) {
		if ( is_active_sidebar( $id ) ) {
			$has_widgets = true;
			break;
		}
	}

	if ( ! $has_widgets ) {
		return;
	}

	echo '<div class="listingcore-footer__widgets"><div class="listingcore-container">';
	echo '<div class="listingcore-footer__grid">';

	foreach ( $columns as $id => $name ) {
		if ( ! is_active_sidebar( $id ) ) {
			continue;
		}

		echo '<div class="listingcore-footer__column" data-widget-area="' . esc_attr( $id ) . '">';
		dynamic_sidebar( $id );
		echo '</div>';
	}

	echo '</div></div></div>';
}
add_action( 'listingcore_theme_footer', 'listingcore_theme_footer_widgets', 10 );

/**
 * Output the footer bottom bar (copyright + footer menu).
 */
function listingcore_theme_footer_bottom() {
	?>
	<div class="listingcore-footer__bottom">
		<div class="listingcore-container">
			<div class="listingcore-footer__bottom-inner">

				<p class="listingcore-footer__copyright">
					<?php
					printf(
						/* translators: 1: current year, 2: site name. */
						esc_html__( '© %1$s %2$s. All rights reserved.', 'listingcore-theme' ),
						listingcore_theme_current_year(),
						esc_html( get_bloginfo( 'name' ) )
					);
					?>
				</p>

				<?php listingcore_theme_footer_nav(); ?>

			</div>
		</div>
	</div>
	<?php
}
add_action( 'listingcore_theme_footer', 'listingcore_theme_footer_bottom', 20 );

// -----------------------------------------------------------------------------
// Content hooks
// -----------------------------------------------------------------------------
/**
 * Output post meta (date, author, comments).
 */
function listingcore_theme_post_meta() {
	if ( 'post' !== get_post_type() ) {
		return;
	}

	printf(
		'<div class="listingcore-post-meta"><time datetime="%1$s">%2$s</time> · <span class="listingcore-post-meta__author">%3$s</span></div>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_html( get_the_author() )
	);
}
add_action( 'listingcore_theme_after_entry_title', 'listingcore_theme_post_meta' );

/**
 * Output pagination after archive/loop.
 */
function listingcore_theme_after_loop() {
	if ( is_singular() ) {
		return;
	}

	listingcore_theme_pagination();
}
add_action( 'listingcore_theme_after_loop', 'listingcore_theme_after_loop' );

// -----------------------------------------------------------------------------
// Plugin missing notice (front-end, admins only)
// -----------------------------------------------------------------------------
/**
 * Output a front-end notice when ListingCore plugin is missing.
 */
function listingcore_theme_plugin_notice() {
	if ( listingcore_theme_has_plugin() ) {
		return;
	}

	if ( ! is_user_logged_in() || ! current_user_can( 'install_plugins' ) ) {
		return;
	}

	printf(
		'<div class="listingcore-notice listingcore-notice--warning"><div class="listingcore-container">%s</div></div>',
		esc_html__( 'ListingCore Theme works best with the ListingCore plugin. Please install and activate it for full functionality.', 'listingcore-theme' )
	);
}
add_action( 'listingcore_theme_before_header', 'listingcore_theme_plugin_notice', 1 );