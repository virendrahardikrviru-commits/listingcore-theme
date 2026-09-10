<?php
/**
 * Plugin recommendation.
 *
 * Recommends the ListingCore plugin via a non-intrusive admin notice.
 * Complies with WordPress.org theme guidelines: recommends (not requires).
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Check if the ListingCore plugin is installed (active or not).
 *
 * @return bool
 */
function listingcore_theme_is_plugin_installed() {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$plugins = get_plugins();

	return isset( $plugins['listingcore/listingcore.php'] );
}

/**
 * Check if the ListingCore plugin is active.
 *
 * @return bool
 */
function listingcore_theme_is_plugin_active() {
	if ( ! function_exists( 'is_plugin_active' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	return is_plugin_active( 'listingcore/listingcore.php' );
}

/**
 * Get the install URL for the ListingCore plugin.
 *
 * @return string
 */
function listingcore_theme_get_install_url() {
	return wp_nonce_url(
		self_admin_url( 'update.php?action=install-plugin&plugin=listingcore' ),
		'install-plugin_listingcore'
	);
}

/**
 * Get the activate URL for the ListingCore plugin.
 *
 * @return string
 */
function listingcore_theme_get_activate_url() {
	return wp_nonce_url(
		self_admin_url( 'plugins.php?action=activate&plugin=listingcore/listingcore.php' ),
		'activate-plugin_listingcore/listingcore.php'
	);
}

/**
 * Show an admin notice recommending the ListingCore plugin.
 *
 * Displayed only when:
 * - Plugin is NOT active.
 * - Current user can install/activate plugins.
 * - User has not dismissed the notice.
 */
function listingcore_theme_plugin_recommendation_notice() {

	// Don't show if plugin is already active.
	if ( listingcore_theme_is_plugin_active() ) {
		return;
	}

	// Don't show to users without capability.
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}

	// Don't show if user dismissed it.
	$dismissed = get_user_meta( get_current_user_id(), 'listingcore_theme_notice_dismissed', true );
	if ( 'yes' === $dismissed ) {
		return;
	}

	$is_installed = listingcore_theme_is_plugin_installed();
	$action_url   = $is_installed
		? listingcore_theme_get_activate_url()
		: listingcore_theme_get_install_url();

	$action_label = $is_installed
		? __( 'Activate ListingCore', 'listingcore-theme' )
		: __( 'Install ListingCore', 'listingcore-theme' );

	?>
	<div class="notice notice-info is-dismissible listingcore-theme-notice">
		<h3 class="listingcore-theme-notice__title">
			<?php esc_html_e( 'Thank you for installing ListingCore Theme!', 'listingcore-theme' ); ?>
		</h3>
		<p>
			<?php
			if ( $is_installed ) {
				esc_html_e( 'ListingCore plugin is installed but not active. Activate it to unlock the full theme experience — listings, search, categories, wishlist, dashboard, and more.', 'listingcore-theme' );
			} else {
				esc_html_e( 'To unlock the full potential of this theme, install the free ListingCore plugin. It powers listings, search, categories, wishlist, and the user dashboard.', 'listingcore-theme' );
			}
			?>
		</p>
		<p>
			<a href="<?php echo esc_url( $action_url ); ?>" class="button button-primary">
				<?php echo esc_html( $action_label ); ?>
			</a>
			<a href="<?php echo esc_url( 'https://wordpress.org/plugins/listingcore/' ); ?>" class="button button-secondary" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'View Plugin Details', 'listingcore-theme' ); ?>
			</a>
			<button type="button" class="button-link listingcore-theme-notice__dismiss" style="margin-left: 12px;">
				<?php esc_html_e( 'Dismiss this notice', 'listingcore-theme' ); ?>
			</button>
		</p>
	</div>

	<script type="text/javascript">
		( function() {
			var notice = document.querySelector( '.listingcore-theme-notice' );
			if ( ! notice ) {
				return;
			}
			var dismissBtn = notice.querySelector( '.listingcore-theme-notice__dismiss' );
			if ( ! dismissBtn ) {
				return;
			}
			dismissBtn.addEventListener( 'click', function( e ) {
				e.preventDefault();
				notice.style.display = 'none';
				var data = new FormData();
				data.append( 'action', 'listingcore_theme_dismiss_notice' );
				data.append( 'nonce', '<?php echo esc_js( wp_create_nonce( 'listingcore_theme_dismiss_notice' ) ); ?>' );
				fetch( ajaxurl, {
					method: 'POST',
					body: data,
					credentials: 'same-origin'
				} );
			} );
		} )();
	</script>
	<?php
}
add_action( 'admin_notices', 'listingcore_theme_plugin_recommendation_notice' );

/**
 * AJAX handler to dismiss the recommendation notice.
 */
function listingcore_theme_dismiss_notice_ajax() {
	check_ajax_referer( 'listingcore_theme_dismiss_notice', 'nonce' );

	if ( ! current_user_can( 'install_plugins' ) ) {
		wp_send_json_error( [ 'message' => __( 'Permission denied.', 'listingcore-theme' ) ] );
	}

	update_user_meta( get_current_user_id(), 'listingcore_theme_notice_dismissed', 'yes' );

	wp_send_json_success( [ 'message' => __( 'Notice dismissed.', 'listingcore-theme' ) ] );
}
add_action( 'wp_ajax_listingcore_theme_dismiss_notice', 'listingcore_theme_dismiss_notice_ajax' );