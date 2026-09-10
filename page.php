<?php
/**
 * Page template.
 *
 * Displays standard WordPress pages.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="listingcore-main" role="main">
	<div class="listingcore-container">

		<?php listingcore_theme_breadcrumbs(); ?>

		<div class="listingcore-layout <?php echo esc_attr( listingcore_theme_get_layout_class() ); ?>">

			<div class="listingcore-layout__main">

				<?php
				while ( have_posts() ) :
					the_post();
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'listingcore-page' ); ?>>

						<header class="listingcore-page__header">
							<h1 class="listingcore-page__title"><?php the_title(); ?></h1>
						</header>

						<?php if ( has_post_thumbnail() ) : ?>
							<div class="listingcore-page__thumbnail">
								<?php the_post_thumbnail( 'listingcore-listing-single' ); ?>
							</div>
						<?php endif; ?>

						<div class="listingcore-page__content">
							<?php
							the_content();

							wp_link_pages( [
								'before' => '<nav class="listingcore-page-links"><span class="listingcore-page-links__label">' . esc_html__( 'Pages:', 'listingcore-theme' ) . '</span>',
								'after'  => '</nav>',
							] );
							?>
						</div>

						<?php if ( get_edit_post_link() ) : ?>
							<footer class="listingcore-page__footer">
								<?php
								edit_post_link(
									sprintf(
										/* translators: %s: page title */
										esc_html__( 'Edit %s', 'listingcore-theme' ),
										'<span class="screen-reader-text">' . get_the_title() . '</span>'
									),
									'<span class="listingcore-page__edit-link">',
									'</span>'
								);
								?>
							</footer>
						<?php endif; ?>

					</article>

					<?php
					// Comments (if enabled and open).
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}

				endwhile;
				?>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>
</main>

<?php
get_footer();