<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package ListingCoreTheme
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="no-results not-found" style="background: #ffffff; padding: 40px; border-radius: 12px; border: 1px solid #e2e8f0; text-align: center; color: #475569; width: 100%;">
	<header class="page-header" style="margin-bottom: 20px;">
		<h2 class="page-title" style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 0;"><?php esc_html_e( 'Nothing Found Match Your Request', 'listingcore-theme' ); ?></h2>
	</header>

	<div class="page-content" style="max-width: 500px; margin: 0 auto; line-height: 1.6;">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %s: Link to WP admin area to write first listing. */
						__( 'Ready to publish your first marketplace ad? <a href="%s">Get started here</a>.', 'listingcore-theme' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'post-new.php?post_type=listingcore' ) )
				);
				?>
			</p>
		<?php elseif ( is_search() ) : ?>
			<p style="margin-bottom: 25px; color: #64748b;"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords or clear your vertical filter checkboxes.', 'listingcore-theme' ); ?></p>
			<div style="display: flex; justify-content: center;">
				<?php get_search_form(); ?>
			</div>
		<?php else : ?>
			<p style="margin-bottom: 25px; color: #64748b;"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help resolve the engine search query.', 'listingcore-theme' ); ?></p>
			<div style="display: flex; justify-content: center;">
				<?php get_search_form(); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
