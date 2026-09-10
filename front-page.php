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

<main id="primary" class="lct-main lct-main--front" role="main">

	<?php if ( listingcore_theme_has_plugin() ) : ?>

		<!-- HERO SECTION -->
		<section class="lct-hero" aria-labelledby="lct-hero-title">
			<div class="lct-container">
				<div class="lct-hero__inner">

					<div class="lct-hero__content">
						<h1 id="lct-hero-title" class="lct-hero__title">
							<?php
							$hero_title = get_theme_mod(
								'listingcore_theme_hero_title',
								__( 'Find What You Need, Sell What You Don\'t', 'listingcore-theme' )
							);
							echo esc_html( $hero_title );
							?>
						</h1>

						<p class="lct-hero__subtitle">
							<?php
							$hero_subtitle = get_theme_mod(
								'listingcore_theme_hero_subtitle',
								__( 'Browse thousands of listings across categories. Post your own in minutes.', 'listingcore-theme' )
							);
							echo esc_html( $hero_subtitle );
							?>
						</p>
					</div>

					<div class="lct-hero__search">
						<?php echo do_shortcode( '[listingcore_search_form]' ); ?>
					</div>

					<div class="lct-hero__actions">
						<a href="<?php echo esc_url( home_url( '/submit-listing/' ) ); ?>" class="lct-button lct-button--primary lct-button--lg">
							<?php esc_html_e( 'Post a Listing', 'listingcore-theme' ); ?>
						</a>
						<a href="<?php echo esc_url( home_url( '/listings/' ) ); ?>" class="lct-button lct-button--outline lct-button--lg">
							<?php esc_html_e( 'Browse Listings', 'listingcore-theme' ); ?>
						</a>
					</div>

				</div>
			</div>
		</section>

		<!-- CATEGORIES SECTION -->
		<section class="lct-section lct-section--categories" aria-labelledby="lct-categories-title">
			<div class="lct-container">

				<header class="lct-section__header">
					<h2 id="lct-categories-title" class="lct-section__title">
						<?php esc_html_e( 'Browse by Category', 'listingcore-theme' ); ?>
					</h2>
					<p class="lct-section__subtitle">
						<?php esc_html_e( 'Explore listings by what interests you.', 'listingcore-theme' ); ?>
					</p>
				</header>

				<div class="lct-section__content">
					<?php echo do_shortcode( '[listingcore_categories]' ); ?>
				</div>

			</div>
		</section>

		<!-- FEATURED LISTINGS -->
		<section class="lct-section lct-section--listings" aria-labelledby="lct-listings-title">
			<div class="lct-container">

				<header class="lct-section__header">
					<h2 id="lct-listings-title" class="lct-section__title">
						<?php esc_html_e( 'Latest Listings', 'listingcore-theme' ); ?>
					</h2>
					<p class="lct-section__subtitle">
						<?php esc_html_e( 'Fresh listings from across the marketplace.', 'listingcore-theme' ); ?>
					</p>
				</header>

				<div class="lct-section__content">
					<?php echo do_shortcode( '[listingcore_listings count="6"]' ); ?>
				</div>

				<div class="lct-section__footer">
					<a href="<?php echo esc_url( home_url( '/listings/' ) ); ?>" class="lct-button lct-button--primary">
						<?php esc_html_e( 'View All Listings', 'listingcore-theme' ); ?>
					</a>
				</div>

			</div>
		</section>

		<!-- CTA SECTION -->
		<section class="lct-section lct-section--cta" aria-labelledby="lct-cta-title">
			<div class="lct-container">
				<div class="lct-cta-block">

					<h2 id="lct-cta-title" class="lct-cta-block__title">
						<?php esc_html_e( 'Ready to Post Your Listing?', 'listingcore-theme' ); ?>
					</h2>

					<p class="lct-cta-block__text">
						<?php esc_html_e( 'It takes less than 5 minutes. Free to post. Reach thousands of buyers.', 'listingcore-theme' ); ?>
					</p>

					<a href="<?php echo esc_url( home_url( '/submit-listing/' ) ); ?>" class="lct-button lct-button--primary lct-button--lg">
						<?php esc_html_e( 'Get Started', 'listingcore-theme' ); ?>
					</a>

				</div>
			</div>
		</section>

	<?php else : ?>

		<!-- FALLBACK: Plugin not active -->
		<section class="lct-section lct-section--fallback">
			<div class="lct-container">

				<div class="lct-empty-state">

					<h1 class="lct-empty-state__title">
						<?php bloginfo( 'name' ); ?>
					</h1>

					<p class="lct-empty-state__text">
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
							<a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=listingcore&tab=search&type=term' ) ); ?>" class="lct-button lct-button--primary">
								<?php esc_html_e( 'Install ListingCore Plugin', 'listingcore-theme' ); ?>
							</a>
						</p>
					<?php endif; ?>

					<?php if ( have_posts() ) : ?>
						<div class="lct-latest-posts">
							<h2 class="lct-latest-posts__title">
								<?php esc_html_e( 'Latest Posts', 'listingcore-theme' ); ?>
							</h2>
							<?php
							while ( have_posts() ) :
								the_post();
								?>
								<article class="lct-post-summary">
									<h3 class="lct-post-summary__title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<div class="lct-post-summary__excerpt">
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