<?php
/**
 * Template Name: Listings Archive
 * Template Post Type: page
 *
 * Displays all listings via the ListingCore plugin.
 * Users create a page and select "Listings Archive" as the template.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="listingcore-main listingcore-main--template-listings" role="main">
	<div class="listingcore-container">

		<?php listingcore_theme_breadcrumbs(); ?>

		<header class="listingcore-page-header">
			<h1 class="listingcore-page-header__title">
				<?php the_title(); ?>
			</h1>

			<?php
			// Optional page description.
			while ( have_posts() ) :
				the_post();

				if ( get_the_content() ) :
					?>
					<div class="listingcore-page-header__description">
						<?php the_content(); ?>
					</div>
					<?php
				endif;
			endwhile;
			?>

			<?php if ( listingcore_theme_has_plugin() ) : ?>
				<div class="listingcore-page-header__actions">
					<a href="<?php echo esc_url( home_url( '/submit-listing/' ) ); ?>" class="listingcore-button listingcore-button--primary">
						<?php esc_html_e( 'Post a Listing', 'listingcore-theme' ); ?>
					</a>
				</div>
			<?php endif; ?>
		</header>

		<div class="listingcore-layout <?php echo esc_attr( listingcore_theme_get_layout_class() ); ?>">

			<div class="listingcore-layout__main">

				<?php if ( listingcore_theme_has_plugin() ) : ?>

					<?php
					/**
					 * The ListingCore plugin's [listingcore_listings] shortcode
					 * handles the listing loop, filters, pagination, and card rendering.
					 *
					 * It automatically uses the URL query parameters for filtering,
					 * so users can search/filter listings via the URL.
					 */
					echo do_shortcode( '[listingcore_listings]' );
					?>

				<?php else : ?>

					<div class="listingcore-notice listingcore-notice--info">
						<h2 class="listingcore-notice__title">
							<?php esc_html_e( 'ListingCore Plugin Required', 'listingcore-theme' ); ?>
						</h2>
						<p>
							<?php esc_html_e( 'This page displays listings powered by the ListingCore plugin. Please install and activate it to see listings here.', 'listingcore-theme' ); ?>
						</p>

						<?php if ( current_user_can( 'install_plugins' ) ) : ?>
							<p>
								<a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=listingcore&tab=search&type=term' ) ); ?>" class="listingcore-button listingcore-button--primary">
									<?php esc_html_e( 'Install ListingCore', 'listingcore-theme' ); ?>
								</a>
							</p>
						<?php endif; ?>
					</div>

				<?php endif; ?>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>
</main>

<?php
get_footer();