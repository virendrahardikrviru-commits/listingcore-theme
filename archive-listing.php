<?php
/**
 * Listings archive template.
 *
 * Displays the archive of all listings. Uses the ListingCore plugin's
 * shortcode to render listings with proper styling.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="lct-main lct-main--archive-listing" role="main">
	<div class="lct-container">

		<?php listingcore_theme_breadcrumbs(); ?>

		<header class="lct-page-header">
			<h1 class="lct-page-header__title">
				<?php
				if ( is_post_type_archive( 'listing' ) ) {
					esc_html_e( 'All Listings', 'listingcore-theme' );
				} else {
					the_archive_title();
				}
				?>
			</h1>

			<?php
			$description = get_the_archive_description();
			if ( $description ) :
				?>
				<div class="lct-page-header__description">
					<?php echo wp_kses_post( $description ); ?>
				</div>
			<?php endif; ?>

			<?php if ( listingcore_theme_has_plugin() ) : ?>
				<div class="lct-page-header__actions">
					<a href="<?php echo esc_url( home_url( '/submit-listing/' ) ); ?>" class="lct-button lct-button--primary">
						<?php esc_html_e( 'Post a Listing', 'listingcore-theme' ); ?>
					</a>
				</div>
			<?php endif; ?>
		</header>

		<div class="lct-layout <?php echo esc_attr( listingcore_theme_get_layout_class() ); ?>">

			<div class="lct-layout__main">

				<?php if ( listingcore_theme_has_plugin() ) : ?>

					<?php
					/**
					 * The ListingCore plugin provides [listingcore_listings] which
					 * handles the listing loop, pagination, and card rendering.
					 *
					 * We pass through the current query args so filters and search
					 * continue to work.
					 */
					echo do_shortcode( '[listingcore_listings]' );
					?>

				<?php elseif ( have_posts() ) : ?>

					<div class="lct-posts lct-posts--listing">

						<?php
						while ( have_posts() ) :
							the_post();
							?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'lct-listing-card' ); ?>>

								<a href="<?php the_permalink(); ?>" class="lct-listing-card__thumbnail-link" aria-hidden="true" tabindex="-1">
									<?php listingcore_theme_post_thumbnail( get_the_ID(), 'lct-listing-grid' ); ?>
								</a>

								<div class="lct-listing-card__body">
									<h2 class="lct-listing-card__title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h2>

									<div class="lct-listing-card__excerpt">
										<?php the_excerpt(); ?>
									</div>

									<a href="<?php the_permalink(); ?>" class="lct-listing-card__link">
										<?php esc_html_e( 'View Listing', 'listingcore-theme' ); ?>
									</a>
								</div>

							</article>

						<?php endwhile; ?>

					</div>

					<?php listingcore_theme_pagination(); ?>

				<?php else : ?>

					<div class="lct-empty-state">
						<h2 class="lct-empty-state__title">
							<?php esc_html_e( 'No listings found', 'listingcore-theme' ); ?>
						</h2>
						<p class="lct-empty-state__text">
							<?php esc_html_e( 'There are no listings to display at this time.', 'listingcore-theme' ); ?>
						</p>
					</div>

				<?php endif; ?>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>
</main>

<?php
get_footer();