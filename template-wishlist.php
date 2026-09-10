<?php
/**
 * Template Name: Wishlist
 * Template Post Type: page
 *
 * Displays the user's saved wishlist via the ListingCore plugin.
 * Users create a page and select "Wishlist" as the template.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="lct-main lct-main--template-wishlist" role="main">
	<div class="lct-container">

		<?php listingcore_theme_breadcrumbs(); ?>

		<?php if ( ! listingcore_theme_has_plugin() ) : ?>

			<div class="lct-notice lct-notice--warning">
				<h2 class="lct-notice__title">
					<?php esc_html_e( 'ListingCore Plugin Required', 'listingcore-theme' ); ?>
				</h2>
				<p>
					<?php esc_html_e( 'The wishlist feature is powered by the ListingCore plugin. Please install and activate it to use your wishlist.', 'listingcore-theme' ); ?>
				</p>

				<?php if ( current_user_can( 'install_plugins' ) ) : ?>
					<p>
						<a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=listingcore&tab=search&type=term' ) ); ?>" class="lct-button lct-button--primary">
							<?php esc_html_e( 'Install ListingCore', 'listingcore-theme' ); ?>
						</a>
					</p>
				<?php endif; ?>
			</div>

		<?php else : ?>

			<header class="lct-page-header lct-page-header--wishlist">
				<h1 class="lct-page-header__title">
					<?php the_title(); ?>
				</h1>

				<?php
				// Optional page description.
				while ( have_posts() ) :
					the_post();

					if ( get_the_content() ) :
						?>
						<div class="lct-page-header__description">
							<?php the_content(); ?>
						</div>
						<?php
					endif;
				endwhile;
				?>

				<?php if ( ! is_user_logged_in() ) : ?>
					<p class="lct-page-header__note">
						<?php esc_html_e( 'Log in to save your wishlist across devices.', 'listingcore-theme' ); ?>
					</p>
				<?php endif; ?>
			</header>

			<div class="lct-layout <?php echo esc_attr( listingcore_theme_get_layout_class() ); ?>">

				<div class="lct-layout__main">

					<?php
					/**
					 * The ListingCore plugin's [listingcore_wishlist] shortcode
					 * handles the display, removal, and persistence of wishlisted items.
					 *
					 * Works for both logged-in users (saved to user meta) and
					 * guests (saved via cookie/local storage).
					 */
					echo do_shortcode( '[listingcore_wishlist]' );
					?>

					<div class="lct-wishlist__actions">
						<a href="<?php echo esc_url( home_url( '/listings/' ) ); ?>" class="lct-button lct-button--outline">
							<?php esc_html_e( 'Continue Browsing Listings', 'listingcore-theme' ); ?>
						</a>
					</div>

				</div>

				<?php get_sidebar(); ?>

			</div>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();