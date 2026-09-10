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

<main id="primary" class="lct-main" role="main">
	<div class="lct-container">

		<?php
		// Breadcrumbs (only on non-front pages).
		if ( ! is_front_page() ) {
			listingcore_theme_breadcrumbs();
		}
		?>

		<div class="lct-layout <?php echo esc_attr( listingcore_theme_get_layout_class() ); ?>">

			<div class="lct-layout__main">

				<?php if ( have_posts() ) : ?>

					<?php if ( is_home() && ! is_front_page() ) : ?>
						<header class="lct-page-header">
							<h1 class="lct-page-title"><?php single_post_title(); ?></h1>
						</header>
					<?php endif; ?>

					<div class="lct-posts">

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