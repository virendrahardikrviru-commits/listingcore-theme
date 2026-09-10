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

<main id="primary" class="lct-main" role="main">
	<div class="lct-container">

		<?php listingcore_theme_breadcrumbs(); ?>

		<div class="lct-layout <?php echo esc_attr( listingcore_theme_get_layout_class() ); ?>">

			<div class="lct-layout__main">

				<?php
				while ( have_posts() ) :
					the_post();
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'lct-page' ); ?>>

						<header class="lct-page__header">
							<h1 class="lct-page__title"><?php the_title(); ?></h1>
						</header>

						<?php if ( has_post_thumbnail() ) : ?>
							<div class="lct-page__thumbnail">
								<?php the_post_thumbnail( 'lct-listing-single' ); ?>
							</div>
						<?php endif; ?>

						<div class="lct-page__content">
							<?php
							the_content();

							wp_link_pages( [
								'before' => '<nav class="lct-page-links"><span class="lct-page-links__label">' . esc_html__( 'Pages:', 'listingcore-theme' ) . '</span>',
								'after'  => '</nav>',
							] );
							?>
						</div>

						<?php if ( get_edit_post_link() ) : ?>
							<footer class="lct-page__footer">
								<?php
								edit_post_link(
									sprintf(
										/* translators: %s: page title */
										esc_html__( 'Edit %s', 'listingcore-theme' ),
										'<span class="screen-reader-text">' . get_the_title() . '</span>'
									),
									'<span class="lct-page__edit-link">',
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