<?php
/**
 * Sidebar template.
 *
 * Displays the appropriate sidebar based on the current page.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// Determine which sidebar to load.
$listingcore_theme_sidebar_id = 'sidebar-1';

if ( is_singular( 'listing' ) ) {
	$listingcore_theme_sidebar_id = 'sidebar-listing';
} elseif ( is_page_template( 'template-dashboard.php' ) ) {
	$listingcore_theme_sidebar_id = 'dashboard-sidebar';
}

// Don't output anything if the sidebar is empty.
if ( ! is_active_sidebar( $listingcore_theme_sidebar_id ) ) {
	return;
}
?>

<aside
	id="secondary"
	class="lct-sidebar lct-sidebar--<?php echo esc_attr( $listingcore_theme_sidebar_id ); ?>"
	role="complementary"
	aria-label="<?php esc_attr_e( 'Sidebar', 'listingcore-theme' ); ?>"
>
	<?php dynamic_sidebar( $listingcore_theme_sidebar_id ); ?>
</aside>