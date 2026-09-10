<?php
/**
 * Template Name: User Dashboard
 * Template Post Type: page
 *
 * Displays the user dashboard via the ListingCore plugin.
 * Users create a page and select "User Dashboard" as the template.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="lct-main lct-main--template-dashboard" role="main">
	<div class="lct-container">

		<?php listingcore_theme_breadcrumbs(); ?>

		<?php if ( ! listingcore_theme_has_plugin() ) : ?>

			<div class="lct-notice lct-notice--warning">
				<h2 class="lct-notice__title">
					<?php esc_html_e( 'ListingCore Plugin Required', 'listingcore-theme' ); ?>
				</h2>
				<p>
					<?php esc_html_e( 'The user dashboard is powered by the ListingCore plugin. Please install and activate it to access your dashboard.', 'listingcore-theme' ); ?>
				</p>

				<?php if ( current_user_can( 'install_plugins' ) ) : ?>
					<p>
						<a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=listingcore&tab=search&type=term' ) ); ?>" class="lct-button lct-button--primary">
							<?php esc_html_e( 'Install ListingCore', 'listingcore-theme' ); ?>
						</a>
					</p>
				<?php endif; ?>
			</div>

		<?php elseif ( ! is_user_logged_in() ) : ?>

			<div class="lct-notice lct-notice--info">
				<h2 class="lct-notice__title">
					<?php esc_html_e( 'Log in to Access Your Dashboard', 'listingcore-theme' ); ?>
				</h2>
				<p>
					<?php esc_html_e( 'Log in to manage your listings, view your wishlist, and update your profile.', 'listingcore-theme' ); ?>
				</p>
				<p>
					<a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="lct-button lct-button--primary">
						<?php esc_html_e( 'Log in', 'listingcore-theme' ); ?>
					</a>
					<?php if ( get_option( 'users_can_register' ) ) : ?>
						<a href="<?php echo esc_url( wp_registration_url() ); ?>" class="lct-button lct-button--outline">
							<?php esc_html_e( 'Register', 'listingcore-theme' ); ?>
						</a>
					<?php endif; ?>
				</p>
			</div>

		<?php else : ?>

			<?php
			$current_user = wp_get_current_user();
			?>

			<header class="lct-page-header lct-page-header--dashboard">
				<h1 class="lct-page-header__title">
					<?php
					printf(
						/* translators: %s: user display name */
						esc_html__( 'Welcome back, %s', 'listingcore-theme' ),
						'<span class="lct-page-header__user">' . esc_html( $current_user->display_name ) . '</span>'
					);
					?>
				</h1>

				<div class="lct-page-header__actions">
					<a href="<?php echo esc_url( home_url( '/submit-listing/' ) ); ?>" class="lct-button lct-button--primary">
						<?php esc_html_e( 'Post a New Listing', 'listingcore-theme' ); ?>
					</a>
				</div>
			</header>

			<div class="lct-layout <?php echo esc_attr( listingcore_theme_get_layout_class() ); ?>">

				<div class="lct-layout__main">

					<?php
					// If the page has its own content, show it above the dashboard.
					while ( have_posts() ) :
						the_post();

						if ( get_the_content() ) :
							?>
							<div class="lct-page-content">
								<?php the_content(); ?>
							</div>
							<?php
						endif;
					endwhile;

					/**
					 * The ListingCore plugin's [listingcore_user_dashboard] shortcode
					 * handles the tabs: my listings, wishlist, profile, etc.
					 */
					echo do_shortcode( '[listingcore_user_dashboard]' );
					?>

				</div>

				<?php get_sidebar(); ?>

			</div>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();