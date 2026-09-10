<?php
/**
 * Main template file.
 *
 * The fallback template used by WordPress when no more specific
 * template file matches the current query.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="listingcore-main" role="main">
	<div class="listingcore-container">

		<?php
		// Breadcrumbs (only on non-front pages).
		if ( ! is_front_page() ) {
			listingcore_theme_breadcrumbs();
		}
		?>

		<div class="listingcore-layout <?php echo esc_attr( listingcore_theme_get_layout_class() ); ?>">

			<div class="listingcore-layout__main">

				<?php if ( have_posts() ) : ?>

					<?php if ( is_home() && ! is_front_page() ) : ?>
						<header class="listingcore-page-header">
							<h1 class="listingcore-page-title"><?php single_post_title(); ?></h1>
						</header>
					<?php endif; ?>

					<div class="listingcore-posts">

						<?php
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content', get_post_type() );
						endwhile;
						?>

					</div>

					<?php
					// Pagination.
					listingcore_theme_pagination();
					?>

				<?php else : ?>

					<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>
</main>

<?php
get_footer();