<?php
/**
 * Search results template.
 *
 * Displays search results for blog posts and pages.
 * Listing searches are handled by the ListingCore plugin.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="listingcore-main listingcore-main--search" role="main">
	<div class="listingcore-container">

		<?php listingcore_theme_breadcrumbs(); ?>

		<header class="listingcore-page-header">
			<h1 class="listingcore-page-header__title">
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Search Results for: %s', 'listingcore-theme' ),
					'<span class="listingcore-page-header__query">' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>

			<?php
			global $wp_query;
			$total_results = $wp_query->found_posts;
			?>

			<?php if ( $total_results > 0 ) : ?>
				<p class="listingcore-page-header__meta">
					<?php
					printf(
						/* translators: %s: number of results */
						esc_html( _n( '%s result found', '%s results found', $total_results, 'listingcore-theme' ) ),
						number_format_i18n( $total_results )
					);
					?>
				</p>
			<?php endif; ?>
		</header>

		<div class="listingcore-layout <?php echo esc_attr( listingcore_theme_get_layout_class() ); ?>">

			<div class="listingcore-layout__main">

				<?php if ( have_posts() ) : ?>

					<div class="listingcore-posts listingcore-posts--search">

						<?php
						while ( have_posts() ) :
							the_post();
							?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'listingcore-search-result' ); ?>>

								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>" class="listingcore-search-result__thumbnail" aria-hidden="true" tabindex="-1">
										<?php the_post_thumbnail( 'listingcore-listing-grid' ); ?>
									</a>
								<?php endif; ?>

								<div class="listingcore-search-result__content">

									<h2 class="listingcore-search-result__title">
										<a href="<?php the_permalink(); ?>">
											<?php the_title(); ?>
										</a>
									</h2>

									<div class="listingcore-search-result__meta">
										<span class="listingcore-search-result__type">
											<?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?>
										</span>
										<span class="listingcore-search-result__meta-sep">·</span>
										<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
											<?php echo esc_html( get_the_date() ); ?>
										</time>
									</div>

									<div class="listingcore-search-result__excerpt">
										<?php the_excerpt(); ?>
									</div>

									<a href="<?php the_permalink(); ?>" class="listingcore-search-result__link">
										<?php esc_html_e( 'Read more', 'listingcore-theme' ); ?>
										<span class="screen-reader-text">
											<?php
											printf(
												/* translators: %s: post title */
												esc_html__( 'about %s', 'listingcore-theme' ),
												esc_html( get_the_title() )
											);
											?>
										</span>
									</a>

								</div>

							</article>

						<?php endwhile; ?>

					</div>

					<?php listingcore_theme_pagination(); ?>

				<?php else : ?>

					<div class="listingcore-empty-state">

						<h2 class="listingcore-empty-state__title">
							<?php esc_html_e( 'No results found', 'listingcore-theme' ); ?>
						</h2>

						<p class="listingcore-empty-state__text">
							<?php esc_html_e( 'Sorry, nothing matched your search. Please try again with different keywords.', 'listingcore-theme' ); ?>
						</p>

						<div class="listingcore-empty-state__search">
							<?php get_search_form(); ?>
						</div>

						<?php if ( listingcore_theme_has_plugin() ) : ?>
							<p class="listingcore-empty-state__hint">
								<?php esc_html_e( 'Looking for listings? Try browsing all listings instead.', 'listingcore-theme' ); ?>
							</p>
							<a href="<?php echo esc_url( home_url( '/listings/' ) ); ?>" class="listingcore-button listingcore-button--primary">
								<?php esc_html_e( 'Browse Listings', 'listingcore-theme' ); ?>
							</a>
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