<?php
/**
 * 404 template.
 *
 * Displays when a page or post cannot be found.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="lct-main lct-main--404" role="main">
	<div class="lct-container">

		<div class="lct-error-page">

			<header class="lct-error-page__header">
				<p class="lct-error-page__code" aria-hidden="true">404</p>
				<h1 class="lct-error-page__title">
					<?php esc_html_e( 'Page Not Found', 'listingcore-theme' ); ?>
				</h1>
			</header>

			<div class="lct-error-page__content">
				<p>
					<?php esc_html_e( 'Sorry, the page you were looking for could not be found. It may have been removed, renamed, or is temporarily unavailable.', 'listingcore-theme' ); ?>
				</p>

				<?php
				// Show a search form so users can try again.
				get_search_form( [
					'aria_label' => __( 'Search this site', 'listingcore-theme' ),
				] );
				?>

				<div class="lct-error-page__actions">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="lct-button lct-button--primary">
						<?php esc_html_e( 'Back to Homepage', 'listingcore-theme' ); ?>
					</a>

					<?php if ( listingcore_theme_has_plugin() ) : ?>
						<a href="<?php echo esc_url( home_url( '/listings/' ) ); ?>" class="lct-button lct-button--outline">
							<?php esc_html_e( 'Browse Listings', 'listingcore-theme' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( listingcore_theme_has_plugin() ) : ?>

				<!-- Show recent listings as a helpful suggestion -->
				<section class="lct-error-page__suggestions" aria-labelledby="lct-404-suggestions-title">
					<h2 id="lct-404-suggestions-title" class="lct-error-page__suggestions-title">
						<?php esc_html_e( 'You might be interested in', 'listingcore-theme' ); ?>
					</h2>

					<?php echo do_shortcode( '[listingcore_listings count="3"]' ); ?>
				</section>

			<?php else : ?>

				<!-- Fallback: Recent posts -->
				<?php
				$recent_posts = wp_get_recent_posts( [
					'numberposts' => 3,
					'post_status' => 'publish',
				], OBJECT );

				if ( ! empty( $recent_posts ) ) :
					?>
					<section class="lct-error-page__suggestions" aria-labelledby="lct-404-posts-title">
						<h2 id="lct-404-posts-title" class="lct-error-page__suggestions-title">
							<?php esc_html_e( 'Recent Posts', 'listingcore-theme' ); ?>
						</h2>

						<ul class="lct-error-page__post-list">
							<?php foreach ( $recent_posts as $post ) : ?>
								<li>
									<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
										<?php echo esc_html( get_the_title( $post->ID ) ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</section>
				<?php endif; ?>

			<?php endif; ?>

		</div>

	</div>
</main>

<?php
get_footer();