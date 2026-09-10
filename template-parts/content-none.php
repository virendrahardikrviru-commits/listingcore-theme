<?php
/**
 * Template part for displaying a message when no content is found.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="lct-no-results">

	<header class="lct-no-results__header">

		<h2 class="lct-no-results__title">
			<?php
			if ( is_search() ) {
				esc_html_e( 'Nothing Found', 'listingcore-theme' );
			} elseif ( is_home() && current_user_can( 'publish_posts' ) ) {
				esc_html_e( 'Ready to publish your first post?', 'listingcore-theme' );
			} else {
				esc_html_e( 'No content found', 'listingcore-theme' );
			}
			?>
		</h2>

	</header>

	<div class="lct-no-results__content">

		<?php if ( is_search() ) : ?>

			<p>
				<?php esc_html_e( 'Sorry, no results matched your search. Please try again with different keywords.', 'listingcore-theme' ); ?>
			</p>

			<div class="lct-no-results__search">
				<?php get_search_form(); ?>
			</div>

			<?php if ( listingcore_theme_has_plugin() ) : ?>
				<p class="lct-no-results__hint">
					<?php esc_html_e( 'Looking for listings? Try browsing all listings instead.', 'listingcore-theme' ); ?>
				</p>
				<p>
					<a href="<?php echo esc_url( home_url( '/listings/' ) ); ?>" class="lct-button lct-button--primary">
						<?php esc_html_e( 'Browse Listings', 'listingcore-theme' ); ?>
					</a>
				</p>
			<?php endif; ?>

		<?php elseif ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php
				printf(
					/* translators: %s: new post URL */
					wp_kses(
						__( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'listingcore-theme' ),
						[ 'a' => [ 'href' => [] ] ]
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>

		<?php elseif ( is_home() ) : ?>

			<p>
				<?php esc_html_e( 'No posts have been published yet. Please check back soon.', 'listingcore-theme' ); ?>
			</p>

		<?php else : ?>

			<p>
				<?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'listingcore-theme' ); ?>
			</p>

			<div class="lct-no-results__search">
				<?php get_search_form(); ?>
			</div>

		<?php endif; ?>

	</div>

</section>