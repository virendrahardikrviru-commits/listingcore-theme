<?php
/**
 * Template Name: Submit Listing
 * Template Post Type: page
 *
 * Displays the listing submission form via the ListingCore plugin.
 * Users create a page and select "Submit Listing" as the template.
 *
 * @package ListingCoreTheme
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="lct-main lct-main--template-submit" role="main">
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

							<?php if ( get_the_content() ) : ?>
								<div class="lct-submit-page__description">
									<?php the_content(); ?>
								</div>
							<?php endif; ?>
						</header>

						<?php if ( listingcore_theme_has_plugin() ) : ?>

							<?php if ( ! is_user_logged_in() ) : ?>

								<div class="lct-notice lct-notice--info">
									<h2 class="lct-notice__title">
										<?php esc_html_e( 'Log in to Post a Listing', 'listingcore-theme' ); ?>
									</h2>
									<p>
										<?php esc_html_e( 'You need to be logged in to post a listing. Log in or create a free account to get started.', 'listingcore-theme' ); ?>
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

								<div class="lct-submit-page__form">
									<?php
									/**
									 * The ListingCore plugin handles the actual submission form:
									 * validation, file uploads, custom fields, and persistence.
									 */
									echo do_shortcode( '[listingcore_listing_form]' );
									?>
								</div>

							<?php endif; ?>

						<?php else : ?>

							<div class="lct-notice lct-notice--warning">
								<h2 class="lct-notice__title">
									<?php esc_html_e( 'ListingCore Plugin Required', 'listingcore-theme' ); ?>
								</h2>
								<p>
									<?php esc_html_e( 'The listing submission form is powered by the ListingCore plugin. Please install and activate it to enable listing submissions.', 'listingcore-theme' ); ?>
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