<?php
/**
 * Dashboard main template part.
 *
 * Provides the dashboard wrapper layout. The actual dashboard content
 * is rendered by the ListingCore plugin's [listingcore_user_dashboard] shortcode.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_user_logged_in() ) {
	return;
}

$listingcore_theme_user = wp_get_current_user();
?>

<div class="listingcore-dashboard">

	<aside class="listingcore-dashboard__sidebar" aria-label="<?php esc_attr_e( 'Dashboard navigation', 'listingcore-theme' ); ?>">

		<div class="listingcore-dashboard__user">

			<div class="listingcore-dashboard__avatar">
				<?php echo get_avatar( $listingcore_theme_user->ID, 80 ); ?>
			</div>

			<div class="listingcore-dashboard__user-info">
				<strong class="listingcore-dashboard__user-name">
					<?php echo esc_html( $listingcore_theme_user->display_name ); ?>
				</strong>

				<span class="listingcore-dashboard__user-email">
					<?php echo esc_html( $listingcore_theme_user->user_email ); ?>
				</span>
			</div>

		</div>

		<nav class="listingcore-dashboard__nav">
			<ul class="listingcore-dashboard__nav-list">

				<li class="listingcore-dashboard__nav-item">
					<a href="<?php echo esc_url( home_url( '/dashboard/' ) ); ?>" class="listingcore-dashboard__nav-link">
						<?php esc_html_e( 'Overview', 'listingcore-theme' ); ?>
					</a>
				</li>

				<li class="listingcore-dashboard__nav-item">
					<a href="<?php echo esc_url( home_url( '/dashboard/?tab=listings' ) ); ?>" class="listingcore-dashboard__nav-link">
						<?php esc_html_e( 'My Listings', 'listingcore-theme' ); ?>
					</a>
				</li>

				<li class="listingcore-dashboard__nav-item">
					<a href="<?php echo esc_url( home_url( '/dashboard/?tab=wishlist' ) ); ?>" class="listingcore-dashboard__nav-link">
						<?php esc_html_e( 'Wishlist', 'listingcore-theme' ); ?>
					</a>
				</li>

				<li class="listingcore-dashboard__nav-item">
					<a href="<?php echo esc_url( home_url( '/dashboard/?tab=profile' ) ); ?>" class="listingcore-dashboard__nav-link">
						<?php esc_html_e( 'Profile', 'listingcore-theme' ); ?>
					</a>
				</li>

				<li class="listingcore-dashboard__nav-item">
					<a href="<?php echo esc_url( home_url( '/submit-listing/' ) ); ?>" class="listingcore-dashboard__nav-link listingcore-dashboard__nav-link--cta">
						<?php esc_html_e( '+ Post a Listing', 'listingcore-theme' ); ?>
					</a>
				</li>

				<li class="listingcore-dashboard__nav-item">
					<a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>" class="listingcore-dashboard__nav-link listingcore-dashboard__nav-link--logout">
						<?php esc_html_e( 'Log Out', 'listingcore-theme' ); ?>
					</a>
				</li>

			</ul>
		</nav>

	</aside>

	<div class="listingcore-dashboard__content">
		<?php
		/**
		 * Dashboard content area.
		 *
		 * The actual plugin output is rendered by the parent template via
		 * [listingcore_user_dashboard] shortcode.
		 *
		 * This part provides the wrapper only.
		 */
		?>
	</div>

</div>