<?php
/**
 * Front page template.
 *
 * Displays the homepage layout. When the ListingCore plugin is active,
 * this shows a hero section, categories, and featured listings.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="listingcore-main listingcore-main--front" role="main">

	<?php if ( listingcore_theme_has_plugin() ) : ?>

		<!-- HERO SECTION -->
		<section class="listingcore-hero" aria-labelledby="listingcore-hero-title">
			<div class="listingcore-container">
				<div class="listingcore-hero__inner">

					<div class="listingcore-hero__content">
						<h1 id="listingcore-hero-title" class="listingcore-hero__title">
							<?php
							$hero_title = get_theme_mod(
								'listingcore_theme_hero_title',
								__( 'Find What You Need, Sell What You Don\'t', 'listingcore-theme' )
							);
							echo esc_html( $hero_title );
							?>
						</h1>

						<p class="listingcore-hero__subtitle">
							<?php
							$hero_subtitle = get_theme_mod(
								'listingcore_theme_hero_subtitle',
								__( 'Browse thousands of listings across categories. Post your own in minutes.', 'listingcore-theme' )
							);
							echo esc_html( $hero_subtitle );
							?>
						</p>
					</div>

					<div class="listingcore-hero__search">
						<?php echo do_shortcode( '[listingcore_search_form]' ); ?>
					</div>

					<div class="listingcore-hero__actions">
						<a href="<?php echo esc_url( home_url( '/submit-listing/' ) ); ?>" class="listingcore-button listingcore-button--primary listingcore-button--lg">
							<?php esc_html_e( 'Post a Listing', 'listingcore-theme' ); ?>
						</a>
						<a href="<?php echo esc_url( home_url( '/listings/' ) ); ?>" class="listingcore-button listingcore-button--outline listingcore-button--lg">
							<?php esc_html_e( 'Browse Listings', 'listingcore-theme' ); ?>
						</a>
					</div>

				</div>
			</div>
		</section>

		<!-- CATEGORIES SECTION -->
		<section class="listingcore-section listingcore-section--categories" aria-labelledby="listingcore-categories-title">
			<div class="listingcore-container">

				<header class="listingcore-section__header">
					<h2 id="listingcore-categories-title" class="listingcore-section__title">
						<?php esc_html_e( 'Browse by Category', 'listingcore-theme' ); ?>
					</h2>
					<p class="listingcore-section__subtitle">
						<?php esc_html_e( 'Explore listings by what interests you.', 'listingcore-theme' ); ?>
					</p>
				</header>

				<div class="listingcore-section__content">
					<?php echo do_shortcode( '[listingcore_categories]' ); ?>
				</div>

			</div>
		</section>

		<!-- FEATURED LISTINGS -->
		<section class="listingcore-section listingcore-section--listings" aria-labelledby="listingcore-listings-title">
			<div class="listingcore-container">

				<header class="listingcore-section__header">
					<h2 id="listingcore-listings-title" class="listingcore-section__title">
						<?php esc_html_e( 'Latest Listings', 'listingcore-theme' ); ?>
					</h2>
					<p class="listingcore-section__subtitle">
						<?php esc_html_e( 'Fresh listings from across the marketplace.', 'listingcore-theme' ); ?>
					</p>
				</header>

				<div class="listingcore-section__content">
					<?php echo do_shortcode( '[listingcore_listings count="6"]' ); ?>
				</div>

				<div class="listingcore-section__footer">
					<a href="<?php echo esc_url( home_url( '/listings/' ) ); ?>" class="listingcore-button listingcore-button--primary">
						<?php esc_html_e( 'View All Listings', 'listingcore-theme' ); ?>
					</a>
				</div>

			</div>
		</section>

		<!-- CTA SECTION -->
		<section class="listingcore-section listingcore-section--cta" aria-labelledby="listingcore-cta-title">
			<div class="listingcore-container">
				<div class="listingcore-cta-block">

					<h2 id="listingcore-cta-title" class="listingcore-cta-block__title">
						<?php esc_html_e( 'Ready to Post Your Listing?', 'listingcore-theme' ); ?>
					</h2>

					<p class="listingcore-cta-block__text">
						<?php esc_html_e( 'It takes less than 5 minutes. Free to post. Reach thousands of buyers.', 'listingcore-theme' ); ?>
					</p>

					<a href="<?php echo esc_url( home_url( '/submit-listing/' ) ); ?>" class="listingcore-button listingcore-button--primary listingcore-button--lg">
						<?php esc_html_e( 'Get Started', 'listingcore-theme' ); ?>
					</a>

				</div>
			</div>
		</section>

	<?php else : ?>

		<!-- FALLBACK: Plugin not active -->
		<section class="listingcore-section listingcore-section--fallback">
			<div class="listingcore-container">

				<div class="listingcore-empty-state">

					<h1 class="listingcore-empty-state__title">
						<?php bloginfo( 'name' ); ?>
					</h1>

					<p class="listingcore-empty-state__text">
						<?php
						$description = get_bloginfo( 'description', 'display' );
						if ( $description ) {
							echo esc_html( $description );
						} else {
							esc_html_e( 'Install the ListingCore plugin to unlock listings, categories, search, and more.', 'listingcore-theme' );
						}
						?>
					</p>

					<?php if ( current_user_can( 'install_plugins' ) ) : ?>
						<p>
							<a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=listingcore&tab=search&type=term' ) ); ?>" class="listingcore-button listingcore-button--primary">
								<?php esc_html_e( 'Install ListingCore Plugin', 'listingcore-theme' ); ?>
							</a>
						</p>
					<?php endif; ?>

					<?php if ( have_posts() ) : ?>
						<div class="listingcore-latest-posts">
							<h2 class="listingcore-latest-posts__title">
								<?php esc_html_e( 'Latest Posts', 'listingcore-theme' ); ?>
							</h2>
							<?php
							while ( have_posts() ) :
								the_post();
								?>
								<article class="listingcore-post-summary">
									<h3 class="listingcore-post-summary__title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<div class="listingcore-post-summary__excerpt">
										<?php the_excerpt(); ?>
									</div>
								</article>
								<?php
							endwhile;
							?>
						</div>
					<?php endif; ?>

				</div>

			</div>
		</section>

	<?php endif; ?>

</main>

<?php
get_footer();