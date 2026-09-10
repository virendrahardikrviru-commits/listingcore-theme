<?php
/**
 * Single listing template.
 *
 * Displays a single listing. Uses the ListingCore plugin's shortcode
 * and template system where available.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="listingcore-main listingcore-main--single-listing" role="main">

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'listingcore-listing' ); ?>>

			<div class="listingcore-container">

				<?php listingcore_theme_breadcrumbs(); ?>

				<div class="listingcore-layout <?php echo esc_attr( listingcore_theme_get_layout_class() ); ?>">

					<div class="listingcore-layout__main">

						<header class="listingcore-listing__header">

							<div class="listingcore-listing__categories">
								<?php
								$terms = get_the_terms( get_the_ID(), 'listing_category' );
								if ( $terms && ! is_wp_error( $terms ) ) {
									foreach ( $terms as $term ) {
										printf(
											'<a href="%1$s" class="listingcore-listing__category">%2$s</a>',
											esc_url( get_term_link( $term ) ),
											esc_html( $term->name )
										);
									}
								}
								?>
							</div>

							<h1 class="listingcore-listing__title"><?php the_title(); ?></h1>

							<div class="listingcore-listing__meta">
								<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
									<?php echo esc_html( get_the_date() ); ?>
								</time>

								<?php if ( listingcore_theme_has_plugin() ) : ?>
									<?php
									$views = (int) get_post_meta( get_the_ID(), '_listingcore_views', true );
									if ( $views > 0 ) :
										?>
										<span class="listingcore-listing__meta-sep">·</span>
										<span class="listingcore-listing__views">
											<?php
											printf(
												/* translators: %s: view count */
												esc_html( _n( '%s view', '%s views', $views, 'listingcore-theme' ) ),
												number_format_i18n( $views )
											);
											?>
										</span>
									<?php endif; ?>
								<?php endif; ?>
							</div>

						</header>

						<?php if ( has_post_thumbnail() ) : ?>
							<div class="listingcore-listing__gallery">
								<?php the_post_thumbnail( 'listingcore-listing-single' ); ?>

								<?php
								// Additional gallery images (if using native WP gallery).
								$gallery_images = get_post_meta( get_the_ID(), '_listingcore_gallery', true );
								if ( ! empty( $gallery_images ) && is_array( $gallery_images ) ) :
									?>
									<div class="listingcore-listing__gallery-thumbs">
										<?php foreach ( $gallery_images as $image_id ) : ?>
											<?php echo wp_get_attachment_image( $image_id, 'listingcore-listing-thumb', false, [ 'loading' => 'lazy' ] ); ?>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<div class="listingcore-listing__content">
							<?php the_content(); ?>
						</div>

						<?php
						/**
						 * Listing details (custom fields from ListingCore plugin).
						 * Rendered by the plugin's FieldRegistry if available.
						 */
						if ( listingcore_theme_has_plugin() && class_exists( 'ListingCore\\Listings\\FieldRegistry' ) ) {
							$fields = \ListingCore\Listings\FieldRegistry::get_fields();

							if ( ! empty( $fields ) ) {
								echo '<div class="listingcore-listing__details">';
								echo '<h2 class="listingcore-listing__details-title">' . esc_html__( 'Listing Details', 'listingcore-theme' ) . '</h2>';
								echo '<dl class="listingcore-listing__details-list">';

								foreach ( $fields as $key => $field ) {
									$value = get_post_meta( get_the_ID(), $key, true );

									if ( '' === $value || null === $value ) {
										continue;
									}

									$label = isset( $field['label'] ) ? $field['label'] : $key;

									printf(
										'<dt class="listingcore-listing__detail-label">%1$s</dt><dd class="listingcore-listing__detail-value">%2$s</dd>',
										esc_html( $label ),
										esc_html( is_array( $value ) ? implode( ', ', $value ) : (string) $value )
									);
								}

								echo '</dl>';
								echo '</div>';
							}
						}
						?>

						<?php
						// Tags.
						$tags = get_the_term_list( get_the_ID(), 'listing_tag', '', ', ' );
						if ( $tags && ! is_wp_error( $tags ) ) :
							?>
							<div class="listingcore-listing__tags">
								<?php echo wp_kses_post( $tags ); ?>
							</div>
						<?php endif; ?>

						<?php
						// Contact form (from plugin if available).
						if ( listingcore_theme_has_plugin() ) {
							echo '<div class="listingcore-listing__contact">';
							echo do_shortcode( '[listingcore_contact_form]' );
							echo '</div>';
						}
						?>

						<?php
						// Post navigation between listings.
						the_post_navigation( [
							'prev_text' => '<span class="listingcore-post-nav__label">' . esc_html__( 'Previous listing', 'listingcore-theme' ) . '</span><span class="listingcore-post-nav__title">%title</span>',
							'next_text' => '<span class="listingcore-post-nav__label">' . esc_html__( 'Next listing', 'listingcore-theme' ) . '</span><span class="listingcore-post-nav__title">%title</span>',
							'class'     => 'listingcore-post-nav listingcore-post-nav--listing',
						] );
						?>

						<?php if ( get_edit_post_link() ) : ?>
							<footer class="listingcore-listing__footer">
								<?php
								edit_post_link(
									sprintf(
										/* translators: %s: listing title */
										esc_html__( 'Edit %s', 'listingcore-theme' ),
										'<span class="screen-reader-text">' . get_the_title() . '</span>'
									),
									'<span class="listingcore-listing__edit-link">',
									'</span>'
								);
								?>
							</footer>
						<?php endif; ?>

					</div>

					<?php get_sidebar(); ?>

				</div>

			</div>

		</article>

		<?php
		// Comments for listings (if enabled).
		if ( comments_open() || get_comments_number() ) {
			echo '<div class="listingcore-container">';
			comments_template();
			echo '</div>';
		}

	endwhile;
	?>

</main>

<?php
get_footer();