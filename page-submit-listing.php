<?php
/**
 * Template Name: Submit Listing
 *
 * Submission page template. The ListingCore plugin provides the form
 * via shortcode, and the theme handles the presentation wrapper.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="lct-main lct-main--submit-listing" role="main">
	<div class="lct-container">

		<?php listingcore_theme_breadcrumbs(); ?>

		<div class="lct-layout <?php echo esc_attr( listingcore_theme_get_layout_class() ); ?>">

			<div class="lct-layout__main">

				<?php
				while ( have_posts() ) :
					the_post();
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'lct-submit-page' ); ?>>

						<header class="lct-submit-page__header">
							<h1 class="lct-submit-page__title"><?php the_title(); ?></h1>
						</header>

						<?php if ( listingcore_theme_has_plugin() ) : ?>

							<?php
							// Check if user is logged in (configurable).
							if ( ! is_user_logged_in() ) :
								?>
								<div class="lct-notice lct-notice--info">
									<p>
										<?php esc_html_e( 'You need to be logged in to post a listing.', 'listingcore-theme' ); ?>
									</p>
									<p>
										<a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="lct-button lct-button--primary">
											<?php esc_html_e( 'Log in', 'listingcore-theme' ); ?>
										</a>
										<?php if ( get_option( 'users_can_register' ) ) : ?>
											<a href="<?php echo esc_url( wp_registration_url() ); ?>" class="lct-button lct-button--outline">
												<?php esc_html_e( 'Register', 'listingcore-theme' ); ?>
											</a>
										<?php endif; ?>
									</p>
								</div>
							<?php else : ?>

								<div class="lct-submit-page__content">
									<?php the_content(); ?>

									<?php
									// The plugin handles the actual form rendering.
									echo do_shortcode( '[listingcore_listing_form]' );
									?>
								</div>

							<?php endif; ?>

						<?php else : ?>

							<?php the_content(); ?>

							<div class="lct-notice lct-notice--warning">
								<p>
									<?php esc_html_e( 'The ListingCore plugin is required to submit listings. Please install and activate it.', 'listingcore-theme' ); ?>
								</p>

								<?php if ( current_user_can( 'install_plugins' ) ) : ?>
									<p>
										<a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=listingcore&tab=search&type=term' ) ); ?>" class="lct-button lct-button--primary">
											<?php esc_html_e( 'Install ListingCore', 'listingcore-theme' ); ?>
										</a>
									</p>
								<?php endif; ?>
							</div>

						<?php endif; ?>

					</article>

				<?php endwhile; ?>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>
</main>

<?php
get_footer();