<?php
/**
 * Listing category archive template.
 *
 * Displays listings within a specific listing category.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$listingcore_theme_term = get_queried_object();
?>

<main id="primary" class="listingcore-main listingcore-main--taxonomy-listing" role="main">
	<div class="listingcore-container">

		<?php listingcore_theme_breadcrumbs(); ?>

		<header class="listingcore-page-header listingcore-page-header--category">

			<?php if ( $listingcore_theme_term && ! empty( $listingcore_theme_term->description ) ) : ?>
				<div class="listingcore-page-header__description">
					<?php echo wp_kses_post( wpautop( $listingcore_theme_term->description ) ); ?>
				</div>
			<?php endif; ?>

			<h1 class="listingcore-page-header__title">
				<?php
				if ( $listingcore_theme_term ) {
					printf(
						/* translators: %s: category name */
						esc_html__( 'Listings in %s', 'listingcore-theme' ),
						'<span class="listingcore-page-header__term">' . esc_html( $listingcore_theme_term->name ) . '</span>'
					);
				} else {
					esc_html_e( 'Listings', 'listingcore-theme' );
				}
				?>
			</h1>

			<?php
			global $wp_query;
			$listingcore_theme_total = $wp_query->found_posts;
			?>

			<?php if ( $listingcore_theme_total > 0 ) : ?>
				<p class="listingcore-page-header__meta">
					<?php
					printf(
						/* translators: %s: listing count */
						esc_html( _n( '%s listing', '%s listings', $listingcore_theme_total, 'listingcore-theme' ) ),
						number_format_i18n( $listingcore_theme_total )
					);
					?>
				</p>
			<?php endif; ?>

			<?php if ( listingcore_theme_has_plugin() ) : ?>
				<div class="listingcore-page-header__actions">
					<a href="<?php echo esc_url( home_url( '/submit-listing/' ) ); ?>" class="listingcore-button listingcore-button--primary">
						<?php esc_html_e( 'Post a Listing', 'listingcore-theme' ); ?>
					</a>
				</div>
			<?php endif; ?>

		</header>

		<?php
		// Sub-categories (if any).
		if ( $listingcore_theme_term ) {
			$listingcore_theme_children = get_terms( [
				'taxonomy'   => 'listing_category',
				'parent'     => $listingcore_theme_term->term_id,
				'hide_empty' => false,
			] );

			if ( ! empty( $listingcore_theme_children ) && ! is_wp_error( $listingcore_theme_children ) ) :
				?>
				<div class="listingcore-subcategories">
					<h2 class="listingcore-subcategories__title">
						<?php esc_html_e( 'Sub-categories', 'listingcore-theme' ); ?>
					</h2>
					<ul class="listingcore-subcategories__list">
						<?php foreach ( $listingcore_theme_children as $child ) : ?>
							<li class="listingcore-subcategories__item">
								<a href="<?php echo esc_url( get_term_link( $child ) ); ?>">
									<?php echo esc_html( $child->name ); ?>
									<span class="listingcore-subcategories__count">
										(<?php echo esc_html( number_format_i18n( $child->count ) ); ?>)
									</span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		<?php } ?>

		<div class="listingcore-layout <?php echo esc_attr( listingcore_theme_get_layout_class() ); ?>">

			<div class="listingcore-layout__main">

				<?php if ( listingcore_theme_has_plugin() ) : ?>

					<?php
					// Plugin handles the listing loop and card rendering.
					echo do_shortcode( '[listingcore_listings]' );
					?>

				<?php elseif ( have_posts() ) : ?>

					<div class="listingcore-posts listingcore-posts--listing">

						<?php
						while ( have_posts() ) :
							the_post();
							?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'listingcore-listing-card' ); ?>>

								<a href="<?php the_permalink(); ?>" class="listingcore-listing-card__thumbnail-link" aria-hidden="true" tabindex="-1">
									<?php listingcore_theme_post_thumbnail( get_the_ID(), 'listingcore-listing-grid' ); ?>
								</a>

								<div class="listingcore-listing-card__body">
									<h2 class="listingcore-listing-card__title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h2>

									<div class="listingcore-listing-card__excerpt">
										<?php the_excerpt(); ?>
									</div>

									<a href="<?php the_permalink(); ?>" class="listingcore-listing-card__link">
										<?php esc_html_e( 'View Listing', 'listingcore-theme' ); ?>
									</a>
								</div>

							</article>

						<?php endwhile; ?>

					</div>

					<?php listingcore_theme_pagination(); ?>

				<?php else : ?>

					<div class="listingcore-empty-state">
						<h2 class="listingcore-empty-state__title">
							<?php esc_html_e( 'No listings in this category', 'listingcore-theme' ); ?>
						</h2>
						<p class="listingcore-empty-state__text">
							<?php esc_html_e( 'There are no listings in this category yet. Be the first to post one!', 'listingcore-theme' ); ?>
						</p>

						<?php if ( listingcore_theme_has_plugin() ) : ?>
							<a href="<?php echo esc_url( home_url( '/submit-listing/' ) ); ?>" class="listingcore-button listingcore-button--primary">
								<?php esc_html_e( 'Post a Listing', 'listingcore-theme' ); ?>
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